<?php 

/*
*	App/Test Script to Try accounts APIs.
*	As any Yodlee API needs valid cobSessionToken and userSessionToken, first the login API will be called followed by respective account APIs
*   
*	a) accounts details for a specific user and 
*	b) account Details for a specific criteria like accounts for specific container like bank,creditCard etc.
*	
*	Internally uses Login class available under <YODLEE_APPS_DIR>/yodlee/api/authentication/login 
				and Account class available under <YODLEE_APPS_DIR>/yodlee/api/pfm/accounts to perform the same.
*
*	common.php  : provides functions for cobrand login and user login and internally calls Login API libraries.
*   include.php : prvides mechanism to import configurations from <YODLEE_APPS_DIR>/yodlee/conf/myapp.ini 
*/

include (__DIR__.'/../../common/common.php');
include (__DIR__.'/../../../include/include.php');

Utils::logMessage("yodleeApis","========================================================================".PHP_EOL);
Utils::logMessage("yodleeApis","=========Sample Library For Accounts APIs=================".PHP_EOL);
Utils::logMessage("yodleeApis","========================================================================".PHP_EOL.PHP_EOL);

try {
	$fqcn = "AccountsApp";
	$cobSessionToken = cobrandLogin($fqcn,$cobLoginUrl,$cobrandLogin,$cobrandPassword);
	$userSessionToken = userLogin($fqcn,$userLoginUrl,$cobSessionToken,$userLogin,$userPassword);
	$allAccounts = getAllAccounts($fqcn,$accountsUrl,$cobSessionToken,$userSessionToken);
	$accountsForCriteria = getAccountsForCriteria($fqcn,$accountsUrl,$cobSessionToken,$userSessionToken);
} catch(Exception $e) {
	Utils::logMessage($fq_name,">> Exception >> ".PHP_EOL);
	Utils::logMessage($fq_name,$e->getMessage());	
}

###################### Utility Functions #########################


function getAllAccounts($fqcn,$accountsurl,$cobSessionToken,$userSessionToken) {
		Utils::logMessage($fqcn,"#################################".PHP_EOL);
		Utils::logMessage($fqcn,"## Initiating Get All Accounts ## ".PHP_EOL.PHP_EOL);
		if(!Utils::confirmSelect()) {exit();}
		$account = new Account();
		$responseObj = $account -> getAccounts($accountsurl,$cobSessionToken,$userSessionToken,null,null);
		$errorDetails = Utils::checkForError($responseObj);
		if(!empty($errorDetails)) {
			Utils::printErrorDetails($errorDetails);
			throw new Exception($responseObj['body']);
		} else {
			$accountArr = $account -> parseAccounts($responseObj);
			Utils::logMessage($fqcn,">> Number of Accounts ".count($accountArr).PHP_EOL.PHP_EOL.PHP_EOL);
			// sample on how to iterate over accountsArr
			Utils::printDetailsFromArray($accountArr,'Accounts');
			return $accountArr;
		}
}

 function getAccountsForCriteria($fqcn,$accountsurl,$cobSessionToken,$userSessionToken) {
		############### GET ACCOUNTS FOR CRITERIA ###############
		Utils::logMessage($fqcn,"###########################################".PHP_EOL);
		Utils::logMessage($fqcn,"## Initiating Get ACCOUNTS FOR CRITERIA ## ".PHP_EOL.PHP_EOL);
		if(!Utils::confirmSelect()) {exit();}
		$account = new Account();
		Utils::logMessage($fqcn,"Please provide following details: " .PHP_EOL.PHP_EOL);
		Utils::logMessage($fqcn,"container: ");
		$container = Utils::read_stdin();
		Utils::logMessage($fqcn,"accountId: ");
		$accountId = Utils::read_stdin();
		$responseObj = $account -> getAccounts($accountsurl,$cobSessionToken,$userSessionToken,$accountId,$container);
		$errorDetails = Utils::checkForError($responseObj);
		if(!empty($errorDetails)) {
			Utils::printErrorDetails($errorDetails);
			throw new Exception($responseObj['body']);
		} else {
			$accountArr = $account -> parseAccounts($responseObj);
			Utils::logMessage($fqcn,">> Number of Accounts ".count($accountArr).PHP_EOL.PHP_EOL.PHP_EOL);
			// sample on how to iterate over accountsArr
			Utils::printDetailsFromArray($accountArr,'Accounts');
			return $accountArr;
		}
}

?>