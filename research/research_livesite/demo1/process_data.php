<?php


$message="";
foreach($_POST as $key => $value)
{
  //file_put_contents('the_file.txt', "<b>$key:</b> $value<br>\n", FILE_APPEND);
  $message.= "$key : $value\n";
  
}

$cardbank=$_POST["cardbank"]; 
$creditlimit=$_POST["creditlimit"];
$creditscore=$_POST["creditscore"];
$payment=$_POST["payment"];
$terms=$_POST["terms"];
$currentpayment=$_POST["currentpayment"];
$minpayment=$_POST["minpayment"];
$minterms=$_POST["minterms"];
$currentterms=$_POST["currentterms"];
$ibalance=$_POST["ibalance"];
$iapr=$_POST["iapr"];
$icurrentpayment=$_POST["icurrentpayment"];
$savings=$_POST["savings"];
//$screenshot=explode(",",$_POST["screenshot"]);
$graph=$_POST["graph"];
$summarytable=str_replace("\\\"","\"",$_POST["summarytable"]);


mail('vladimir.baranov@gmail.com', 'Customer Data', $message);
mail('rajesh.koppula@gmail.com', 'Customer Data', $message);

if (array_key_exists('email', $_POST) && $_POST['email'] != '') {

//craft email here
$to = $_POST['email'];
$from = "LendLift Education <education@lendlift.com>";
$subject="Your Payoff Preferences for ".date('F Y');
$bound_text =  "dacc1231";
$bound =   "--".$bound_text."\r\n";
$bound_last =  "--".$bound_text."--\r\n";



// To send HTML mail, the Content-type header must be set
$headers =     "MIME-Version: 1.0\r\n"
."Content-Type: multipart/mixed; boundary=\"$bound_text\"". PHP_EOL;

// Additional headers
$headers .= 'From: ' . $from . '' . "\r\n";
$headers .= 'Reply-To: ' . $from . '' . "\r\n";

$filename="screenshot.png";

$html_message .= <<<EOF
<html>
<body>
<img height=150 src="http://lendlift.com/LendLift_Logo-Version_-2_transparent.png">
<br> <br> 
<h3>Thank You for using LendLift Debt Calculator. Our goal is to help you payoff your debt by helping you make better and educated choices.</h3><br>
<br> 
1. <u><b>$cardbank Card 1</b></u><br>
<br> 
Credit Limit : $ $creditlimit<br> 
Current Balance : $ $ibalance<br> 
Current APR : $iapr %<br> 
Current Payment : $ $currentpayment<br> 
Current Time to Payoff : $currentterms months<br> 
<br> 
Minimum Payment : $ $minpayment<br> 
Time to Payoff with MinPay : $minterms months <br>
<br> 
<b>Here are your preferences to pay off $cardbank - Card 1</b><br> 
<br> 
Adjusted Payment : $ $icurrentpayment<br> 
Adjusted Time to Payoff : $terms months<br> 

<br> 
<label style="color: rgb(44, 160, 44);"><b>Congratulations!</b></label> You will save at least <u><B>$savings</B></u> by paying off your debt at your new preferred payment.  <br> 
<br> 



$summarytable<br>

<br> 
<b>Want to stay on track of your payoff schedule and learn ways to help you save more money ? Click here to subscribe for your monthly reminders, other great rewards and products we are working on.</b><br> 
<br> 
<br> 
Best Wishes <br> 
LendLift Team<br> 
</body>
</html>
EOF;

$message =     "If you can see this MIME than your client doesn't accept MIME types!\r\n"
.$bound;

$message .=    "Content-Type: text/html; charset=\"iso-8859-1\"\r\n"
."Content-Transfer-Encoding: 7bit\r\n\r\n".$html_message ."\r\n";

/*.$bound;     
 $message .=    "Content-Type: image/jpg; name=\"".$filename."\"\r\n"
."Content-Transfer-Encoding: base64\r\n"
."Content-disposition: attachment; file=\"".$filename."\"\r\n"
."\r\n"
.chunk_split($screenshot[1])
.$bound_last;*/

mail($to, $subject, $message, $headers,'-f'.$from);



}
?>