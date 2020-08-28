<!DOCTYPE html>
<?php
		define('FORMBUILDER_IN_TEMPLATE', true);
		
?>

<html lang="en" ng-app="LendLiftDebtCalc">
  <head>
    <meta charset="utf-8">
    <title>LendLift - a Peer-to-Peer Lending Platform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="icon" href="img/lendlift_fav_ico.png">
	<link rel="shortcut icon" href="img/lendlift_fav_ico.png"/>
	
	<script src="js/jquery.min.js"></script>
    
	<link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>

	<!--Wordpress Blog Related -->
	<link rel='stylesheet' id='twentytwelve-fonts-css'  href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700&#038;subset=latin,latin-ext' type='text/css' media='all' />
	<link rel='stylesheet' id='twentytwelve-style-css'  href='http://blog.lendlift.com/wp-content/themes/twentytwelve/style.css?ver=3.5.2' type='text/css' media='all' />

    <link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
	<link rel="stylesheet" href="css/angular-slider.min.css">
    <link rel="stylesheet" href="css/style.css">

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

	<!--google analytics -->	   
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-39805722-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
	<!-- Google Code for Debt Calculator Signup Conversion Page -->
	<script type="text/javascript">
	/* <![CDATA[ */
	var google_conversion_id = 977755833;
	var google_conversion_language = "en";
	var google_conversion_format = "2";
	var google_conversion_color = "ffffff";
	var google_conversion_label = "3skzCOfzlAcQub2d0gM";
	var google_conversion_value = 0;
	var google_remarketing_only = false;
	/* ]]> */
	</script>
	<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
	</script>
	<noscript>
	<div style="display:inline;">
	<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/977755833/?value=0&amp;label=3skzCOfzlAcQub2d0gM&amp;guid=ON&amp;script=0"/>
	</div>
	</noscript>
	

	</head>

  <body ng-controller="AppCtrl" ng-init="showSignUpForm=false;showEmailForm=false;showParagraph1=false;">

    <div class="navbar navbar-inverse navbar-fixed-top">

      <div class="navbar-inner">
<!--	  <a href=""><img class="logo" src="http://lendlift.com/LendLift_Logo-Version_-2_transparent.png"></a>  -->
        <div class="container">

		  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <div class="nav-collapse collapse">
            <ul class="nav" id="navTab">
<!--
              <li class="active" ><a href="#home" data-toggle="pill" analytics-event="Home" analytics-on analytics-category="Tabs" ng-model="hometabbutton">Home</a></li>
              <li><a href="#blog" data-toggle="pill" analytics-on  analytics-event="Blog" analytics-category="Tabs">Blog</a></li>  -->
			  <li><a href="#debtcalculator" ng-click="openSubmitDebtCalcSignUp()" data-toggle="pill" analytics-on  analytics-event="Calculator" analytics-category="Tabs"  ng-model="debttabbutton">Debt Calculator&trade;</a></li>
   <!-- <li><a href="#contact" data-toggle="pill" analytics-on  analytics-event="Contact" analytics-category="Tabs">Contact</a></li>  -->

            </ul>
            <form class="navbar-form pull-right">
				<p> COMING SOON!</p>
				<span class='st_facebook_hcount' displayText='Facebook' st_title="Try LendLift Debt Calculator to learn about paying off credit card debt."></span>
				<span class='st_twitter_hcount' displayText='Tweet' st_title="Try LendLift Debt Calculator to learn about paying off credit card debt."></span>
				<span class='st_linkedin_hcount' displayText='LinkedIn' st_title="Try LendLift Debt Calculator to learn about paying off credit card debt."></span>
				<!--<span class='st_email_hcount' displayText='Email' st_title="Try LendLift Debt Calculator to learn about paying off credit card debt."></span>-->
				<!--<button type="button" data-toggle="pill" class="btn"  ng-click="showSignUpForm=true" >Sign Up</button>-->
				<a href="#signup" class="btn" style="{font-size: 18px}" data-toggle="pill" analytics-event="Signup" analytics-on analytics-category="Tabs">Sign Up</a>
            </form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>


	<div class="container-fluid">
	<div class="tab-content">
		<div class="tab-pane active" id="home">
		<!-- Carousel
                ================================================== -->
  				<div id="myCarousel" class="carousel slide" ng-controller="CarouselCtrl">
				<carousel>
                  <div class="carousel-inner">

                  <slide ng-cloak>
                      <img src="img/bg.png" alt="">
                      <div class="container">
                          <div class="carousel-caption">
                              <?php
                                   // Formbuilder manual form display. Replace the # in the following line with the ID number of the form to be displayed.
                                   if(function_exists('formbuilder_process_form')) echo formbuilder_process_form(5);
                                   // End of FormBuilder manual form display.
                                  ?>
                              <script type="text/ng-template" id="modalAffiliateRedirect.html">

                                  <div id="box-referral">
                                      <div id="btn-close-email"><button type="button" class="close" ng-click="cancel()"  analytics-on  analytics-event="AffiliateFormCloseClick" analytics-category="HomePage">×</button></div>

                                      <div id="lendingclublink" ng-hide="lc_hide"><img src="img/lendingclub_affiliate.jpg" ng-click="visit_affiliate()" analytics-on  analytics-event="LendingClubClick" analytics-category="HomePage"></div>

                                      <div id="prosperlink" ng-hide="pr_hide"><img src="img/prosper_affiliate.gif" ng-click="visit_affiliate()" analytics-on  analytics-event="ProsperClick" analytics-category="HomePage"></div>
                                      <p>
                                          Thank you for visiting LendLift.  While we are still developing our product that can offer you a loan to help pay off your credit card debt, check your rate at our affiliate programs. Click on the image to continue.
                                            <br><br>
                                          Please note that we do not share any information you submit to us with our affiliates.
                                      </p>
                                  </div>
                              </script>


                              <div id="box-affiliate">
                                  <a href="#debtcalculator" ng-click="openSubmitDebtCalcSignUp('true')" class="btn btn-large btn-primary" data-toggle="pill" analytics-on  analytics-event="TryOurDebtCalculatorPicClick" analytics-category="HomePage">Try our Debt Calculator</a>
                                  <div id="calc"></div>
                                  <div id="affiliate">
                                      <div><input type="text" ng-model="txtAYourName" placeholder="Your Name"/></div>
                                      <div><input type="text" ng-model="txtAEmail" placeholder="Email"></div>
                                      <div><input type="text" ng-model="txtALoanAmount" placeholder="(Opt) Loan Amount"/></div>
                                      <div><input type="text" ng-model="txtACreditScore" placeholder=" (Opt) Credit Score"/></div>
                                      <div><input type="text" ng-model="txtAZipCode" placeholder="Zip Code"/></div>
                                      <div><input type="button" ng-click="openAffiliateForm()" value="Check Rate!"></div>
                                      <div><a href="" ng-click="openTermsConditions()">Terms and Conditions</a></div>

                                  </div>
                              </div>
                          </div>
                      </div>
                  </slide>

                    <slide ng-cloak>
                      <img src="img/bg.png" alt="">
                      <div class="container">
                        <div class="carousel-caption">
                            <iframe id="player_1" class="th" src="https://player.vimeo.com/video/74336114?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff;api=1;player_id=player_1" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
							<script src="js/froogaloop2.min.js"></script>
							<script src="js/track_video.js"></script>
                            <p class="lead">
                            <a href="#debtcalculator"  data-toggle="pill" class="btn btn-large btn-primary"  ng-click="openSubmitDebtCalcSignUp('true')" analytics-on  analytics-event="TryOurDebtCalculatorClick" analytics-category="HomePage">Try our Debt Calculator</a>
                            </p>
                        </div>
                      </div>
                    </slide>

                   <slide ng-cloak>
                    <img src="img/bg.png" alt="">
                    <div class="container">
                      <div class="carousel-caption">
                        <p class="lead2">Now there is a better way to payoff credit cards</p>
                        <p class="lead2">Melt Your Debt</p>
                      </div>
                    </div>
                  </slide>
                </div>
                  <!--<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                  <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>-->
				</carousel>
        
			   </div><!-- /.carousel -->
				


      <div class="row" ng-cloak>
        <div class="span4">
          <h2>The Problem</h2>
          <p>The total U.S. credit card debt is approximately $857Bn.  This is a
              huge problem with respect to all responsible credit card borrowers
              with high Interest APR and non-existent refinancing options. Majority
              of credit card borrowers are not aware of credit card terms and do not
              know how to break from the perpetual payment cycles and get out of
              debt spiral.</p>
          <!--<p><a class="btn" href="#">View details &raquo;</a></p>-->
        </div>
        <div class="span4">
          <h2>Our Services</h2>
          <p>LendLift is an online peer-to-peer marketplace that connects responsible credit card borrowers with Investors regarding the loan of your credit card debt only. We are building a platform that provides underserved borrowers the ability to pay down their balances and eliminate their debt faster and at lower interest rates, as oppose to the regular cycle of credit cards loan terms. Beyond serving borrowers, we offer our Investors reasonable yields than current bank product offers.Currently our services are limited to only providing education related to credit card payoff for borrowers.</p>


       </div>
        <div class="span4">
          <h2>About Us</h2>
          <p>LendLift consists of a team of diverse, uniquely qualified financial
              services and business executives, industry veterans, engineers,
              designers and policy aficionados who understand the problem
              intrinsically at a grass root level. The team is passionate to create
              unique solutions that create debt awareness along with actionable
              products to help people navigate through the debt pay off cycles.
		</p>

        </div>
      </div>




</div>
<div class="tab-pane" id="contact">
<p>At LendLift, we value your feedback and opinion which will help us build better products that suit our customer needs. <br><br></p>
        <a href="http://www.linkedin.com/company/3173849"><img  class="linkedin" src="./img/img_trans.gif"  width="1" height="1"></a>
		<a href=""><img class="facebook"  src="./img/img_trans.gif"    width="1" height="1"></a>
		<a href="https://twitter.com/@LendLift"><img class="twitter" src="./img/img_trans.gif"    width="1" height="1"></a>
		<a href=""><img class="google"  src="./img/img_trans.gif"    width="1" height="1"></a>
		<a href=""><img class="pinterest"  src="./img/img_trans.gif"    width="1" height="1"></a>     <br><br>

<?php
// Formbuilder manual form display. Replace the # in the following line with the ID number of the form to be displayed.
if(function_exists('formbuilder_process_form')) echo formbuilder_process_form(1);
// End of FormBuilder manual form display.
?>

</div>
<div class="tab-pane" id="signup">
     <div class="row">
        <div class="span4">
        <h2>Borrowers</h2>
        <p><br>If you are interested in Credit Card Payoff, sign up here and stay tuned.<br><br></p>
           <?php
           // Formbuilder manual form display. Replace the # in the following line with the ID number of the form to be displayed.
           if(function_exists('formbuilder_process_form')) echo formbuilder_process_form(2);
           // End of FormBuilder manual form display.
           ?>
           <p> By clicking "Send!" you are agreeing with  <a href="" ng-click="openTermsConditions()">Terms and Conditions</a></p>
        </div>
        <!--<div class="span4">
        <h2>Lenders</h2>
        <p><br>If you are an Investor and interested in P2P asset class, sign up here and stay tuned.<br><br></p>
           <?php
           // Formbuilder manual form display. Replace the # in the following line with the ID number of the form to be displayed.
           if(function_exists('formbuilder_process_form')) echo formbuilder_process_form(3);
           // End of FormBuilder manual form display.
           ?>
        </div>-->
        </div>
    </div>


		<div class="tab-pane" id="blog">
			<!--<iframe src="http://blog.lendlift.com"
        style="border: 0; width:100%; height:800px;"></iframe>
		</div>-->


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

            <div id="one-title" class="title2">Add Balance (<a href="http://blog.lendlift.com/2013/09/27/introducing-debt-calculator/" target="_blank" id="calc_help">Instructions</a>)</div>
            <div id="one-first"><input type="text" ng-model="txtBalance" ng-change="txtInputUpdate()" id="txtBalance" placeholder="[$]" value="3500"/>
			<span ng-click="addBalance()" class="arrow-up"  analytics-event="AddBalance" analytics-on analytics-category="DebtCalculator"></span>
			<span  ng-click="subBalance()" class="arrow-down"   analytics-event="SubBalance" analytics-on analytics-category="DebtCalculator"></span>&nbsp;<label>Balance</label></div>
            <div id="one-second"><input type="text" ng-model="txtAPR" ng-change="txtInputUpdate()" id="txtAPR" placeholder="[%]">
			<span  ng-click="addAPR()" class="arrow-up"   analytics-event="AddAPR" analytics-on analytics-category="DebtCalculator"></span>
			<span ng-click="subAPR()" class="arrow-down"   analytics-event="SubAPR" analytics-on analytics-category="DebtCalculator"></span>&nbsp;<label>APR</label></div>
            <div id="one-third" ><input type="text" ng-model="txtCurrentPayment" ng-change="txtInputUpdate()" id="txtCurrentPayment" placeholder="[$]">
			<span ng-click="addCurrentPayment()" class="arrow-up"   analytics-event="AddCurrentPayment" analytics-on analytics-category="DebtCalculator"></span>
			<span ng-click="subCurrentPayment()" class="arrow-down"   analytics-event="SubCurrentPayment" analytics-on analytics-category="DebtCalculator"></span>&nbsp;<label>Current Payment</label></div>
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
                <slider id="sldrPayoffDate" floor="1" ceiling="sliders.maxmonths" maxCeiling="3500" ng-model-mark1="sliders.minterms" ng-model-mark2="sliders.currentterms" step="1" precision="0" ng-model="sliders.terms"  translate="dateFormatting"  analytics-event="SliderPayoffDate" analytics-on analytics-category="DebtCalculator"></slider>
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


      <hr>


          <footer>
              <p>LendLift Inc is not associated with social media networks such as Facebook, Twitter and LinkedIn</p>
              <p> LendLift Inc, 8 W 38TH Street Suite 801, New York, NY 10018 contact@lendlift.com &copy; 2013 LendLift Inc. <a href="" ng-click="openTermsConditions()"  analytics-event="TermsConditions" analytics-on analytics-category="HomePage">Terms and Conditions</a></a>

        </p>


      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="js/bootstrap-tab.js"></script>
	<script src="js/bootstrap-modal.js"></script>
	<script src="js/bootstrap-transition.js"></script>
	<script src="js/bootstrap-scrollspy.js"></script>
	<script src="js/bootstrap-carousel.js"></script>

	<script src="js/d3.v3.min.js" charset="utf-8"></script>
    <script src="js/angular.min.js"></script><!--1.1.4-->
	
	<script src="js/angulartics.min.js"></script>
	<script src="js/angulartics-google-analytics.min.js"></script>
    <script src="js/angular-slider.js"></script>
    <script src="js/mainlib.js"></script>

    <script src="js/html2canvas.js"></script>
    <script src="js/ui-bootstrap-tpls-0.6.0.js"></script>
    <script src="js/angular-cookies-1.0.0rc10.js"></script>

  </body>
</html>
