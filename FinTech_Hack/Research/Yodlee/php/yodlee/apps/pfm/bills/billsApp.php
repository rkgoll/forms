<?php 

/*
*	App/Test Script to Try bills APIs.
*	As any Yodlee API needs valid cobSessionToken and userSessionToken, first the login API will be called followed by respective bills APIs
*   
*	a) Bill details for a specific user  
*	
*	Internally uses Login class available under <YODLEE_APPS_DIR>/yodlee/api/authentication/login 
*					Bill  class available under <YODLEE_APPS_DIR>/yodlee/api/pfm/accounts to perform the same.
*
*	common.php  : provides functions for cobrand login and user login and internally calls Login API libraries.
*   include.php : prvides mechanism to import configurations from <YODLEE_APPS_DIR>/yodlee/conf/myapp.ini 
*/

include (__DIR__.'/../../common/common.php');
include (__DIR__.'/../../../include/include.php');

Utils::logMessage("yodleeApis","========================================================================".PHP_EOL);
Utils::logMessage("yodleeApis","=========Sample Library For Bills APIs=================".PHP_EOL);
Utils::logMessage("yodleeApis","========================================================================".PHP_EOL.PHP_EOL);

$fq_name = "BillsApp";

try {
	$cobSessionToken = cobrandLogin($fq_name,$cobLoginUrl,$cobrandLogin,$cobrandPassword);
	$userSessionToken = userLogin($fq_name,$userLoginUrl,$cobSessionToken,$userLogin,$userPassword);
	$bills = getBills($fq_name,$billsUrl,$cobSessionToken,$userSessionToken);
} catch(Exception $e) {
	Utils::logMessage($fq_name,">> Exception >> ".PHP_EOL);
	Utils::logMessage($fq_name,$e -> getMessage());	
}

###################### Utility Functions #########################

function getBills($fq_name,$url,$cobSessionToken,$userSessionToken) {
	Utils::logMessage($fq_name,"##########################".PHP_EOL);
	Utils::logMessage($fq_name,"## Initiating GET Bills ## ".PHP_EOL.PHP_EOL);
	if(!Utils::confirmSelect()) {exit();}
	$bill = new Bill();
	$responseObj = $bill-> getBills($url,$cobSessionToken,$userSessionToken);
	$errorDetails = Utils::checkForError($responseObj);
		if(!empty($errorDetails)) {
			Utils::printErrorDetails($errorDetails);
			throw new Exception($responseObj['body']);
		} else {
			$billsArr = $bill -> parseBills($responseObj);
			// sample on how to iterate over transactionsArr
			Utils::printDetailsFromArray($billsArr,'Bills');
			Utils::logMessage($fq_name,">> Number of Bills ".count($billsArr).PHP_EOL.PHP_EOL.PHP_EOL);
			return $billsArr;
		}
}

?>