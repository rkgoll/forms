<?php
	
include (__DIR__.'/../api/authentication/login/login.php');
include (__DIR__.'/../util/utils.php');
include (__DIR__.'/../util/curl_util.php');
include (__DIR__.'/../api/pfm/accounts/accounts.php');
include (__DIR__.'/../api/pfm/transactions/transactions.php');
include (__DIR__.'/../api/aggregation/provider/provider.php');
include (__DIR__.'/../api/pfm/holdings/holdings.php');
include (__DIR__.'/../api/pfm/bills/bills.php');


$ini_array = parse_ini_file(__DIR__."/../conf/myapp.ini");

# Set Up Global Variable For Proxy Scenarios If Configured	
if(!empty($ini_array['HTTP_PROXY'])) $GLOBALS['HTTP_PROXY'] = $ini_array['HTTP_PROXY'];
$GLOBALS['BASE_URL'] = $ini_array['BASE_URL'];
if(!empty($ini_array['ENABLE_LOGS'])) $GLOBALS['ENABLE_LOGS'] = $ini_array['ENABLE_LOGS'];


## Populate All Data From Config File myapp.ini
## Populate All Data From Config File myapp.ini
$cobLoginUrl = $ini_array["BASE_URL"].$ini_array["COB_LOGIN_URL"];
$userLoginUrl = $ini_array["BASE_URL"].$ini_array["USER_LOGIN_URL"];
$cobrandLogin = $ini_array["COBRAND_LOGIN"];
$cobrandPassword = $ini_array["COBRAND_PASSWORD"];
$userLogin = $ini_array["USER_LOGIN"];
$userPassword = $ini_array["USER_PASSWORD"];
$accountsUrl = $ini_array["BASE_URL"].$ini_array["GET_ACCOUNTS_URL"];
$transactionsCountUrl = $ini_array["BASE_URL"].$ini_array["GET_TRANSACTIONS_COUNT_URL"];
$transactionCategoriesUrl =  $ini_array["BASE_URL"].$ini_array["GET_TRANSACTIONS_CATEGORIES_URL"];
$transactionsUrl = $ini_array["BASE_URL"].$ini_array["GET_TRANSACTIONS_URL"];$holdingTypeUrl = $ini_array["BASE_URL"].$ini_array["GET_HOLDING_TYPES_URL"];
$holdingsUrl = $ini_array["BASE_URL"].$ini_array["GET_HOLDING_URL"];
$billsUrl = $ini_array["BASE_URL"].$ini_array["GET_BILLS_URL"];
$providerUrl = $ini_array["BASE_URL"].$ini_array["SITE_URL"];
$refreshUrl = $ini_array["BASE_URL"].$ini_array["REFRESH_URL"];

?>