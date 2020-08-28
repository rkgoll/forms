<!DOCTYPE html>

<html lang="en" ng-app="LendLiftDebtCalc">

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<title>LendLift - Pay off cards - Reap the Rewards - Invest with impact</title>	
	
	<link rel="icon" href="img/lendlift_fav_ico.png">
	<link rel="shortcut icon" href="img/lendlift_fav_ico.png"/>
	
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="../../css/creative.css" type="text/css">
	    <!-- Plugin CSS -->
    <link rel="stylesheet" href="../../css/animate.min.css" type="text/css">

    
    
	
	  <!-- Custom Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../../css/font-awesome.min.css" type="text/css">

	
	      
	<!--script src="js/jquery.min.js"></script-->
	<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    
	<link href="../../css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>

	<!--Wordpress Blog Related -->
	<link rel='stylesheet' id='twentytwelve-fonts-css'  href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700&#038;subset=latin,latin-ext' type='text/css' media='all' />
	<link rel='stylesheet' id='twentytwelve-style-css'  href='http://blog.lendlift.com/wp-content/themes/twentytwelve/style.css?ver=3.5.2' type='text/css' media='all' />

    <link href="../../css/bootstrap-responsive.css" rel="stylesheet">
	<link href="../../css/custom.css" rel="stylesheet">
	<link rel="stylesheet" href="../../css/angular-slider.min.css">
    <link rel="stylesheet" href="../../css/style.css">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <!--share this block-->
  <script type="text/javascript">var switchTo5x=true;</script>
  <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
  <script type="text/javascript">stLight.options(
          {publisher: "fd3d3917-95a3-4dec-bb12-b880e068dde9",
              doNotHash: false,
              doNotCopy: false,
              hashAddressBar: false

          });</script>
		  
		  
		  <!---------------------------------------->
   	  
</head>

	
	<body ng-controller="AppCtrl" ng-init="showSignUpForm=false;showEmailForm=false;showParagraph1=false;">
	
	 
	
	<!-------------------  Old ------------------------------------------>
	 <div class="navbar navbar-inverse navbar-fixed-top">

      <div class="navbar-inner">
	  <a href=""><img class="logo" src="http://lendlift.com/LendLift_Logo-Version_-2_transparent.png"></a>
        <div class="container">

		  <!--button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button-->
		  
		  

          <div class="nav-collapse collapse">
            <ul class="nav" id="navTab">

              
			  <li><a href="http://lendlift.com" class="bg-primary">GO LENDLIFT</a></li>
              <li><a href="#debtcalculator" ng-click="openSubmitDebtCalcSignUp('true')" data-toggle="pill" analytics-on  analytics-event="Calculator" analytics-category="Tabs"  ng-model="debttabbutton">Debt Calculator&trade;</a></li>

            </ul>
           
          </div> 
        </div>
      </div>
    </div>
	
	

		<?php
		$posts = get_posts('numberposts=10&order=DESC&orderby=post_title');
		foreach ($posts as $post) : setup_postdata( $post ); ?>
            <?php get_template_part( 'content', get_post_format() ); ?>
		<?php
		endforeach;
		?>
		</div>
		<div class="tab-pane" id="debtcalculator">

		<div id="debt-calculator"  style="width:850px; margin:0 auto;">

    <div id="box-left">
        <div id="one-left"><div class="section-number">1.</div></div>
        <div id="one-right">

            <div id="one-title" class="title2">Add Balance <!--a href="http://blog.lendlift.com/2013/09/27/introducing-debt-calculator/" target="_blank" id="calc_help">Instructions</a--></div>
			
			
            <div id="one-first">
			<!--input type="range" class="col-sm-3" style="margin-top:2%"  value="7500" id="prefloanduration" name="prefloanduration" min="0" max="72" step="1" onchange="printvalue(this.value,'range3')"-->
			<input type="text" ng-model="txtBalance" ng-change="txtInputUpdate()" id="txtBalance" placeholder="[$]" value="7500"/>
			<span ng-click="addBalance()" class="arrow-up"  analytics-event="AddBalance" analytics-on analytics-category="DebtCalculator"></span>
			<span  ng-click="subBalance()" class="arrow-down"   analytics-event="SubBalance" analytics-on analytics-category="DebtCalculator"></span>&nbsp;<label>Balance</label>
			</div>
          
		  <div id="one-second"><input type="text" ng-model="txtAPR" ng-change="txtInputUpdate()" id="txtAPR" placeholder="[%]" value="25"/>
			<span  ng-click="addAPR()" class="arrow-up"   analytics-event="AddAPR" analytics-on analytics-category="DebtCalculator"></span>
			<span ng-click="subAPR()" class="arrow-down"   analytics-event="SubAPR" analytics-on analytics-category="DebtCalculator"></span>&nbsp;<label>APR</label>
			</div>
			
            <div id="one-third" ><input type="text" ng-model="txtCurrentPayment" ng-change="txtInputUpdate()" id="txtCurrentPayment" placeholder="[$]" value="225"/>
			<span ng-click="addCurrentPayment()" class="arrow-up"   analytics-event="AddCurrentPayment" analytics-on analytics-category="DebtCalculator"></span>
			<span ng-click="subCurrentPayment()" class="arrow-down"   analytics-event="SubCurrentPayment" analytics-on analytics-category="DebtCalculator"></span>&nbsp;<label>Current Payment</label>
			</div>
        </div>
    </div>
    <div id="box-right">
        <div id="two-left"><div class="section-number">2.</div></div>
        <div id="two-right">
            <div id="two-title" class="title2">Adjust Parameters </div>
			<div id="two-first">
                <label>Monthly Payment</label>
                <slider class="sldrMonthlyPayment" floor="50" ceiling="sliders.floatceiling" ng-model-mark1="sliders.minpayment" ng-model-mark2="sliders.currentpayment" step="1" precision="0" ng-model="sliders.payment" ng-onStart="alert('blah')" translate="currencyFormatting" analytics-event="SliderMonthlyPayment" analytics-on analytics-category="DebtCalculator"></slider>
            </div>


            <div id="two-second">
                <label>Payoff Date</label>
                <slider id="sldrPayoffDate" floor="1" ceiling="sliders.maxmonths" maxCeiling="7500" ng-model-mark1="sliders.minterms" ng-model-mark2="sliders.currentterms" step="1" precision="0" ng-model="sliders.terms"  translate="dateFormatting"  analytics-event="SliderPayoffDate" analytics-on analytics-category="DebtCalculator"></slider>
            </div>


        </div>

    </div>
    <div id="box-bottom">
        <div id="three-left"><div class="section-number">3.</div></div>
        <div id="three-right">
            <div id="three-title" class="title2">See the Results</div>
            <div></div>
            <div id="three-checkboxes">
                <label style="color: rgb(160, 44, 44)">Minimum</label><input type="checkbox" ng-model="chkMinPay" ng-change="txtInputUpdate()" analytics-event="chkMinPay" analytics-on analytics-category="DebtCalculator"/>
                <label style="color: rgb(31, 119, 180)">Current</label><input type="checkbox" ng-model="chkCurPay" ng-change="txtInputUpdate()" analytics-event="chkCurPay" analytics-on analytics-category="DebtCalculator"/>
                <label style="color: rgb(44, 160, 44)">Adjusted</label><input type="checkbox" ng-model="chkAdjPay" ng-change="txtInputUpdate()" analytics-event="chkAdjPay" analytics-on analytics-category="DebtCalculator"/>
            </div>

            <div id="super-graph"></div>

        </div>
        <div style="text-align: center;">
            <div style="float:right ;padding-top:10px;padding-bottom: 10px"><!--<input type="button" ng-click="showEmailForm=true" value="Submit These Preferences">-->
			<?php
           // Formbuilder manual form display. Replace the # in the following line with the ID number of the form to be displayed.
           if(function_exists('formbuilder_process_form')) echo formbuilder_process_form(4);
           // End of FormBuilder manual form display.
           ?>
					<script type="text/ng-template" id="modalDebtCalcSignUp.html">
                        <div id="box-email">
                            <div id="btn-close-email"><button href="#home" data-toggle="pill" type="button" class="close" ng-click="cancel()"  analytics-event="CancelDebtCalculator" analytics-on analytics-category="DebtCalculator">×</button></div>
                           <div id="lendliftlogo"><img height=100px src="http://lendlift.com/LendLift_Logo-Version_-2_transparent.png"></div>
                            <div><input type="text" name='formBuilderForm[First_Name]' ng-model="txtFirstName" placeholder="First Name"/></div>
                            <div><input type="text" name='formBuilderForm[Last_Name]' ng-model="txtLastName" placeholder="Last Name"/></div>
                            <div><input type="email" name='formBuilderForm[Email]' ng-model="txtEmail" placeholder="Email" required></div>
							<input type='hidden' name='formBuilderForm[FormBuilderID]' value='4' />
                            <!--<div><input type="text" ng-model="txtCreditCardBank" placeholder="Credit Card Bank"/></div>
                            <div><input type="text" ng-model="txtCreditLimit" placeholder="Credit Limit"/></div>
                            <div><input type="text" ng-model="txtCreditScore" placeholder="Credit Score"/></div>-->
                            <div><input type="text" name='formBuilderForm[Zip_Code]' ng-model="txtZipCode" placeholder="Zip Code"/></div>
                            <div><input type="button" ng-click="ok()" value="Use Debt Calculator!" analytics-event="UseDebtCalculator" analytics-on analytics-category="DebtCalculator"></div>
							<div><a href="" ng-click="openTermsConditions()"  analytics-event="UseCalculatorTermsConditions" analytics-on analytics-category="DebtCalculator">Terms and Conditions</a></p></div>
                            <!--ng-click="submitCalcData();showEmailForm=false" -->
                        </div>
                    </script>

				
                <script type="text/ng-template" id="modalPreferences.html">
                    <div id="box-preferences">
                        <div id="btn-close-email"><button type="button" class="close" ng-click="cancel()"  analytics-event="CancelPreferences" analytics-on analytics-category="DebtCalculator">×</button></div>
                        <div id="lendliftlogo"><img height=100px src="http://lendlift.com/LendLift_Logo-Version_-2_transparent.png"></div>
                        <div><input type="text" ng-model="txtEmail" placeholder="Email"></div>
                        <div><input type="text" ng-model="txtCreditCardBank" placeholder="Credit Card Bank"/></div>
                        <div><input type="text" ng-model="txtCreditLimit" placeholder="Credit Limit"/></div>
                        <div><input type="text" ng-model="txtCreditScore" placeholder="Credit Score Optional"/></div>
                        <div><p><input type="checkbox" ng-model="chkTerms"/>I have read and agreed to <a href="" ng-click="openTermsConditions()" analytics-event="PreferencesTermsConditions" analytics-on analytics-category="DebtCalculator">Terms and Conditions</a>.</p></div>
                        <!--<div><p><input type="checkbox" ng-model="chkHelp"/>I authorize LendLift including third party lenders in helping to payoff the loan of credit card debt.</p></div>-->
                        <div><input type="button" ng-click="ok()" value="Submit Preferences" analytics-event="SubmitPreferences" analytics-on analytics-category="DebtCalculator"></div>

                    </div>
                </script>
                <!--<button type="button" ng-click="resetCookie()">reset cookie</button>-->
                <button type="button" ng-click="openSubmitPreferences()">Submit These Preferences</button>

            </div>
        </div>
        <div id="summary-table">
            <label>Summary Table</label>
            <div class="black-line-separator"></div>
            <table width="100%">
                <tr>
                <td class="row-header"><label>Options</label></td>
                <td class="row-header"><label>Balance</label></td>
                <td class="row-header"><label>APR</label></td>
                <td class="row-header"><label>Payment</label></td>
                <td class="row-header"><label>Time to Payoff</label></td>
                <td class="row-header"><label>Total Payment</label></td>
                <td class="row-header"><label>Total Savings</label></td>
                </tr>


            <tr ng-repeat="row in rows">

                    <td class="row-cell {{ row.color }}" style="text-align: left;"><label  class="row-cell {{ row.color }}"> {{ row.label }}</label></td>
                    <td class="row-cell {{ row.color }}" style="color: {{ row.color }}">{{ row.balance }}</td>
                    <td class="row-cell {{ row.color }}" style="color: {{ row.color }}">{{ row.apr }}</td>
                    <td class="row-cell {{ row.color }}" style="color: {{ row.color }}">{{ row.payment }}</td>
                    <td class="row-cell {{ row.color }}" style="color: {{ row.color }}">{{ row.timetopayoff }}</td>
                    <td class="row-cell {{ row.color }}" style="color: {{ row.color }}">{{ row.totalpayment }}</td>
                    <td class="row-cell {{ row.color }}" style="color: {{ row.color }}">{{ row.totalsavings }}</td>
            </tr>


            </table>
            <div class="black-line-separator"></div>
        </div>

    </div>
    <div id="box-details">
        <div id="detail-minpay-graph"></div>
        <div id="detail-totalpay-graph"></div>
        <div id="detail-payoff-graph"></div>
        <div id="detail-savings-graph"></div>
    </div>
    <div id="box-disclosures">
        <div style="float:left;padding:5px"><b>Disclosures</b>
            The Information derived from the interactive Debt calculators are made available to you as self-help tools for your independent use and are not intended to provide debt/investment advice. We can not and do not guarantee their applicability or accuracy in regard to your individual circumstances with respect to your loan and debt of the credit and disclaim any and all form of liability whatsoever. All examples are hypothetical and are for illustrative purposes. We encourage you to seek personalized advice from qualified professionals regarding all personal finance issues.

        </div>
        <div style="float:left;padding:5px">
        <b>Minimum Payment Disclosure</b>

            Our current calculator assumes that your minimum payment remains constant throughout your payoff time-period. This is the optimistic scenario for paying off your credit card debt. In reality your minimum payment reduces as you pay off balances as it is based on a percent of your outstanding balance. This can greatly increase the length of time it takes to pay off your credit cards.
        </div>

    </div>


        </div>

		</div>
	</div>

	
	
	<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="../../js/bootstrap-tab.js"></script>
	<script src="../../js/bootstrap-modal.js"></script>
	<script src="../../bootstrap-transition.js"></script>
	<script src="../../js/bootstrap-scrollspy.js"></script>
	<script src="../../js/bootstrap-carousel.js"></script>

	<script src="../../js/d3.v3.min.js" charset="utf-8"></script>
    <script src="../../js/angular.min.js"></script><!--1.1.4-->
	
	<script src="../../js/angulartics.min.js"></script>
	<script src="../../js/angulartics-google-analytics.min.js"></script>
    <script src="../../js/angular-slider.js"></script>
    <script src="../../js/mainlib.js"></script>

    <script src="../../js/html2canvas.js"></script>
    <script src="../../js/ui-bootstrap-tpls-0.6.0.js"></script>
    <script src="../../js/angular-cookies-1.0.0rc10.js"></script>
	
	
	
	

	
</body>


</html>