<?php 

/*
*	App/Test Script to try cobrandLogin & userLogin using provided client libraries....
*	Internally uses Login class available under <YODLEE_APPS_DIR>/yodlee/api/authentication/login to perform the same.
*
*	common.php  : provides functions for cobrand login and user login and internally calls Login API libraries.
*   include.php : prvides mechanism to import configurations from <YODLEE_APPS_DIR>/yodlee/conf/myapp.ini 
*/

include (__DIR__.'/../../common/common.php');
include (__DIR__.'/../../../include/include.php');

$fq_name = "LoginApp";

Utils::logMessage($fq_name,"========================================================================".PHP_EOL);
Utils::logMessage($fq_name,"=========Sample Login App For Yodlee APIs=================".PHP_EOL);
Utils::logMessage($fq_name,"========================================================================".PHP_EOL.PHP_EOL);


try {
	$cobSessionToken = cobrandLogin($fq_name,$cobLoginUrl,$cobrandLogin,$cobrandPassword);
	$userSessionToken = userLogin($fq_name,$userLoginUrl,$cobSessionToken,$userLogin,$userPassword);
	Utils::logMessage($fq_name,">> cobSessionToken >> ".$cobSessionToken.PHP_EOL);
	Utils::logMessage($fq_name,">> userSessionToken >> ".$userSessionToken.PHP_EOL);
} catch(Exception $e) {
	Utils::logMessage($fq_name,">> Exception >> ".PHP_EOL);
	Utils::logMessage($fq_name,$e->getMessage());	
}

?>