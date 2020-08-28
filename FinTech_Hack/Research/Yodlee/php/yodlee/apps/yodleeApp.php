<?php 

/*
*	App/Test Script to Try yodlee authentication/aggregation/pfm APIs.
*	As any (aggregation/pfm) Yodlee API needs valid cobSessionToken and userSessionToken, first the login API will be called followed by aggregation/pfm APIs
*   
*	a) login apis
*	b) accounts apis
*	c) transactions apis
*	d) holdings apis
*	e) bills apis
*	f) provider apis
*	g) add accounts/refresh
*
*	Internally uses 
*				Login class available under <YODLEE_APPS_DIR>/yodlee/api/authentication/login 
*				Transaction class available under <YODLEE_APPS_DIR>/yodlee/api/pfm/transaction 
*				Provider class available under <YODLEE_APPS_DIR>/yodlee/api/aggregation/provider
*				Account class available under <YODLEE_APPS_DIR>/yodlee/api/pfm/accounts
*				Bill  class available under <YODLEE_APPS_DIR>/yodlee/api/pfm/accounts
*
*
*	common.php  : provides functions for cobrand login and user login and internally calls Login API libraries.
*   include.php : prvides mechanism to import configurations from <YODLEE_APPS_DIR>/yodlee/conf/myapp.ini 
*/


include (__DIR__.'/common/common.php');
include (__DIR__.'/../include/include.php');

$fq_name = "YodleeApp";

Utils::logMessage($fq_name,"========================================================================".PHP_EOL);
Utils::logMessage($fq_name,"=========Sample Library For Yodlee Aggregation/PFM APIs=================".PHP_EOL);
Utils::logMessage($fq_name,"========================================================================".PHP_EOL.PHP_EOL);

try {
	$cobSessionToken = cobrandLogin($fq_name,$cobLoginUrl,$cobrandLogin,$cobrandPassword);
	$userSessionToken = userLogin($fq_name,$userLoginUrl,$cobSessionToken,$userLogin,$userPassword);
	$allAccounts = getAllAccounts($fq_name,$accountsUrl,$cobSessionToken,$userSessionToken);
	$accountsForCriteria = getAccountsForCriteria($fq_name,$accountsUrl,$cobSessionToken,$userSessionToken);
	$transactionCount = getTransactionCount($fq_name,$transactionsCountUrl,$cobSessionToken,$userSessionToken);
	$transactionCategories = getTransactionCategories($fq_name,$transactionCategoriesUrl,$cobSessionToken,$userSessionToken);
	$allTransactions = getAllTransactions($fq_name,$transactionsUrl,$cobSessionToken,$userSessionToken);
	$transactionsForCriteria = getTransactionsForCriteria($fq_name,$transactionsUrl,$cobSessionToken,$userSessionToken);
	$holdingTypes = getHoldingType($fq_name,$holdingTypeUrl,$cobSessionToken,$userSessionToken);
	$holdings = getHoldings($fq_name,$holdingsUrl,$cobSessionToken,$userSessionToken);
	$bills = getBills($fq_name,$billsUrl,$cobSessionToken,$userSessionToken);
	$provider = getProviderDetails($fq_name,$providerUrl,$cobSessionToken,$userSessionToken);
	$mod_provider = parseAndPopulateProviderDetails($provider);
	$accountId = addAccount($fq_name,$providerUrl,$cobSessionToken,$userSessionToken,$mod_provider);
	$refreshStatus = getRefreshStatus($fq_name,$refreshUrl,$cobSessionToken,$userSessionToken,$accountId);

} catch(Exception $e) {
	Utils::logMessage($fq_name,">> Exception >> ".PHP_EOL);
	Utils::logMessage($fq_name,$e->getMessage());	
}

###################### Utility Functions #########################


function getAllAccounts($fq_name,$accountsurl,$cobSessionToken,$userSessionToken) {
		Utils::logMessage($fq_name,"#################################".PHP_EOL);
		Utils::logMessage($fq_name,"## Initiating Get All Accounts ## ".PHP_EOL.PHP_EOL);
		if(!Utils::confirmSelect()) {exit();}
		$account = new Account();
		$responseObj = $account -> getAccounts($accountsurl,$cobSessionToken,$userSessionToken,null,null);
		$errorDetails = Utils::checkForError($responseObj);
		if(!empty($errorDetails)) {
			Utils::printErrorDetails($errorDetails);
			throw new Exception($responseObj['body']);
		} else {
			$accountArr = $account -> parseAccounts($responseObj);
			Utils::logMessage($fq_name,">> Number of Accounts ".count($accountArr).PHP_EOL.PHP_EOL.PHP_EOL);
			// sample on how to iterate over accountsArr
			Utils::printDetailsFromArray($accountArr,'Accounts');
			return $accountArr;
		}
}

 function getAccountsForCriteria($fq_name,$accountsurl,$cobSessionToken,$userSessionToken) {
		############### GET ACCOUNTS FOR CRITERIA ###############
		Utils::logMessage($fq_name,"###########################################".PHP_EOL);
		Utils::logMessage($fq_name,"## Initiating Get ACCOUNTS FOR CRITERIA ## ".PHP_EOL.PHP_EOL);
		if(!Utils::confirmSelect()) {exit();}
		$account = new Account();
		Utils::logMessage($fq_name,"Please provide following details: " .PHP_EOL.PHP_EOL);
		Utils::logMessage($fq_name,"container: ");
		$container = Utils::read_stdin();
		Utils::logMessage($fq_name,"accountId: ");
		$accountId = Utils::read_stdin();
		$responseObj = $account -> getAccounts($accountsurl,$cobSessionToken,$userSessionToken,$accountId,$container);
		$errorDetails = Utils::checkForError($responseObj);
		if(!empty($errorDetails)) {
			Utils::printErrorDetails($errorDetails);
			throw new Exception($responseObj['body']);
		} else {
			$accountArr = $account -> parseAccounts($responseObj);
			Utils::logMessage($fq_name,">> Number of Accounts ".count($accountArr).PHP_EOL.PHP_EOL.PHP_EOL);
			// sample on how to iterate over accountsArr
			Utils::printDetailsFromArray($accountArr,'Accounts');
			return $accountArr;
		}
}

function getTransactionCount($fq_name,$transactionCountUrl,$cobSessionToken,$userSessionToken) {
	############### GET TRANSACTION COUNT ################
	Utils::logMessage($fq_name,"###################################### ".PHP_EOL);
	Utils::logMessage($fq_name,"## Initiating Get TRANSACTION COUNT ## ".PHP_EOL.PHP_EOL);
	if(!Utils::confirmSelect()) {exit();}
	$transaction = new Transaction();
	$responseObj = $transaction -> retrieveTransactionCount($transactionCountUrl,$cobSessionToken,$userSessionToken);
	$errorDetails = Utils::checkForError($responseObj);
	if(!empty($errorDetails)) {
		Utils::printErrorDetails($errorDetails);
		throw new Exception($responseObj['body']);
	} else {
		$count = $transaction -> parseTransactionCount($responseObj);
		Utils::logMessage($fq_name,">> Number of Transactions ".$count.PHP_EOL.PHP_EOL.PHP_EOL);
		// sample on how to iterate over accountsArr
		return $count;
	}
}

function getTransactionCategories($fq_name,$transactionCategoriesUrl,$cobSessionToken,$userSessionToken) {
		############### GET TRANSACTION CATEGORIES ###########
		Utils::logMessage($fq_name,"###########################################".PHP_EOL);
		Utils::logMessage($fq_name,"## Initiating GET TRANSACTION CATEGORIES ## ".PHP_EOL.PHP_EOL);
		if(!Utils::confirmSelect()) {exit();}
		$transaction = new Transaction();
		$responseObj = 
			$transaction -> retrieveAllTransaction($transactionCategoriesUrl,$cobSessionToken,$userSessionToken);
		
		$errorDetails = Utils::checkForError($responseObj);
		if(!empty($errorDetails)) {
			Utils::printErrorDetails($errorDetails);
			throw new Exception($responseObj['body']);
		} else {
			$transactionCatArr = $transaction -> parseTransactionCategories($responseObj);
			// sample on how to iterate over transactionsArr
			Utils::printDetailsFromArray($transactionCatArr,'Transaction Categories');
			Utils::logMessage($fq_name,">> Number of Transaction Categories ".count($transactionCatArr).PHP_EOL.PHP_EOL.PHP_EOL);
			return $transactionCatArr;
		}
}

function getAllTransactions($fq_name,$transactionsUrl,$cobSessionToken,$userSessionToken) {
		############### GET All Transactions #################
		Utils::logMessage($fq_name,"#####################################".PHP_EOL);
		Utils::logMessage($fq_name,"## Initiating GET All Transactions ## ".PHP_EOL.PHP_EOL);
		if(!Utils::confirmSelect()) {exit();}
		$transaction = new Transaction();
		$responseObj = 
			$transaction -> retrieveAllTransaction($transactionsUrl,$cobSessionToken,$userSessionToken);
		//Utils::logMessage($fq_name,">> allTransactions ::".$allTransactions.PHP_EOL.PHP_EOL);
		$errorDetails = Utils::checkForError($responseObj);
		if(!empty($errorDetails)) {
			Utils::printErrorDetails($errorDetails);
			throw new Exception($responseObj['body']);
		} else {
			$transactionsArr = $transaction -> parseTransactions($responseObj);
			// sample on how to iterate over transactionsArr
			Utils::printDetailsFromArray($transactionsArr,'Transactions');
			Utils::logMessage($fq_name,">> Number of Transaction ".count($transactionsArr).PHP_EOL.PHP_EOL.PHP_EOL);
			return $transactionsArr;
		}
		
		//$headers = $responseObj["headers"];
		
		// this is required to get headers info for pagination..
		//$links = $headers["Link"];
		
		/*foreach($links as $key => $val) {
			Utils::logMessage($fq_name,$key . ': ' . $val.PHP_EOL);
		}*/

		/*if(count($links) > 0) {
			echo "inside if".PHP_EOL;
			$nextUrl = $links['rel=next'];
			if(!empty($nextUrl)) {
				echo "inside if 2".PHP_EOL;
				Utils::logMessage($fq_name,"## Next Page is available @ ".$nextUrl.PHP_EOL.PHP_EOL);
				if(!Utils::confirmSelect()) {return;}
				getAllTransactions($GLOBALS['BASE_URL'].$nextUrl,$cobSessionToken,$userSessionToken);
			}
		}*/
				
		//echo PHP_EOL.PHP_EOL.PHP_EOL;
		
	}

function getTransactionsForCriteria($fq_name,$transactionsUrl,$cobSessionToken,$userSessionToken) {
		Utils::logMessage($fq_name,"##############################################".PHP_EOL);
		Utils::logMessage($fq_name,"## Initiating GET Transactions For Criteria ## ".PHP_EOL.PHP_EOL);
		if(!Utils::confirmSelect()) {exit();}
		$transaction = new Transaction();

		Utils::logMessage($fq_name,"Please provide following details: " . PHP_EOL);
		$queryArgs = array();

		Utils::logMessage($fq_name,"container: ");
		$container = Utils::read_stdin();
		if (!empty($container)) {$queryArgs['container'] = $container;}
		
		Utils::logMessage($fq_name,"baseType: ");
		$baseType = Utils::read_stdin();
		if (!empty($baseType)) {$queryArgs['baseType'] = $baseType;}
		
		Utils::logMessage($fq_name,"merchant: ");
		$merchant = Utils::read_stdin();
		if (!empty($merchant)) {$queryArgs['merchant'] = $merchant;}

		Utils::logMessage($fq_name,"accountId: ");
		$accountId = Utils::read_stdin();
		if (!empty($accountId)) {$queryArgs['accountId'] = $accountId;}

		Utils::logMessage($fq_name,"fromDate: ");
		$fromDate = Utils::read_stdin();
		if (!empty($fromDate)) {$queryArgs['fromDate'] = $fromDate;}

		Utils::logMessage($fq_name,"toDate: ");
		$toDate = Utils::read_stdin();
		if (!empty($toDate)) {$queryArgs['toDate'] = $toDate;}

		Utils::logMessage($fq_name,"category: ");
		$category = Utils::read_stdin();
		if (!empty($category)) {$queryArgs['category'] = $category;}

		Utils::logMessage($fq_name,"skip: ");
		$skip = Utils::read_stdin();
		if (!empty($skip)) {$queryArgs['skip'] = $skip;}

		Utils::logMessage($fq_name,"top: ");
		$top = Utils::read_stdin();
		if (!empty($top)) {$queryArgs['top'] = $top;}


		$responseObj = 
			$transaction ->retrieveTransactionForCriteria($transactionsUrl,$cobSessionToken,$userSessionToken,$queryArgs);
		
		
		$errorDetails = Utils::checkForError($responseObj);
		if(!empty($errorDetails)) {
			Utils::printErrorDetails($errorDetails);
			throw new Exception($responseObj['body']);
		} else {
			$transactionsArr = $transaction -> parseTransactions($responseObj);
			// sample on how to iterate over transactionsArr
			Utils::printDetailsFromArray($transactionsArr,'Transactions');
			Utils::logMessage($fq_name,">> Number of Transaction ".count($transactionsArr).PHP_EOL.PHP_EOL.PHP_EOL);
			return $transactionsArr;
		}
	}

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
	$providerId = 16441;
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

function addAccount($fq_name,$url,$cobSession,$userSession,$mod_provider_obj) {
	$providerId = $mod_provider_obj['provider'][0]['id'];
	$providerParam = json_encode($mod_provider_obj,JSON_UNESCAPED_UNICODE);
	Utils::logMessage($fq_name,"providerParam:::>>::".$providerParam);
	$provd = new Provider();
	$response = $provd -> addAccountForProvider($url,$cobSession,$userSession,$providerId,$providerParam);
	echo "before ::::22:";
	$errorDetails = Utils::checkForError($response);
		if(!empty($errorDetails)) {
			Utils::printErrorDetails($errorDetails);
			throw new Exception($response['body']);
		} else {
			$addAccountResponse = $response['body'];
			$obj = Utils::parseJson($addAccountResponse);
			Utils::printKeyValue($obj);
			return $obj['siteAccountId'];
		}
}

function getRefreshStatus($fq_name,$url,$cobSession,$userSession,$accountId) {
	$provd = new Provider();
	$response = $provd->getRefreshStatus($url,$cobSession,$userSession,$accountId);
	$obj = Utils::parseJson($response['body']);
	Utils::printKeyValue($obj);
}


function parseAndPopulateProviderDetails($provider) {
	$resObj = Utils::parseJson($provider);
	$providerObj = $resObj['provider'];
	for ($k = 0; $k < count($providerObj); ++$k) {
		$loginFormObj = $providerObj[$k]['loginForm'];
		$rows = $loginFormObj['row'];
		for ($j = 0; $j < count($rows); ++$j) {
			$fields = $rows[$j]['field'];
			for ($i = 0; $i < count($fields); ++$i) {
				echo PHP_EOL."Please enter value for :: ".$fields[$i] ['name']." : ";
				$value = Utils::read_stdin();
				$fields[$i]['value'] = $value;
			}
			$rows[$j]['field'] = $fields;
		}
		$loginFormObj['row'] = $rows;
		$providerObj[$k]['loginForm'] = $loginFormObj;
	}
	
	$mod_provider_obj = array('provider'=>$providerObj);
	return $mod_provider_obj;
}

?>