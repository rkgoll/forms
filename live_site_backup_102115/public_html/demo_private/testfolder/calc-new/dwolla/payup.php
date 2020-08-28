
<?php
//request money from user or from bank account
$apiKey="Al+hyd4K/U7QW1EONAbtzxdN/kyVKbPLF3dsOQB/JOv4PLo4r4";
$apiSecret="wSA8M7c3M22vy7TNjxNgWPRilFgYhFMIwLtPrfWVVlTRccLbxi";

$Dwolla = new DwollaRestClient($apiKey, $apiSecret);
$url = $Dwolla->getAuthUrl();
header("Location: {$url}");
$token = $Dwolla->requestToken($_GET['code']);

$pin			= '5692';
$sourceId		= 'rajesh@lendlift.com';
$sourceType		= 'email';
$amount			= 0.10;
$notes			= 'Lendlift Test';

$tid = $Dwolla->send($pin, $sourceId, $amount, $sourceType, $notes);
if(!$tid) { echo "Error: {$Dwolla->getError()} \n"; }
echo "Request ID: {$tid} \n";

?>