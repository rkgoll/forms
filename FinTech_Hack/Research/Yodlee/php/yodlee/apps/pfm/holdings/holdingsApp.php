<?php 

/*
*	App/Test Script to Try holdings APIs.
*	As any Yodlee API needs valid cobSessionToken and userSessionToken, first the login API will be called followed by respective holdings APIs
*   
*	a) holdings details for a specific user and 
*	a) holding types
*	
*	Internally uses Login class available under <YODLEE_APPS_DIR>/yodlee/api/authentication/login 
				and Holding class available under <YODLEE_APPS_DIR>/yodlee/api/pfm/holdings to perform the same.
*
*	common.php  : provides functions for cobrand login and user login and internally calls Login API libraries.
*   include.php : prvides mechanism to import configurations from <YODLEE_APPS_DIR>/yodlee/conf/myapp.ini 
*/

include (__DIR__.'/../../common/common.php');
include (__DIR__.'/../../../include/include.php');

$fq_name = "HoldingsApp";

Utils::logMessage($fq_name,"========================================================================".PHP_EOL);
Utils::logMessage($fq_name,"=========Sample Library For Holdings APIs=================".PHP_EOL);
Utils::logMessage($fq_name,"========================================================================".PHP_EOL.PHP_EOL);

try {
	$cobSessionToken = cobrandLogin($fq_name,$cobLoginUrl,$cobrandLogin,$cobrandPassword);
	$userSessionToken = userLogin($fq_name,$userLoginUrl,$cobSessionToken,$userLogin,$userPassword);
	$holdingTypes = getHoldingType($fq_name,$holdingTypeUrl,$cobSessionToken,$userSessionToken);
	$holdings = getHoldings($fq_name,$holdingsUrl,$cobSessionToken,$userSessionToken);
} catch(Exception $e) {
	Utils::logMessage($fq_name,">> Exception >> ".PHP_EOL);
	Utils::logMessage($fq_name,$e -> getMessage());	
}

###################### Utility Functions #########################

function getHoldingType($fq_name,$url,$cobSessionToken,$userSessionToken) {
	Utils::logMessage($fq_name,"#################################".PHP_EOL);
	Utils::logMessage($fq_name,"## Initiating GET Holding Type ## ".PHP_EOL.PHP_EOL);
	if(!Utils::confirmSelect()) {exit();}
	$holding = new Holding();
	$responseObj = $holding->getHoldingTypes($url,$cobSessionToken,$userSessionToken);
	$errorDetails = Utils::checkForError($responseObj);
	if(!empty($errorDetails)) {
		Utils::printErrorDetails($errorDetails);
		throw new Exception($responseObj['body']);
	} else {
		$holdingsArr = $holding -> parseHoldings($responseObj);
		// sample on how to iterate over holdingsArr
		Utils::printDetailsFromArray($holdingsArr,'Holding Types');
		Utils::logMessage($fq_name,">> Number of Holding Types ".count($holdingsArr).PHP_EOL.PHP_EOL.PHP_EOL);
		return $holdingsArr;
	}
}

function getHoldings($fq_name,$url,$cobSessionToken,$userSessionToken) {
		Utils::logMessage($fq_name,"#############################".PHP_EOL);
		Utils::logMessage($fq_name,"## Initiating GET Holdings ## ".PHP_EOL.PHP_EOL);
		if(!Utils::confirmSelect()) {exit();}

		Utils::logMessage($fq_name,"Please provide following details: " . PHP_EOL);
	    $queryArgs = array();
	    
	    Utils::logMessage($fq_name,"holdingType: ");
	    $holdingType = Utils::read_stdin();
	    if (!empty($holdingType)) {$queryArgs['holdingType'] = $holdingType;}

	    Utils::logMessage($fq_name,"accountId: ");
	    $accountId = Utils::read_stdin();
	    if (!empty($accountId)) {$queryArgs['accountId'] = $accountId;}	
		
		$holding = new Holding();
		$responseObj = $holding->getHoldings($url,$cobSessionToken,$userSessionToken,$queryArgs);
		//Utils::logMessage($fq_name,"## holdingsResponse ## :".$holdingsResponse.PHP_EOL.PHP_EOL);
		$errorDetails = Utils::checkForError($responseObj);
		if(!empty($errorDetails)) {
			Utils::printErrorDetails($errorDetails);
			throw new Exception($responseObj['body']);
		} else {
			$holdingsArr = $holding -> parseHoldings($responseObj);
			// sample on how to iterate over holdingsArr
			Utils::printDetailsFromArray($holdingsArr,'Holdings');
			Utils::logMessage($fq_name,">> Number of Holdings ".count($holdingsArr).PHP_EOL.PHP_EOL.PHP_EOL);
			return $holdingsArr;
		}
}

?>