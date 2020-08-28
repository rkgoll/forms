<?php

/*
This class provides client library to invoke Yodlee's Login APIs and perform utility operations like parsing 
JSON response from Yodlee API. Login Flow is comprised to two steps : cobrandLogin and userLogin
Various operations are 

*   cobLogin
*   userLogin
*   parseCobLogin
*   parseUserLogin
*/
class Login {

	const fq_name = "yodlee.api.login.Login";
	
	/*
	This operation internally invokes CURL utility to call cobrand login API.
		Params expected in input : 
			apiUrl, cobrandSessionToken, userSessionToken, query details like cobrandLogin,cobrandPassword
	*/
	function cobLogin($url,$cobrandLogin,$cobrandPassword) {
	   $request =  $url; 
	   $postargs = 'cobrandLogin='.$cobrandLogin.'&cobrandPassword='.$cobrandPassword;
	   $responseObj = CurlUtils::httpPost($request,$postargs,null,null);
	   return $responseObj;
	}

	/*
	This operation internally invokes CURL utility to call user login API.
		Params expected in input : 
			apiUrl, cobrandSessionToken, userSessionToken, query details like cobrandLogin,cobrandPassword
	*/
	function userLogin($url,$cobSession,$userLogin,$userPassword) {
	   $request =  $url; 
	   $postargs = 'userLogin='.$userLogin.'&userPassword='.$userPassword;
	   $responseObj= CurlUtils::httpPost($request,$postargs,$cobSession,null);
	   return $responseObj;
	}
	
	/*
	Utility Method to parse cobrandLogin response JSON and return cobSessionToken
	Expected Input is response object from cobrandLogin api.
	*/
	function parseCobLogin($response) {
		$responseObj = Utils::parseJson($response["body"]);
		$cobSessionToken = $responseObj['session']['cobSession'];
		return $cobSessionToken;
	}
	
	/*
	Utility Method to parse userLogin response JSON and return cobSessionToken
	Expected Input is response object from userLogin api.
	*/
	function parseUserLogin($response) {
		$responseObj = Utils::parseJson($response["body"]);
		$cobSessionToken = $responseObj['session']['userSession'];
		return $cobSessionToken;
	}
}

?>	