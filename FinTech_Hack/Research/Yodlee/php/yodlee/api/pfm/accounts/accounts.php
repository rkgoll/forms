<?php

/*
This class provides client library to invoke Yodlee's Account APIs and perform utility operations like parsing 
JSON response from Yodlee API.
Various operations are 

*   getAccounts
*   parseAccounts

*/

class Account {

	const fq_name = "yodlee.api.accounts.Account";

	/*
	This operation internally invokes CURL utility to call getAccounts API.
		Params expected in input : 
			apiUrl, cobrandSessionToken, userSessionToken, query details like $id,$container
	*/
	function getAccounts($url,$cobSession,$userSession,$id,$container) {
		$request =  $url;
		$queryArgs = array();
		if (!empty($id)) {$queryArgs['id'] = $id;}
		if (!empty($container)) {$queryArgs['container'] = $container;}
		if(count($queryArgs) > 0)
			$request = $request.'?'.http_build_query($queryArgs, '', '&'); 
		
		$responseObj= CurlUtils::httpGet($request,$cobSession,$userSession);
		return $responseObj;
		//return $response["response"];
	}

	/*
	Utility Method to parse accountsAPI response JSON and return array of accounts with valid key(attributes)->value pairs.
	Expected Input is response object from accounts api.
	*/
	function parseAccounts($responseObj) {
		$allAccounts = $responseObj["body"];
		$allAccountsObj = Utils::parseJson($allAccounts);
		$accountArr = $allAccountsObj['account'];
		return $accountArr;
	}
}
?>