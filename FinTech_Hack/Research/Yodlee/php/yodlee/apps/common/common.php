<?php 

/**
	This function abstracts the call to cobrandLogin available in Login class under
	<YODLEE_APPS_DIR>/yodlee/api/authentication/login
	returns cobSessionToken
**/

function cobrandLogin($fq_name,$cobLoginUrl,$cobrandLogin,$cobrandPassword) {
		Utils::logMessage($fq_name,"############################## ".PHP_EOL);
		Utils::logMessage($fq_name,"## Initiating Cobrand Login ## ".PHP_EOL.PHP_EOL);
		//if(!Utils::confirmSelect()) {exit();}
		Utils::logMessage($fq_name,"cobrandLogin:  ".$cobrandLogin.PHP_EOL.PHP_EOL);
		Utils::logMessage($fq_name,"cobrandPassword: ".$cobrandPassword.PHP_EOL.PHP_EOL);
		$login = new Login();
		$response = $login-> cobLogin($cobLoginUrl,$cobrandLogin,$cobrandPassword);
		$errorDetails = Utils::checkForError($response);
		if(!empty($errorDetails)) {
			Utils::printErrorDetails($errorDetails);
			throw new Exception($response['body']);
		} else {
			$cobSessionToken = $login -> parseCobLogin($response);
			return $cobSessionToken;
		}
}

/**
	This function abstracts the call to userLogin available in Login class under
	<YODLEE_APPS_DIR>/yodlee/api/authentication/login
	returns userSessionToken
**/
function userLogin($fq_name,$userLoginUrl,$cobSessionToken,$userLogin,$userPassword) {
		Utils::logMessage($fq_name,"############################## ".PHP_EOL);
		Utils::logMessage($fq_name,"## Initiating User Login ## ".PHP_EOL.PHP_EOL);
		//if(!Utils::confirmSelect()) {exit();}
		$login = new Login();
		Utils::logMessage($fq_name,"userLogin: ".$userLogin.PHP_EOL.PHP_EOL);
		Utils::logMessage($fq_name,"userPassword: ".$userPassword.PHP_EOL.PHP_EOL);
		$response = $login -> userLogin($userLoginUrl,$cobSessionToken,$userLogin,$userPassword); 
		$errorDetails = Utils::checkForError($response);
		if(!empty($errorDetails)) {
			Utils::printErrorDetails($errorDetails);
			throw new Exception($response['body']);
		} else {
			$userSessionToken = $login -> parseUserLogin($response);
			return $userSessionToken;
		}
}

?>