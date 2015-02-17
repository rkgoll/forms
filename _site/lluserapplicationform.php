<!DOCTYPE html>
<html>

  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>LendLift</title>
  <meta name="description" content="">

  <link rel="stylesheet" href="assets/css/main.css"> 
  <link rel="canonical" href="http://www.lendlift.com/lluserapplicationform.php">
  <link rel="alternate" type="application/rss+xml" title="LendLift" href="http://www.lendlift.com/feed.xml" />

  <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
  
</head>


  <body>

  <div class="page-container">
  
  <header>
  <a href="index.html" class="logo">
<svg version="1.1" id="Layer_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     viewBox="0 0 592 560" enable-background="new 0 0 592 560" xml:space="preserve">
<g>
    <polygon fill="#FFFFFF" points="144,429 144,224 88,224 88,478 145.23,478 268,478 268,429    "/>
    <polygon fill="#FFFFFF" points="56,306 0,306 0,560 57.086,560 179,560 179,511 56,511    "/>
</g>
<g>
    <path fill="#FFFFFF" d="M473.377,107.311c-5.334,0-9.377,0.485-12.377,1.092v64.536c3,0.485,6.688,0.606,10.719,0.606
        c22.043,0,34.014-12.616,34.014-34.694C505.852,119.563,495.186,107.311,473.377,107.311z"/>
    <path fill="#FFFFFF" d="M183,0v398h409V0H183z M258,101h11v73h34v8h-45V101z M313,297h-55v-92h20v73h35V297z M355,297h-21v-92h21
        V297z M359,182h-45v-81h43v8h-33v26h32v9h-32v30h35V182z M429,224h-33v17h31v19h-31v37h-21v-92h54V224z M432,182h-9.177
        l-25.363-41.833c-5.572-9.098-10.904-18.612-14.935-27.467l-0.855,0.035c0.592,10.311,0.33,20.051,0.33,33.637V182h-10v-81h12.541
        l25.6,40.64c5.926,9.583,10.549,17.833,14.342,26.203l-0.031-0.303c-0.947-10.918-1.451-21.047-1.451-33.784V101h9V182z M515,224
        h-25v73h-21v-73h-25v-19h71V224z M505.311,170.27c-7.467,7.643-19.925,11.767-35.452,11.767c-7.349,0-14.858-0.364-18.858-0.97
        v-80.427c5-0.97,13.882-1.698,22.059-1.698c14.814,0,25.43,3.518,32.423,10.19c7.111,6.672,11.293,16.134,11.293,29.356
        C516.774,151.831,512.776,162.749,505.311,170.27z"/>
</g>
</svg>
</a>
  <br>
  - Demo - 
</header>

<?php 
	$myfirstname = $_POST["firstname"];
	$mylastname = $_POST["lastname"]; 
	$myemailaddress = $_POST["emailaddress"];
	$myzipcode = $_POST["zipcode"];
	$myssn = $_POST["ssn"];
	$myloanamt = $_POST["loanamt"];
	$mycurrentMinPayment = $_POST["currentMinPayment"];
	$mycurrentAPR = $_POST["currentAPR"];
	$myprefminpayment = $_POST["prefminpayment"];
	$myprefloanduration = $_POST["prefloanduration"];
	$mycreditscore = $_POST["creditscore"];
	$myLLCompBand = 0;

	// echo "<ul class='info'><li><strong>Name: </strong>$myfirstname $mylastname</li>";
	// echo "<li><strong>Email: </strong>$myemailaddress</li>";
	// echo "<li><strong>ZIP Code: </strong>$myzipcode</li>";
	// echo "<li><strong>SSN: </strong>$myssn</li>";
	// echo "<li><strong>Loan Amount: </strong>$myloanamt</li>";
	// echo "<li><strong>Current Payments: </strong>$mycurrentMinPayment</li>";
	// echo "<li><strong>Current APR: </strong>$mycurrentAPR</li>";
	// echo "<li><strong>Preferred Minimum Payment: </strong>$myprefminpayment</li>";
	// echo "<li><strong>Preferred Loan Duration: </strong> $myprefloanduration</li>";
	// echo "<li><strong>Credit Score Range: </strong>$mycreditscore</li></ul>";

// Implies that the credit score is less than 600 - which does not qualify for a loan.
if ($mycreditscore =="5")	
{
	echo "<p class='alert'>Sorry, you do not qualify for a LendLift loan</p>";
}
// Implies that the user entered in that they don't know the score.
elseif ($mycreditscore == "0") 
{
	echo "<p class='alert'>Sorry, we need to ask you some more questions before we could consider you for a LendLift loan</p>";


}
else
{

	// Simulate the look up from the credit score.
	$myadjustcreditscore = rand(500,800);

	// Calculate the score from random values
	$revolving_line_util = rand(0,45);		// Random Percentage
	$inquiries_sixmonths = rand(0,5);		// Max enquiries = 6 (assumption)
	$months_since_delinq = rand(0,5);		// Going back 7 years aka 84 months

	//$inquiries_sixmonths = 0;
	//$months_since_delinq = 0;
	//$revolving_line_util = 19.4;
	//$myloanamt = 5000;
	//$myadjustcreditscore = 740;


	// echo "<ul class='info'><li><strong>Revolving Line Util: </strong>$revolving_line_util %</li>";
	// echo "<li><strong>Inquiries in 6 months: </strong>$inquiries_sixmonths</li>";
	// echo "<li><strong>Months since delinq: </strong>$months_since_delinq</li>";

	// Print the adjusted credit score based on the range
	// echo "<li><strong>Credit score: </strong>$myadjustcreditscore</li></ul>";


	




	if (($myadjustcreditscore < 600) || ($inquiries_sixmonths > 4) || ($months_since_delinq > 3) || ($revolving_line_util > 40))
	{
		echo "<p class='alert'>Sorry, you did not meet our minimum credit requirements for qualifying for a LendLift Loan. <br> Please contact us at contact@lendlift.com if you have more questions.</p>";
	}
	else
	{

		// Calculate the Comp Grade Score.
		$mycoefficient = -65693.3372390618;
		$myadjustedloanamount = -($myloanamt * 0.0353946684926274);
		$myfinalcreditscore = 10445.6103831898 * log($myadjustcreditscore);
		$myfinalrevolveutil = 175.243872637113 * sqrt($revolving_line_util/100);
		$myfinalinquiries = -(150.281182753347 * sqrt($inquiries_sixmonths));

		if ($months_since_delinq == 0)
			$myfinaldelinqs = 0;
		else
			$myfinaldelinqs = 2.7110215433137 * log($months_since_delinq);



		// echo "<ul class='info' style='display:none;'><li><strong>Coefficient: </strong>$mycoefficient</li>";
		// echo "<li><strong>Adjusted loan amount: </strong>$myadjustedloanamount</li>";
		// echo "<li><strong>Credit Score: </strong>$myfinalcreditscore</li>";
		// echo "<li><strong>Final Revolving: </strong>$myfinalrevolveutil</li>";
		// echo "<li><strong>Inquiries: </strong>$myfinalinquiries</li>";
		// echo "<li><strong>Delinquent: </strong>$myfinaldelinqs</li>";

		$mycalculate_compgradescore = $mycoefficient + $myadjustedloanamount + $myfinalcreditscore + $myfinalrevolveutil + $myfinalinquiries + $myfinaldelinqs;

		// echo "<li><strong>Calculated Comp Grade Score: </strong>$mycalculate_compgradescore</li>";

		$mycalculatedband = abs(round(($mycalculate_compgradescore/350), 0) - 2);

		// echo "<li><strong>Calculated Comp Band: </strong>$mycalculatedband</li></ul>";

		// Open the database and do a quick look up based on the loan amount
		// and credit score.
		$user_name = "root";
		$password = "lendlift";
		$database = "lendlift_riskmodel";
		$server = "127.0.0.1";

		$db_connect = mysql_connect($server, $user_name, $password);
		if ($db_connect) 
		{
			print("Server connected !! <BR>");
			$db_handle = mysql_select_db($database, $db_connect);
			if ($db_handle)
			{
				print("Database found !! <BR>");

				// Look up the other values from the Pricing Model table based on the adjusted score.
				$myuserinput_query = "SELECT * FROM `PricingModel` WHERE  `Band` = '$mycalculatedband'";
				$query_inputresult = mysql_query($myuserinput_query);
				if ($query_inputresult)
				{
					print("User Input query successful <BR>");
					$number_records = mysql_num_rows($query_inputresult);
					print("Number of records found: ");
					echo "$number_records <BR>";

					while($row = mysql_fetch_array($query_inputresult))
					{
						print("<ul class='info'><li>Loan Amount = " .$row['Loan Amount']."</li>");
						print("<li>Term = " .$row['Term']."months</li>");
						print("<li>Origination Fees = " .$row['Orig Fee']."</li>");
						print("<li>Servicing Fees = " .$row['Svc Fee']."</li>");
						print("<li>New Rate = " .$row['New Rate']."</li>");
						print("<li>Effective Rate = " .$row['Effective Rate']."</li>");
						print("<li>Payment = " .$row['Payment']."</li>");
						print("<li>Reward Redemption Rate = " .$row['Reward Rdmpt']."</li></ul>");
						
						print("<p class='alert>Scroll down for more information.</p>'");
						
						print("<ul class='info'><li>Loan Amount = " .$row['Loan Amount']."</li>");
						print("<li>Term = " .$row['Term']."months</li>");
						print("<li>Origination Fees = " .$row['Orig Fee']."</li>");
						print("<li>Servicing Fees = " .$row['Svc Fee']."</li>");
						print("<li>New Rate = " .$row['New Rate']."</li>");
						print("<li>Effective Rate = " .$row['Effective Rate']."</li>");
						print("<li>Payment = " .$row['Payment']."</li>");
						print("<li>Reward Redemption Rate = " .$row['Reward Rdmpt']."</li></ul>");

					}
				}
			}
		}
		else
		{
			print("Database not found");
		}
	mysql_close($db_connect);
	}
}

?>

</div>


  </body>

</html>
