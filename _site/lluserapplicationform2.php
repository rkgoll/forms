<!DOCTYPE html>
<html>

  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>LendLift</title>
  <meta name="description" content="">

  <link rel="stylesheet" href="assets/css/main.css"> 
  <link rel="canonical" href="http://www.lendlift.com/lluserapplicationform2.php">
  <link rel="alternate" type="application/rss+xml" title="LendLift" href="http://www.lendlift.com/feed.xml" />

  <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
  
</head>


  <body>

  <html>
<head>
	<title>LendLift Demo</title>
</head>
<body>
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

	echo "$myfirstname $mylastname<BR>";
	echo "$myemailaddress <BR>";
	echo "$myzipcode <BR>";
	echo "$myssn <BR>";
	echo "$myloanamt <BR>";
	echo "$mycurrentMinPayment <BR>";
	echo "$mycurrentAPR <BR>";
	echo "$myprefminpayment <BR>";
	echo "$myprefloanduration <BR>";
	echo "$mycreditscore <BR>";

// Implies that the credit score is less than 600 - which does not qualify for a loan.
if ($mycreditscore =="5")	
{
	echo "Sorry, you do not qualify for a LendLift loan <BR>";
}
// Implies that the user entered in that they don't know the score.
elseif ($mycreditscore == "0") 
{
	echo "Sorry, we need to ask you some more questions before we could consider you for a LendLift loan <BR>";
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

	echo "Revolving Line Util: ";
	echo "$revolving_line_util %";
	echo "<BR>";
	echo "Inquiries in 6 months: ";
	echo "$inquiries_sixmonths";
	echo "<BR>";
	echo "Months since delinq: ";
	echo "$months_since_delinq";
	echo "<BR>";

	// Print the adjusted credit score based on the range
	print("My adjust credit score is: ");
	echo "$myadjustcreditscore <BR>";


	if (($myadjustcreditscore < 600) || ($inquiries_sixmonths > 4) || ($months_since_delinq > 3) || ($revolving_line_util > 40))
	{

		echo "Sorry, you did not meet our minimum credit requirements for qualifying for a LendLift Loan. <BR>";
		echo "Please contact us at contact@lendlift.com if you have more questions. <BR>";
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

		echo "$mycoefficient <BR>";
		echo "$myadjustedloanamount <BR>";
		echo "$myfinalcreditscore <BR>";
		echo "$myfinalrevolveutil <BR>";
		echo "$myfinalinquiries <BR>";
		echo "$myfinaldelinqs <BR>";

		$mycalculate_compgradescore = $mycoefficient + $myadjustedloanamount + $myfinalcreditscore + $myfinalrevolveutil + $myfinalinquiries + $myfinaldelinqs;

		echo "My Calculated Comp Grade Score is : ";
		echo "$mycalculate_compgradescore <BR>";

		$mycalculatedband = abs(round(($mycalculate_compgradescore/350), 0) - 2);

		echo "My Calculated Comp Band is : ";
		echo "$mycalculatedband <BR>";

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
						print("Loan Amount = " .$row['Loan Amount']);
						print ("<BR>");
						print("Term = " .$row['Term']);
						print(" months");
						print ("<BR>");
						print("Origination Fees = " .$row['Orig Fee']);
						print ("<BR>");
						print("Servicing Fees = " .$row['Svc Fee']);
						print ("<BR>");
						print("New Rate = " .$row['New Rate']);
						print ("<BR>");
						print("Effective Rate = " .$row['Effective Rate']);
						print ("<BR>");
						print("Payment = " .$row['Payment']);
						print ("<BR>");
						print ("Reward Redemption Rate = " .$row['Reward Rdmpt']);
						print ("<BR> <BR>");
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
</body>
</html>


  </body>

</html>
