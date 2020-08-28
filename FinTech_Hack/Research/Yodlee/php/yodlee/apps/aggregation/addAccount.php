<?php 

/*
*	App/Test Script to Try Add Account Flow & Once Added Successfully , check the Refresh Status for the same.
*	As any Yodlee API needs valid cobSessionToken and userSessionToken, first the login API will be called followed by respective provider, 
*   account & refresh APIs.
*	Internally uses Login class available under <YODLEE_APPS_DIR>/yodlee/api/authentication/login to perform the same.
*
*	common.php  : provides functions for cobrand login and user login and internally calls Login API libraries.
*   include.php : prvides mechanism to import configurations from <YODLEE_APPS_DIR>/yodlee/conf/myapp.ini 
*/

include (__DIR__.'/../common/common.php');
include (__DIR__.'/../../include/include.php');

Utils::logMessage("yodleeApis","========================================================================".PHP_EOL);
Utils::logMessage("yodleeApis","=========Sample Library For Provider APIs=================".PHP_EOL);
Utils::logMessage("yodleeApis","========================================================================".PHP_EOL.PHP_EOL);

$fq_name = "AddAccountApp";

try {
	$cobSessionToken = cobrandLogin($fq_name,$cobLoginUrl,$cobrandLogin,$cobrandPassword);
	$userSessionToken = userLogin($fq_name,$userLoginUrl,$cobSessionToken,$userLogin,$userPassword);
	// For Non MFA - sample account 16441
	$provider = getProviderDetails($fq_name,$providerUrl,$cobSessionToken,$userSessionToken,16441);
	$mod_provider = parseAndPopulateProviderDetails($provider,'DBmet1.site16441.1','site16441.1');
	addAccount($fq_name,$providerUrl,$cobSessionToken,$userSessionToken,$mod_provider);
	Utils::logMessage($fq_name,"Please provide providerAccountId: ");
    $accountId = Utils::read_stdin();
	$refreshStatus = getRefreshStatus($fq_name,$refreshUrl,$cobSessionToken,$userSessionToken,$accountId);

	// For MFA - sample account 16442
	$provider_mfa = getProviderDetails($fq_name,$providerUrl,$cobSessionToken,$userSessionToken,16442);
	$mod_provider_mfa = parseAndPopulateProviderDetails($provider_mfa,'testrazatsite.site16442.2','site16442.2');
	//echo "mod_provider_mfa:::".$mod_provider_mfa;
	$accountId_mfa = addAccount($fq_name,$providerUrl,$cobSessionToken,$userSessionToken,$mod_provider_mfa);

	// refresh for token
	Utils::logMessage($fq_name,"Please provide providerAccountId: ");
	$accountId_mfa_ip = Utils::read_stdin();
	$refreshStatus_mfa = getRefreshStatus($fq_name,$refreshUrl,$cobSessionToken,$userSessionToken,$accountId_mfa_ip);
	
    // mfa challenge for token
	$mfaChallenge = parseAndPopulateLoginFormForToken($refreshStatus_mfa);
	postMFAChallenge($fq_name,$providerUrl,$cobSessionToken,$userSessionToken,$accountId_mfa,$mfaChallenge);

	// refresh for security question answer
	Utils::logMessage($fq_name,"Please provide providerAccountId: ");
	$accountId_mfa_ip = Utils::read_stdin();
	$refreshStatus_mfa = getRefreshStatus($fq_name,$refreshUrl,$cobSessionToken,$userSessionToken,$accountId_mfa_ip);
	
    // mfa challenge for security question answer
	$mfaChallenge = parseAndPopulateLoginFormForToken($refreshStatus_mfa);
	postMFAChallenge($fq_name,$providerUrl,$cobSessionToken,$userSessionToken,$accountId_mfa,$mfaChallenge);

	// refresh call status should be login_success now..
	Utils::logMessage($fq_name,"Please provide providerAccountId: ");
	$accountId_mfa_ip = Utils::read_stdin();
	$refreshStatus_mfa = getRefreshStatus($fq_name,$refreshUrl,$cobSessionToken,$userSessionToken,$accountId_mfa_ip);

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

function getProviderDetails($fq_name,$url,$cobSessionToken,$userSessionToken,$providerId) {
	Utils::logMessage($fq_name,"#####################################".PHP_EOL);
	Utils::logMessage($fq_name,"## Initiating Get Provider Details ## For ProviderId :: ".$providerId.PHP_EOL.PHP_EOL);
	if(!Utils::confirmSelect()) {exit();}
	//$providerId = 16441;
	Utils::logMessage($fq_name,"Retrieving Provider details : ".PHP_EOL);
	Utils::logMessage($fq_name,"providerId: ".$providerId.PHP_EOL);
	$provd = new Provider();
	$responseObj = $provd -> getProviderDetails($url,$cobSessionToken,$userSessionToken,$providerId);
	$errorDetails = Utils::checkForError($responseObj);
		if(!empty($errorDetails)) {
			Utils::printErrorDetails($errorDetails);
			throw new Exception($responseObj['body']);
		} else {
			$provider = $responseObj['body'];
			return $provider;
		}
}


function parseAndPopulateProviderDetails($provider,$field_value_0,$field_value_1) {
		$resObj = Utils::parseJson($provider);
		$providerObj = $resObj['provider'];
		$loginForm = $providerObj[0]['loginForm'];	
		$rows = $loginForm['row'];
		$rows[0]['field'][0]['value']= $field_value_0;
		$rows[1]['field'][0]['value']= $field_value_1;
		$loginForm['row'][0]=$rows[0];
		$loginForm['row'][1]=$rows[1];
		$providerObj[0]['loginForm'] = $loginForm;
		$mod_provider_obj = array('provider'=>$providerObj);
		return $mod_provider_obj;
}

function parseAndPopulateLoginFormForToken($refresh) {
		
		$resObj = Utils::parseJson($refresh);
		$loginForm = $resObj['loginForm'];
		$providerParam = json_encode($loginForm,JSON_UNESCAPED_UNICODE);
		echo "<<<>>>:::".$providerParam.PHP_EOL.PHP_EOL;
		$formType = $loginForm['formType'];
		echo PHP_EOL."formType :::".$formType.PHP_EOL;
		
		if(empty($formType)) {
			echo PHP_EOL.":::Inside Else Scenario:::".PHP_EOL;
			return null;
		} else if($formType == 'token') {
			echo PHP_EOL.":::Token Scenario:::".PHP_EOL;
			$rows = $loginForm['row'];
			$rows[0]['field'][0]['value']= '123456';
			$loginForm['row'][0]=$rows[0];
		} else if($formType=='questionAndAnswer') {
			echo PHP_EOL.":::Q&A Scenario:::".PHP_EOL;
			$rows = $loginForm['row'];
			$rows[0]['field'][0]['value']= 'Texas';
			$rows[1]['field'][0]['value']= 'w3schools';
			$loginForm['row'][0]=$rows[0];
			$loginForm['row'][1]=$rows[1];
		} else if($formType=='image') {
			echo PHP_EOL.":::Image Scenario:::".PHP_EOL;
			$rows = $loginForm['row'];
			$rows[0]['field'][0]['value']= '5678';
			$loginForm['row'][0]=$rows[0];
		}
	
		$providerParam = json_encode($loginForm,JSON_UNESCAPED_UNICODE);
		echo "<<<>>>:::".$providerParam.PHP_EOL.PHP_EOL;
		$resObj['loginForm'] = $loginForm;
	    $mod_loginForm_obj = array('loginForm'=>$resObj['loginForm']);
		//$mod_loginForm_obj_str = json_encode($mod_loginForm_obj,JSON_UNESCAPED_UNICODE);
		//echo "<<<>>>:::".$mod_loginForm_obj_str.PHP_EOL.PHP_EOL;
		return $mod_loginForm_obj;
}

function parseAndPopulateLoginFormForQuesAns($refresh) {
		$resObj = Utils::parseJson($refresh);
		$loginForm = $resObj['loginForm'];
		$providerParam = json_encode($loginForm,JSON_UNESCAPED_UNICODE);
		echo "<<<>>>:::".$providerParam.PHP_EOL.PHP_EOL;
		$rows = $loginForm['row'];
		$rows[0]['field'][0]['value']= 'Texas';
		$rows[1]['field'][0]['value']= 'w3schools';
		$loginForm['row'][0]=$rows[0];
		$loginForm['row'][1]=$rows[1];
		$providerParam = json_encode($loginForm,JSON_UNESCAPED_UNICODE);
		echo "<<<>>>:::".$providerParam.PHP_EOL.PHP_EOL;
		$resObj['loginForm'] = $loginForm;
	    $mod_loginForm_obj = array('loginForm'=>$resObj['loginForm']);
		//$mod_loginForm_obj_str = json_encode($mod_loginForm_obj,JSON_UNESCAPED_UNICODE);
		//echo "<<<>>>:::".$mod_loginForm_obj_str.PHP_EOL.PHP_EOL;
		return $mod_loginForm_obj;
}

function addAccount($fq_name,$url,$cobSession,$userSession,$mod_provider_obj) {
	$providerId = $mod_provider_obj['provider'][0]['id'];
	$providerParam = json_encode($mod_provider_obj,JSON_UNESCAPED_UNICODE);
	Utils::logMessage($fq_name,"providerParam:::>>::".$providerParam);
	$provd = new Provider();
	$response = $provd -> addAccountForProvider($url,$cobSession,$userSession,$providerId,$providerParam);
	Utils::logMessage($fq_name,">>>>>response['body']:::>>::".$response['body']);
	$responseArr = Utils::parseJson($response['body']);
	return $responseArr['providerAccountId'];
	// write the code to parse and get accountId, same will be used for refreshStatus...
}

function postMFAChallenge($fq_name,$url,$cobSession,$userSession,$providerAccountId,$mfaChallengeObj) {
	$provd = new Provider();
	$mfaChallenge = json_encode($mfaChallengeObj,JSON_UNESCAPED_UNICODE);
	Utils::logMessage($fq_name,"mfaChallenge:::>>::".$mfaChallenge);
	$response = $provd -> postMFAChallenge($url,$cobSession,$userSession,$providerAccountId,$mfaChallenge);
	Utils::logMessage($fq_name,">>>>>response['body']:::>>::".$response['body']);
}

function getRefreshStatus($fq_name,$url,$cobSession,$userSession,$accountId) {
	$provd = new Provider();
	$response = $provd->getRefreshStatus($url,$cobSession,$userSession,$accountId);
	return $response['body'];
}


?>