<?php 

/*
*	App/Test Script to Try provider APIs.
*	As any Yodlee API needs valid cobSessionToken and userSessionToken, first the login API will be called followed by respective provider APIs
*   like searchProvider, providerDetails and extract LoginForm from providerDetails
*	Internally uses Login   class available under <YODLEE_APPS_DIR>/yodlee/api/authentication/login and 
*					Provider class available under <YODLEE_APPS_DIR>/yodlee/api/aggregation/provider  to perform the same.
*
*	common.php  : provides functions for cobrand login and user login and internally calls Login API libraries.
*   include.php : prvides mechanism to import configurations from <YODLEE_APPS_DIR>/yodlee/conf/myapp.ini 
*/

include (__DIR__.'/../common/common.php');
include (__DIR__.'/../../include/include.php');

$fq_name = "ProviderApp";
Utils::logMessage($fq_name,"========================================================================".PHP_EOL);
Utils::logMessage($fq_name,"=========Sample Library For Provider APIs=================".PHP_EOL);
Utils::logMessage($fq_name,"========================================================================".PHP_EOL.PHP_EOL);

try {
	$cobSessionToken = cobrandLogin($fq_name,$cobLoginUrl,$cobrandLogin,$cobrandPassword);
	$userSessionToken = userLogin($fq_name,$userLoginUrl,$cobSessionToken,$userLogin,$userPassword);
	$providers = searchProvider($fq_name,$providerUrl,$cobSessionToken,$userSessionToken);
	$provider = getProviderDetails($fq_name,$providerUrl,$cobSessionToken,$userSessionToken);
	//$loginForm = getLoginForm($fq_name,$provider);
	//$updatedLoginForm = populateLoginForm($fq_name,$loginForm);
} catch(Exception $e) {
	Utils::logMessage($fq_name,">> Exception >> ".PHP_EOL);
	Utils::logMessage($fq_name,$e -> getMessage());	
}

###################### Utility Functions #########################

function searchProvider($fq_name,$url,$cobSessionToken,$userSessionToken) {
	
	Utils::logMessage($fq_name,"##########################".PHP_EOL);
	Utils::logMessage($fq_name,"## Initiating Search Provider ## ".PHP_EOL.PHP_EOL);
	if(!Utils::confirmSelect()) {exit();}

	Utils::logMessage($fq_name,"Please provide following details: " . PHP_EOL);
	$provider = new Provider();
	$queryArgs = array();
	
	Utils::logMessage($fq_name,"priority: ");
	$priority = Utils::read_stdin();
	if (!empty($priority)) {$queryArgs['priority'] = $priority;}

	Utils::logMessage($fq_name,"name: ");
	$name = Utils::read_stdin();
	if (!empty($name)) {$queryArgs['name'] = $name;}	

	$responseObj = $provider->searchProvider($url,$cobSessionToken,$userSessionToken,$queryArgs);
	$errorDetails = Utils::checkForError($responseObj);
		if(!empty($errorDetails)) {
			Utils::printErrorDetails($errorDetails);
			throw new Exception($responseObj['body']);
		} else {
			$providerArr = $provider -> parseProviders($responseObj);
			Utils::printDetailsFromArray($providerArr,'Provider');
			Utils::logMessage($fq_name,">> Number of Providers ".count($providerArr).PHP_EOL.PHP_EOL.PHP_EOL);
			return $providerArr;
		}
}

function getProviderDetails($fq_name,$url,$cobSessionToken,$userSessionToken) {
	Utils::logMessage($fq_name,"#####################################".PHP_EOL);
	Utils::logMessage($fq_name,"## Initiating Get Provider Details ## ".PHP_EOL.PHP_EOL);
	if(!Utils::confirmSelect()) {exit();}
	Utils::logMessage($fq_name,"Please provide following details: " . PHP_EOL);
	Utils::logMessage($fq_name,"providerId: ");
	$providerId = Utils::read_stdin();
	$provd = new Provider();
	$responseObj = $provd -> getProviderDetails($url,$cobSessionToken,$userSessionToken,$providerId);
	$errorDetails = Utils::checkForError($responseObj);
		if(!empty($errorDetails)) {
			Utils::printErrorDetails($errorDetails);
			throw new Exception($responseObj['body']);
		} else {
			$providerDetails = $provd -> parseProviderDetails($responseObj);
			Utils::printDetailsFromArray($providerDetails,'Provider');
			Utils::logMessage($fq_name,"#####################################".PHP_EOL.PHP_EOL.PHP_EOL);
			return $providerDetails;
		}
}

function getLoginForm($fq_name,$provider) {
	Utils::logMessage($fq_name,"#####################################".PHP_EOL.PHP_EOL.PHP_EOL);
	Utils::logMessage($fq_name,"Trying to fetch LoginForm for provider: " . PHP_EOL.PHP_EOL);
	$provd = new Provider();
	$loginForm = $provd -> getLoginFormForProvider($provider);
	Utils::printKeyValue($loginForm,'LoginForm');
	Utils::logMessage($fq_name,"#####################################".PHP_EOL.PHP_EOL.PHP_EOL);
	return $loginForm;

}

function populateLoginForm($fq_name,$loginForm) {
	Utils::logMessage($fq_name,"#####################################".PHP_EOL.PHP_EOL.PHP_EOL);
	Utils::logMessage($fq_name,"Trying to populate data to loginForm: " . PHP_EOL.PHP_EOL);
	$provd = new Provider();
	$loginForm = $provd -> populateLoginFormForProvider($loginForm);
	//Utils::printDetailsFromArray($loginForm,'LoginForm');
	Utils::logMessage($fq_name,"#####################################".PHP_EOL.PHP_EOL.PHP_EOL);
	return $loginForm;
}


?>