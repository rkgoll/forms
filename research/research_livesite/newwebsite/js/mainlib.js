/*

xlimit ARP/CurrentPayment/Balance
xadd overlays indicating minpay/currentpay
xfix colors of the curves
xrefresh graph at start
xcurve labels
xpaydown table
xturn off curves selectively
xadd logarithmic scale

connect terms with current payments slider
make the boxes appear one after another
add detailed graphs
dynamic mp limit
collect preferences / request quote
add calculator link to sign-up page

 */


'use strict';

function replaceAll(find, replace, str) {
    return str.replace(new RegExp(find, 'g'), replace);
}

// create module for custom directives
var LendLiftDebtCalc = angular.module('LendLiftDebtCalc', ['uiSlider','ui.bootstrap','ngCookies', 'angulartics', 'angulartics.google.analytics']);


function CarouselCtrl($scope) {
  
}

//fix a bug with http post
LendLiftDebtCalc.config(['$httpProvider', function($httpProvider) {
    // This code is taken from http://victorblog.com/2012/12/20/make-angularjs-http-service-behave-like-jquery-ajax/
// Use x-www-form-urlencoded Content-Type
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

// Override $http service's default transformRequest
    $httpProvider.defaults.transformRequest = [function(data) {
        /**
         * The workhorse; converts an object to x-www-form-urlencoded serialization.
         * @param {Object} obj
         * @return {String}
         */
        var param = function(obj) {
            var query = '';
            var name, value, fullSubName, subValue, innerObj, i;
            for(name in obj) {
                value = obj[name];
                if(value instanceof Array) {
                    for(i=0; i<value.length; ++i) {
                        subValue = value[i];
                        fullSubName = name + '[' + i + ']';
                        innerObj = {};
                        innerObj[fullSubName] = subValue;
                        query += param(innerObj) + '&';
                    }
                } else if(value instanceof Object) {
                    for(i=0; i<value.length; ++i) {
                        subValue = value[i];
                        //subValue = value[subName];
                        fullSubName = name + '[' + subName + ']';
                        innerObj = {};
                        innerObj[fullSubName] = subValue;
                        query += param(innerObj) + '&';
                    }
                } else if(value !== undefined && value !== null) {
                    query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
                }
            }
            return query.length ? query.substr(0, query.length - 1) : query;
        };
        return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
    }];

}]);

// controller business logic
LendLiftDebtCalc.controller('AppCtrl', function AppCtrl ($scope, $http, $modal, $cookies) {

    /*$scope.$on('$viewContentLoaded', function(event) {
		$window._gaq.push(['_trackPageview', $location.path()]);
		console.log('pushing data to Google');
	});*/
	
	$scope.sliders = {
        payment: 225,
        terms: 36,
        currentpayment: 0,
        minpayment:0,
        minterms: 0,
        currentterms: 0,
        floatceiling: 1000,
        maxmonths:84

    };

    //set default values
    $scope.txtBalance = 7500;
    $scope.txtAPR = 25;
    $scope.txtCurrentPayment = 250;

    $scope.chkMinPay=false;
    $scope.chkCurPay=false;
    $scope.chkAdjPay=true;

    $scope.savings=0;

    $scope.rows = [];

    $scope.minimumPaymentOverlayStyle = function(obj)
    {
        obj.style= { "background-color": "red"};
    };

    $scope.currencyFormatting = function(value)
    {
        return "$ " + value.toString().split('.')[0];
    };
    $scope.dateFormatting = function(value)
    {
        var d = new Date();
        d.setMonth(d.getMonth() + parseInt(value));

		var monthNames = [ "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December", "January" ];
		
        var curr_date = d.getDate();
        var curr_month = d.getMonth();
        var curr_year = d.getYear()+2000-100;

        if(value == "1" || value == "60")
            return monthNames[curr_month].substring(0,3) + "/" + curr_year;
        else
            return value + " months";
    };


    var generatePayDownData = function($balance, $apr, $currentPayment, $adjpayment, $terms, $whatToRedraw) {

        var curves = ["[min payoff]","[current payoff]","[adj payoff]"];

		//console.log($apr);
		//console.log($balance);
		//console.log($currentPayment);
		
		if(isNaN($apr)) 
			$apr = 25;
			
        if($apr < 0) 
			$apr = 25;
        
		if($apr > 35) 
			$apr = 35;
		
        if(isNaN($balance) || $balance <= 0) $balance = 7500;
        if(isNaN($balance) || $balance > 100000) $balance = 100000;
        if(isNaN($currentPayment) || $currentPayment <= 0) $currentPayment = 250;

        $scope.sliders.floatceiling = $balance;

        var fCurrentPayment = parseFloat($currentPayment);
        var fAdjPayment = parseFloat($adjpayment);

        var minPayPct = .03;
        var minPMT=$balance*minPayPct

        var apr=[$apr,$apr,$apr];
        var rate=[$apr / 100 / 12, $apr / 100 / 12, $apr / 100 / 12];
        var principal=[$balance,$balance,$balance];
        var lastPoint=[1,1,1];


        if($whatToRedraw == "terms")
        {
            //calculate monthly rate
            var pow=1.0;
            for(var i=0;i < $terms; i++)
               pow *= (1.0 + rate[0]);

            fAdjPayment = ($balance * pow *rate[0]) / (pow - 1);
        }

        var pmt = [$balance*minPayPct, fCurrentPayment < minPMT ? minPMT : fCurrentPayment, fAdjPayment < minPMT ? minPMT : fAdjPayment];
        var totalTerms = [0,0,0];
        var totalPayment = [0.0,0.0,0.0];
		var lastDotCtr = [0,0,0];

        var term=1;
        var curve = [];

        var dataPoint=[];

        dataPoint["term"] =  0;

        $scope.checkStatus = [$scope.chkMinPay,$scope.chkCurPay,$scope.chkAdjPay];

        //all curves startout with the same balance
        for (var i = 0; i < curves.length; i++)
            dataPoint[curves[i]] =  $balance;
		
		var cnt=0;
		
        curve.push(dataPoint);


            while (!(
                        (lastPoint[0] > 1) &&
                        (lastPoint[1] > 1) &&
                        (lastPoint[2] > 1)
                ))
            {
                var dataPoint=[];

                dataPoint["term"] =  term++;
				cnt++;
				if(cnt > 10000) break;
                for (var i = 0; i < curves.length; i++)
                {

                    if(!(lastPoint[i] > 1))
                    {
                        var newInterest = rate[i] * principal[i];
                        var reduction = pmt[i] - newInterest;

                        principal[i] -= reduction;
                        totalPayment[i] += pmt[i] + (principal[i] < 0 ? principal[i] : 0);
                        totalTerms[i]++;

                        if (principal[i] < 0)
                        {
                            //principal[i] = 0;
                            
							dataPoint[curves[i]] = 0.0; //let's add this only 3 times
							
                            lastPoint[i]++;
                        }
                        else
                            dataPoint[curves[i]] = principal[i];


                    }
                    else
                    {
                        if(lastDotCtr[i] < 2 )
						{
							dataPoint[curves[i]] = 0.0;
							lastDotCtr[i] ++;
							
						}
                    }
                }

                curve.push(dataPoint);
            }



        //setup payout table
        $scope.rows = [];

        var labels = ["Minimum Payment","Current Payment","Adjusted Payment"];
        var colors =["styleRed","styleBlue","styleGreen"];
		//rgb(160, 44, 44)","rgb(31, 119, 180)","rgb(44, 160, 44)"
        for (var i = 0; i < curves.length; i++)
        {
            if(!$scope.checkStatus[i])continue;
            $scope.rows.push(
            {
                color: colors[i],
                label : labels[i],
                balance: $scope.currencyFormatting($balance),
                apr:$apr,
                payment:$scope.currencyFormatting(pmt[i]),
                timetopayoff:$scope.dateFormatting(totalTerms[i]),
                totalpayment:$scope.currencyFormatting(totalPayment[i]),
                totalsavings:$scope.currencyFormatting(totalPayment[0] - totalPayment[i])
            }) ;
        }

        $scope.savings=$scope.currencyFormatting(totalPayment[0] - totalPayment[curves.length-1]);



        return [curve, totalTerms, $currentPayment, minPMT,pmt];
    }


    var vis = d3.select('#super-graph');


    $scope.txtInputUpdate = function () {

        if(!$scope.txtBalance || !$scope.txtAPR || !$scope.txtCurrentPayment) return;

        if(isNaN($scope.txtCurrentPayment))
			$scope.sliders.payment = 250;
		else
		 $scope.sliders.payment = $scope.txtCurrentPayment;

        reDrawGraph(0,0, "payment");

    };



    var reDrawPayment = function(oldVal, newVal)
    {
        if(oldVal == newVal) return;
        $scope.unbindTerms();
        reDrawGraph(0,0, "payment")
        $scope.unbindTerms = $scope.$watch('sliders.terms', reDrawTerms);
    }

    var reDrawTerms = function(oldVal, newVal)
    {
        if(oldVal == newVal) return;
        $scope.unbindPayment();
        reDrawGraph(0,0, "terms");
        $scope.unbindPayment = $scope.$watch('sliders.payment', reDrawPayment);

    }

    $scope.unbindPayment = $scope.$watch('sliders.payment', reDrawPayment);
    $scope.unbindTerms = $scope.$watch('sliders.terms', reDrawTerms);

    $scope.addBalance = function()
    {
        $scope.txtBalance = parseFloat($scope.txtBalance.valueOf()) + 1;
        $scope.txtInputUpdate();
    };

    $scope.subBalance = function()
    {
        $scope.txtBalance = parseFloat($scope.txtBalance.valueOf()) - 1;
        $scope.txtInputUpdate();
    };

    $scope.addAPR = function()
    {
        $scope.txtAPR = parseFloat($scope.txtAPR.valueOf()) + 1;
        $scope.txtInputUpdate();
    };

    $scope.subAPR = function()
    {
        $scope.txtAPR = parseFloat($scope.txtAPR.valueOf()) - 1;
        $scope.txtInputUpdate();
    };

    $scope.addCurrentPayment = function()
    {
        $scope.txtCurrentPayment = parseFloat($scope.txtCurrentPayment.valueOf()) + 1;
        $scope.txtInputUpdate();
    };

    $scope.subCurrentPayment = function()
    {
        $scope.txtCurrentPayment = parseFloat($scope.txtCurrentPayment.valueOf()) - 1;
        $scope.txtInputUpdate();
    };

    $scope.openEmailForm =function()
    {

    };


    $scope.prefControl = function()
    {
        //console.log('ahaha');

    };

    $scope.submitSignUpData = function()
    {
        var dataObject =
        {
            'formBuilderForm[FormBuilderID]' : 2,
            'formBuilderForm[Email]': $scope.txtSignupEmail,
            'formBuilderForm[FICO_Range]' : $scope.txtSignupFICORange,
            'formBuilderForm[APR_Range]': $scope.txtSignupAPR,
            'formBuilderForm[Zip_Code]':$scope.txtSignupZipCode
        };

        //document.body.appendChild();

        $http.post('http://www.lendlift.com/index.php#formBuilderCSSIDLendLift_SignUp_Form', dataObject).success(function(response)
        {
            console.log(response);

        });
    };

    $scope.submitCalcData = function (data)
    {



        //take screbshot of the graph

       /* .styleGreen
        {
            inheritance:no;
            color : rgb(44, 160, 44);
        }
        .styleRed
        {
            color : rgb(160, 44, 44);
        }
        .styleBlue
        {
            color : rgb(31, 119, 180);
        }*/

        var summaryTableHTML = document.getElementById("summary-table").innerHTML;
        summaryTableHTML=replaceAll("class=\"row-cell styleGreen\"", "style=\"color: rgb(44, 160, 44)\"",summaryTableHTML);
        summaryTableHTML=replaceAll("class=\"row-cell styleRed\"", "style=\"color: rgb(160, 44, 44)\"",summaryTableHTML);
        summaryTableHTML=replaceAll("class=\"row-cell styleBlue\"", "style=\"color: rgb(31, 119, 180)\"",summaryTableHTML);
        summaryTableHTML=replaceAll("class=\"black-line-separator\"", "style=\"border-bottom:solid black 2px;\"",summaryTableHTML);
        summaryTableHTML=replaceAll("<label>", "<label style=\"font-family: Arial Rounded MT Bold, Helvetica Rounded, Arial, sans-serif;font-size: 14px;color: #414042;\">",summaryTableHTML);




             var dataObject =
                {
                    email: data.email,
                    //firstname:$scope.txtFirstName,
                    //lastname:$scope.txtLastName,
                    //zipcode: $scope.txtZipCode,
                    cardbank:data.ccb,
                    creditlimit: data.cl,
                    creditscore: data.cs,
                    payment: $scope.sliders.payment,
                    terms: $scope.sliders.terms,
                    currentpayment: $scope.sliders.currentpayment,
                    minpayment: $scope.sliders.minpayment,
                    minterms: $scope.sliders.minterms,
                    currentterms:  $scope.sliders.minterms,
                    ibalance: $scope.txtBalance,
                    iapr: $scope.txtAPR,
                    icurrentpayment:$scope.txtCurrentPayment,
                    savings:$scope.savings,
                    graph: document.getElementById("super-graph").innerHTML,
                    summarytable: summaryTableHTML

                };

                //document.body.appendChild();

                //$http.post('http://www.lendlift.com/demo_private/testfolder/calc-new/debtcalculator/process_data.php', dataObject).success(function(response)
                $http.post('localhost/newwebsite/process_data.php', dataObject).success(function(response)
				{
                    //alert(response);

                });

    };

    var reDrawGraph = function(newVal, oldVal, whatToRedraw) {




        if(!$scope.txtBalance || !$scope.txtAPR || !$scope.txtCurrentPayment) return;
       // clear the elements inside of the directive
        vis.selectAll('*').remove();



        var margin = {top: 20, right: 80, bottom: 30, left: 50},
            width = 800 - margin.left - margin.right,
            height = 300 - margin.top - margin.bottom;

        var x = d3.scale.pow().exponent(.7)
            .range([0, width]);

        var y = d3.scale.linear()
            .range([height, 0]);

        var color = d3.scale.category10();

        var xAxis = d3.svg.axis()
            .scale(x)
            .orient("bottom");

        var yAxis = d3.svg.axis()
            .scale(y)
            .orient("left");

        var line = d3.svg.line()
            .interpolate("basis")
            .x(function(d) { return x(d.term); })
            .y(function(d) { return y(d.balance); });

        var svg = d3.select("#super-graph").append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

		
		
        var rData = generatePayDownData(
                                                parseFloat($scope.txtBalance),
                                                parseFloat($scope.txtAPR),
                                                parseFloat($scope.txtCurrentPayment),
                                                $scope.sliders.payment,
                                                $scope.sliders.terms,
                                                whatToRedraw);
            var data = rData[0];

            $scope.sliders.currentpayment = rData[2];
            $scope.sliders.minpayment = rData[3];
            $scope.sliders.currentterms = rData[1][1];
            $scope.sliders.minterms = rData[1][0];

            if(whatToRedraw == "payment")
                $scope.sliders.terms = rData[1][2];
            else
                $scope.sliders.payment = rData[4][2];


            //select all keys which are not named term
            color
                .domain(d3.keys(data[0]).filter(function(key) { return key !== "term"; }))
                .range([$scope.checkStatus[0] ?"rgb(160, 44, 44)" : "#f1f2f2",$scope.checkStatus[1] ?"rgb(31, 119, 180)" : "#f1f2f2",$scope.checkStatus[2] ?"rgb(44, 160, 44)" : "#f1f2f2"]);

            //breakout data into separate maps
            var payoffCurves = color.domain().map(function(name) {
                return {
                    name: name,
                    values: data.map(function(d) {
                        return {term: d.term, balance: +d[name]};
                    })
                };
            });

            //establish X domain by looking at the data
            x.domain(d3.extent(data, function(d) { return d.term; }));

            //establish Y domain  by looking at the data
            y.domain([
                0,
                d3.max(payoffCurves, function(c) { return d3.max(c.values, function(v) { return v.balance; }); })
            ]);

            svg.append("g")
                .attr("class", "x axis")
                .attr("transform", "translate(0," + height + ")")
                .call(xAxis)
                .append("text")
                    .attr("y", "2.75em")
                    .attr("x", "50%")
                    //.attr("dy", "-3.51em")
                    .style("text-anchor", "end")
                    .text("Time To Pay Off (Months)");

            svg.append("g")
                .attr("class", "y axis")
                .call(yAxis)
                .append("text")
                    .attr("transform", "rotate(-90)")
                    .attr("y", -6)
                    .attr("x", "-10em")
                    .attr("dy", "-3.51em")
                    .style("text-anchor", "end")
                    .text("Amount ($)");

            var city = svg.selectAll(".city")
                .data(payoffCurves)
                .enter().append("g")
                .attr("class", "city");

            city.append("path")
                .attr("class", "line")
                .attr("d", function(d) { return line(d.values); })
                .style("stroke", function(d) { return color(d.name); });

            city.append('rect')
            .attr('x', width - 160)
            .attr('y', function(d, i){ return i *  20;})
            .attr('width', 20)
            .attr('height', 5)
            .style('fill', function(d) {
                return color(d.name);
            });

            city.append("text")
                .attr('x', width - 136)
                .attr('y', function(d, i){ return (i *  20) + 5;})
                .text(function(d){ return d.name; });

                /*.datum(function(d) { return {name: d.name, value: d.values[5]}; })
                .attr("transform", function(d) { return "translate(" + x(d.value.term) + "," + y(d.value.balance) + ")"; })
                .attr("x", 3)
                .attr("dy", ".35em")
                .text(function(d) { return d.name; });*/
            return true;
    };

   
	reDrawGraph(0,0, "payment");


    $scope.submitDebtCalculatorSignUp = function(data)
    {
        var dataObject =
        {
            'formBuilderForm[FormBuilderID]' : 4,
            'formBuilderForm[First_Name]': data.fn,
            'formBuilderForm[Last_Name]' :  data.ln,
            'formBuilderForm[Email]': data.email,
            'formBuilderForm[Zip_Code]': data.zc,
			'PAGE' : "http://lendlift.com/",
			'Submit': 'Send!'
        };

        //document.body.appendChild();

        $http.post('/#/formBuilderCSSIDLendLift_Debt_Calculator_SignUp_Form', dataObject, {headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).success(function(response)
        {
            console.log(response);

        });
    };

    $scope.resetCookie = function () {
        $cookies.signupemail = "";
    };

    $scope.Base64Encode = function (input) {

        var keyStr = 'ABCDEFGHIJKLMNOP' +
            'QRSTUVWXYZabcdef' +
            'ghijklmnopqrstuv' +
            'wxyz0123456789+/' +
            '=';

        var output = "";
        var chr1, chr2, chr3 = "";
        var enc1, enc2, enc3, enc4 = "";
        var i = 0;

        do {
            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);

            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;

            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }

            output = output +
                keyStr.charAt(enc1) +
                keyStr.charAt(enc2) +
                keyStr.charAt(enc3) +
                keyStr.charAt(enc4);
            chr1 = chr2 = chr3 = "";
            enc1 = enc2 = enc3 = enc4 = "";
        } while (i < input.length);

        return output;
    };

    $scope.submitAffiliateForm = function(data)
    {
        var dataObject =
        {
            'formBuilderForm[FormBuilderID]' : 5,
            'formBuilderForm[Name]': data.fn,
            'formBuilderForm[Email]': data.email,
            'formBuilderForm[Loan_Amount]': data.la,
            'formBuilderForm[Credit_Quality]': data.cq,
            'formBuilderForm[Zip_Code]': data.zc,
            'formBuilderForm[Affiliate_Link]': data.link
        };

        $http.post('/#/formBuilderCSSIDLendLift_Affiliate_Form', dataObject, {headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).success(function(response)
        {
            console.log(response);
        });
    };




    $scope.openAffiliateForm = function () {

        //submit form data right away
        //show affiliate link (either prosper or lending club)
        //if they click on affiliate then resubmit the form with which affilate went with

        var dataObj =
        {
            fn : this.txtAYourName,
            email: this.txtAEmail,
            la: this.txtALoanAmount,
            cq: this.txtACreditScore,
            zc: this.txtACreditScore,
            link: ''
        };


        $scope.submitAffiliateForm(dataObj);

        var modalInstance = $modal.open({
            templateUrl: 'modalAffiliateRedirect.html',
            controller: AffiliateInstanceCtrl ,
            keyboard : true,
            backdrop : "static"

        });

        modalInstance.result.then(function (data) {

            var link ="";
            if(data.lc_hide) //then prosper
                link = "http://Prosper.evyy.net/c/75006/67127/994";
            else
                link = "https://www.lendingclub.com/landing/partner.action?partnerID=75119";

            dataObj['link'] = link;
            $scope.submitAffiliateForm(dataObj);
            window.location = link;

        }, function () {
            //$log.info('Modal dismissed at: ' + new Date());
        });
    };

    $scope.openSubmitDebtCalcSignUp = function (fakeTabClick) {

		if(fakeTabClick)
		{
			$('.nav li:has(a[href=#home])').removeClass('active');
			$('.nav li:has(a[href=#debtcalculator])').addClass('active');
		}
	
		//check if the cookie has been set
        //if it has been then,
        if( !($cookies.signupemail == "" || typeof($cookies.signupemail) === 'undefined'))
        {
            $scope.signupemail = $cookies.signupemail;
            return;
        }


        var modalInstance = $modal.open({
            templateUrl: 'modalDebtCalcSignUp.html',
            controller: DebtCalculatorSignUpFormInstanceCtrl ,
            keyboard : false,
            backdrop : "static",
			resolve: {
                mainscope:function () {
                    return $scope;
                }
			}

        });

        modalInstance.result.then(function (data) {
           $scope.submitDebtCalculatorSignUp(data);

           //store cookie
           $cookies.signupemail= data.email;
           $scope.signupemail  =  data.email;
            //console.log('sending debt calc signup info')
        }, function () {
            //$log.info('Modal dismissed at: ' + new Date());
        });
    };


    $scope.openSubmitPreferences = function () {

        var modalInstance = $modal.open({
            templateUrl: 'modalPreferences.html',
            controller: SubmitPreferencesFormInstanceCtrl,

            resolve: {
                    signupemail: function () {
                return $scope.signupemail;
            },
                mainscope:function () {
                    return $scope;
                }

        }

        });

        modalInstance.result.then(function (data) {
            $scope.submitCalcData(data);

        }, function () {
            //$log.info('Modal dismissed at: ' + new Date());
        });
    };


    $scope.openTermsConditions = function () {

        var modalInstance = $modal.open({
            templateUrl: 'templates/modalTermsConditions.html',
            controller: TermsConditionsFormInstanceCtrl


        });

        modalInstance.result.then(function () {

        }, function () {
            //$log.info('Modal dismissed at: ' + new Date());
        });
    };

});


var SubmitPreferencesFormInstanceCtrl = function ($scope, $modalInstance, signupemail,mainscope) {

    $scope.txtEmail = signupemail;

    $scope.openTermsConditions = function() { mainscope.openTermsConditions()};

    $scope.ok = function () {

        if(! this.chkTerms)// || ! this.chkHelp)
        {
            alert("You have to agree to LendLift's terms and conditions.");
            return;
        }
        var data =
        {
            email : this.txtEmail,
            ccb: this.txtCreditCardBank,
            cl: this.txtCreditLimit,
            cs: this.txtCreditScore

        };
        $modalInstance.close(data);

    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};




var DebtCalculatorSignUpFormInstanceCtrl = function ($scope, $modalInstance,mainscope) {

    $scope.openTermsConditions = function() { mainscope.openTermsConditions()};
	
	$scope.ok = function () {
        
		if(this.txtEmail==undefined || this.txtEmail == '')// || ! this.chkHelp)
        {
            alert("Please fill out email address");
            return;
        }
		
		var data =
        {
            fn : this.txtFirstName,
            ln : this.txtLastName,
            email : this.txtEmail,
            zc: this.txtZipCode
        };
        $modalInstance.close(data);
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
		$('.nav li:has(a[href=#debtcalculator])').removeClass('active');
		$('.nav li:has(a[href=#home])').addClass('active');
    };
};


var TermsConditionsFormInstanceCtrl = function ($scope, $modalInstance) {

    $scope.ok = function () {
        $modalInstance.close();

    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};

var AffiliateInstanceCtrl = function ($scope, $modalInstance) {

    var rnd = Math.random();

    //if(rnd > .5)
        $scope.lc_hide=true;
    //else
    //    $scope.pr_hide=true;

    $scope.visit_affiliate = function () {
        $modalInstance.close({lc_hide : $scope.lc_hide});
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};

