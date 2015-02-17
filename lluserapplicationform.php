---
layout: default
---
<div class="page-container">
  
  {% include header.html %}

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
						print("<ul><li>Loan Amount = " .$row['Loan Amount']"</li>");
						print("<li>Term = " .$row['Term']"months</li>");
						print("<li>Origination Fees = " .$row['Orig Fee']"</li>");
						print("<li>Servicing Fees = " .$row['Svc Fee']"</li>");
						print("<li>New Rate = " .$row['New Rate']"</li>");
						print("<li>Effective Rate = " .$row['Effective Rate']"</li>");
						print("<li>Payment = " .$row['Payment']"</li>");
						print ("<li>Reward Redemption Rate = " .$row['Reward Rdmpt']"</li></ul>");
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
