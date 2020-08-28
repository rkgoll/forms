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
var LendLiftDebtCalc = angular.module('LendLiftDebtCalc', ['uiSlider']);

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
LendLiftDebtCalc.controller('AppCtrl', function AppCtrl ($scope, $http) {

    $scope.sliders = {
        payment: 115,
        terms: 36,
        currentpayment: 0,
        minpayment:0,
        minterms: 0,
        currentterms: 0

    };

    //set default values
    $scope.txtBalance = 3500;
    $scope.txtAPR = 15;
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
    "July", "August", "September", "October", "November", "December" ];
		
        var curr_date = d.getDate();
        var curr_month = d.getMonth() + 1;
        var curr_year = d.getYear()+2000-100;

        if(value == "1" || value == "60")
            return monthNames[curr_month].substring(0,3) + "/" + curr_year;
        else
            return value + " months";
    };


    var generatePayDownData = function($balance,$apr,$currentPayment,$adjpayment,$terms, $whatToRedraw) {





        var curves = ["[min payoff]","[current payoff]","[adj payoff]"];

        if($apr < 0)  $apr = 15;
        if($apr > 35)  $apr = 35;

        if($balance < 0) $balance = 3500;




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

        curve.push(dataPoint);


            while (!(
                        (lastPoint[0] > 1) &&
                        (lastPoint[1] > 1) &&
                        (lastPoint[2] > 1)
                ))
            {
                var dataPoint=[];

                dataPoint["term"] =  term++;

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
        $scope.txtBalance = $scope.txtBalance.valueOf() + 1;
        $scope.txtInputUpdate();
    };

    $scope.subBalance = function()
    {
        $scope.txtBalance = $scope.txtBalance.valueOf() - 1;
        $scope.txtInputUpdate();
    };

    $scope.addAPR = function()
    {
        $scope.txtAPR = $scope.txtAPR.valueOf() + 1;
        $scope.txtInputUpdate();
    };

    $scope.subAPR = function()
    {
        $scope.txtAPR = $scope.txtAPR.valueOf() - 1;
        $scope.txtInputUpdate();
    };

    $scope.addCurrentPayment = function()
    {
        $scope.txtCurrentPayment = $scope.txtCurrentPayment.valueOf() + 1;
        $scope.txtInputUpdate();
    };

    $scope.subCurrentPayment = function()
    {
        $scope.txtCurrentPayment = $scope.txtCurrentPayment.valueOf() - 1;
        $scope.txtInputUpdate();
    };

    $scope.openEmailForm =function()
    {

    };


    $scope.submitCalcData = function ()
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
                    email: $scope.txtEmail,
                    cardbank: $scope.txtCreditCardBank,
                    creditlimit: $scope.txtCreditLimit,
                    creditscore: $scope.txtCreditScore,
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
				$http.post('http://www.lendlift.com/demo_private/testfolder/calc-new/debtcalculator/process_data.php', dataObject).success(function(response)
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
                                                $scope.txtBalance,
                                                $scope.txtAPR,
                                                $scope.txtCurrentPayment,
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

});


