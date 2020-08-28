<?php 

/*
*	App/Test Script to Try transactions APIs.
*	As any Yodlee API needs valid cobSessionToken and userSessionToken, first the login API will be called followed by respective holdings APIs
*   
*	a) transactions for a specific user 
*	b) transactions count for specific user
*   c) transaction categories
*	d) transactions for a specific user for criteria like : 
*						container
*						baseType
*						merchant
*						accountId
*						fromDate
*						toDate
*						category
*						skip
*						top
*	
*	Internally uses Login class available under <YODLEE_APPS_DIR>/yodlee/api/authentication/login 
				and Transaction class available under <YODLEE_APPS_DIR>/yodlee/api/pfm/transaction to perform the same.
*
*	common.php  : provides functions for cobrand login and user login and internally calls Login API libraries.
*   include.php : prvides mechanism to import configurations from <YODLEE_APPS_DIR>/yodlee/conf/myapp.ini 
*/

include (__DIR__.'/../../common/common.php');
include (__DIR__.'/../../../include/include.php');

$fq_name = "TransactionApp";

Utils::logMessage($fq_name,"========================================================================".PHP_EOL);
Utils::logMessage($fq_name,"=========Sample Library For Accounts APIs=================".PHP_EOL);
Utils::logMessage($fq_name,"========================================================================".PHP_EOL.PHP_EOL);

try {
	$cobSessionToken = cobrandLogin($fq_name,$cobLoginUrl,$cobrandLogin,$cobrandPassword);
	$userSessionToken = userLogin($fq_name,$userLoginUrl,$cobSessionToken,$userLogin,$userPassword);
	$transactionCount = getTransactionCount($fq_name,$transactionsCountUrl,$cobSessionToken,$userSessionToken);
	$transactionCategories = getTransactionCategories($fq_name,$transactionCategoriesUrl,$cobSessionToken,$userSessionToken);
	$allTransactions = getAllTransactions($fq_name,$transactionsUrl,$cobSessionToken,$userSessionToken);
	$transactionsForCriteria = getTransactionsForCriteria($fq_name,$transactionsUrl,$cobSessionToken,$userSessionToken);
} catch(Exception $e) {
	Utils::logMessage($fq_name,">> Exception >> ".PHP_EOL);
	Utils::logMessage($fq_name,$e -> getMessage());	
}

###################### Utility Functions #########################

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
		echo PHP_EOL.PHP_EOL.PHP_EOL;
}


?>