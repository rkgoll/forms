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
   $transaction = new Transaction();
   $accountId=$_REQUEST['accountId']; 
   $container=$_REQUEST['container'];
   $baseType=$_REQUEST['baseType']; 
   $merchant=$_REQUEST['merchant'];
   $fromDate=$_REQUEST['fromDate']; 
   $toDate=$_REQUEST['toDate'];
   $category=$_REQUEST['category']; 
   $skip=$_REQUEST['skip'];
   $top=$_REQUEST['top'];

   $queryArgs = array();
   if (!empty($container)) {$queryArgs['container'] = $container;}
   if (!empty($baseType)) {$queryArgs['baseType'] = $baseType;}
   if (!empty($merchant)) {$queryArgs['merchant'] = $merchant;}
   if (!empty($accountId)) {$queryArgs['accountId'] = $accountId;}
   if (!empty($fromDate)) {$queryArgs['fromDate'] = $fromDate;}
   if (!empty($toDate)) {$queryArgs['toDate'] = $toDate;}
   if (!empty($category)) {$queryArgs['category'] = $category;}
   if (!empty($skip)) {$queryArgs['skip'] = $skip;}
   if (!empty($top)) {$queryArgs['top'] = $top;}

   $response = $transaction->retrieveTransactionForCriteria($transactionsUrl,$cobSession,$userSession,$queryArgs);
   $errorDetails = Utils::checkForError($response);
   if(!empty($errorDetails['errorCode'])) {
			$_SESSION["errorCode"] = $errorDetails['errorCode'];
			$_SESSION["errorMessage"] = $errorDetails['errorMessage'];
			$_SESSION["referenceCode"] = $errorDetails['referenceCode'];
			//$_SESSION["cobSessionToken"] = null;
			header("Location: errorDetails.php");
			exit;
			
	} else {
			$transactionArr = $transaction->parseTransactions($response);
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
	  <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
     
</head>
<body>
<div>
	<a href="home.php">Home</a>
</div>
<br/><br/>
<?php if(!isset($_POST['submitted'])){ ?>

<div id='fg_membersite'>
<form id='userlogin' action='transactionsApp.php' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>Transactions Details</legend>

<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='userLoginSubmitted' id='userLoginSubmitted' value='1'/>
<div class='container'>
    <label for='container' >Container:</label><br/>
    <input type='text' name='container' id='container' value='' maxlength="50" /><br/>
</div>
<div class='container'>
    <label for='baseType' >BaseType</label><br/>
    <input type='text' name='baseType' id='baseType' maxlength="50" /><br/>
</div>
<div class='container'>
    <label for='merchant' >Merchant</label><br/>
    <input type='text' name='merchant' id='merchant' maxlength="50" /><br/>
</div>
<div class='container'>
    <label for='accountId' >AccountId</label><br/>
    <input type='text' name='accountId' id='accountId' maxlength="50" /><br/>
</div>
<div class='container'>
    <label for='fromDate' >FromDate</label><br/>
    <input type='text' name='fromDate' id='fromDate' maxlength="50" /><br/>
</div>
<div class='container'>
    <label for='toDate' >ToDate</label><br/>
    <input type='text' name='toDate' id='toDate' maxlength="50" /><br/>
</div>
<div class='container'>
    <label for='category' >Category</label><br/>
    <input type='text' name='category' id='category' maxlength="50" /><br/>
</div>
<div class='container'>
    <label for='skip' >Skip</label><br/>
    <input type='text' name='skip' id='skip' maxlength="50" /><br/>
</div>
<div class='container'>
    <label for='top' >Top</label><br/>
    <input type='text' name='top' id='top' maxlength="50" /><br/>
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
<legend>Transaction Details</legend>
<table border=1>

<tr>
	<td><b>CONTAINER</b></td>
	<td><b>id</b></td>
	<td><b>Amount</b></td>
	<td><b>Currency</b></td>
	<td><b>baseType</b></td>
	<td><b>Category</b></td>
	<td><b>Description</b></td>
	<td><b>isManual</b></td>
	<td><b>date</b></td>
	<td><b>format</b></td>
	<td><b>transactionDate</b></td>
	<td><b>format</b></td>

</tr>
<?php foreach($transactionArr as $transactionObj){ ?>
		<tr>
			<td><?php if(!empty($transactionObj['CONTAINER'])) echo $transactionObj['CONTAINER'] ?></td>
			<td><?php if(!empty($transactionObj['id'])) echo $transactionObj['id'] ?></td>
			<td><?php if(!empty($transactionObj['amount']['amount'])) echo $transactionObj['amount']['amount'] ?></td>
			<td><?php if(!empty($transactionObj['amount']['currency'])) echo $transactionObj['amount']['currency'] ?></td>
			<td><?php if(!empty($transactionObj['baseType'])) echo $transactionObj['baseType'] ?></td>			
			<td><?php if(!empty($transactionObj['category'])) echo $transactionObj['category'] ?></td>			
			<td><?php if(!empty($transactionObj['description'])) echo $transactionObj['description'] ?></td>			
			<td><?php if(!empty($transactionObj['isManual'])) echo $transactionObj['isManual'] ?></td>	
			<td><?php if(!empty($transactionObj['date']['date'])) echo $transactionObj['date']['date'] ?></td>	
			<td><?php if(!empty($transactionObj['date']['format'])) echo $transactionObj['date']['format'] ?></td>	
			<td><?php if(!empty($transactionObj['transactionDate']['date'])) echo $transactionObj['transactionDate']['date'] ?></td>	
			<td><?php if(!empty($transactionObj['transactionDate']['format'])) echo $transactionObj['transactionDate']['format'] ?></td>	
		</tr>
</fieldset>

<?php }} ?>
</table>
</div>

</body>
</html>