<?PHP

require_once("../include/include.php");
session_start();
$cobSession = $_SESSION["cobSessionToken"];
if(empty($cobSession)) {
	header("Location: cobrandLogin.php");
}

$userSession = $_SESSION["userSessionToken"];
if(empty($userSession)) {
	header("Location: userLogin.php");
}
try {
if(isset($_POST['submitted']))
{
   $account = new Account();
   $accountId=$_REQUEST['accountId']; 
   $container=$_REQUEST['container'];
   $response = $account->getAccounts($accountsUrl,$cobSession,$userSession,$accountId,$container);
   $errorDetails = Utils::checkForError($response);
   
   if(!empty($errorDetails['errorCode'])) {
			$_SESSION["errorCode"] = $errorDetails['errorCode'];
			$_SESSION["errorMessage"] = $errorDetails['errorMessage'];
			$_SESSION["referenceCode"] = $errorDetails['referenceCode'];
			//$_SESSION["cobSessionToken"] = null;
			header("Location: errorDetails.php");
			exit;
			
	} else {
			$accountArr = $account->parseAccounts($response);
			//echo "accounts::".$response['body'];
			/*$userSessionToken = $login->parseuserLogin($response );
			echo ("userSessionToken :: ".$userSessionToken);
			$_SESSION["userSessionToken"] = $userSessionToken;
			header("Location: home.php");*/
	}
}
} catch(Exception $ex) {
	echo "Exception Occured :: ".$ex->getMessage();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>User Login</title>
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
</head>
<body>
<div>
	<a href="home.php">Home</a>
</div>
<br/><br/>
<?php if(!isset($_POST['submitted'])){ ?>
<div id='fg_membersite'>
<form id='userlogin' action='accountsApp.php' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>Account Details</legend>

<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='userLoginSubmitted' id='userLoginSubmitted' value='1'/>
<div class='container'>
    <label for='container' >Container:</label><br/>
    <input type='text' name='container' id='container' value='' maxlength="50" /><br/>
</div>
<div class='container'>
    <label for='accountId' >AccountID:</label><br/>
    <input type='text' name='accountId' id='accountId' maxlength="50" /><br/>
</div>
<div class='container'>
    <input type='submit' name='Submit' value='Submit' />
</div>
</fieldset>
</form>
</div>
<?php } else { ?>

<div id='fg_membersite'>
<fieldset >
<legend>Account Details</legend>
<table border=1>

<tr>
	<td><b>CONTAINER</b></td>
	<td><b>AccountName</b></td>
	<td><b>AccountNumber</b></td>
	<td><b>isAsset</b></td>
	<td><b>Balance</b></td>
	<td><b>Currency</b></td>
	<td><b>Id</b></td>
</tr>
<?php foreach($accountArr as $accountObj){ ?>
		<tr>
			<td><?php if(!empty($accountObj['CONTAINER'])) echo $accountObj['CONTAINER'] ?></td>
			<td><?php if(!empty($accountObj['accountName'])) echo $accountObj['accountName'] ?></td>
			<td><?php if(!empty($accountObj['accountNumber'])) echo $accountObj['accountNumber'] ?></td>
			<td><?php if(!empty($accountObj['isAsset'])) echo $accountObj['isAsset'] ?></td>			
			<td><?php if(!empty($accountObj['balance'])) echo $accountObj['balance'] ?></td>			
			<td><?php if(!empty($accountObj['currency'])) echo $accountObj['currency'] ?></td>			
			<td><?php if(!empty($accountObj['id'])) echo $accountObj['id'] ?></td>			
		</tr>
</fieldset>

<?php }} ?>
</table>
</div>
</body>
</html>