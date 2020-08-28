<?PHP

require_once("../include/include.php");
session_start();

try{

if(isset($_POST['submitted']))
{
   $login = new Login();
   $cobLogin=$_REQUEST['cobLogin']; 
   $cobPassword=$_REQUEST['cobPassword']; 
   $response = $login->cobLogin($cobLoginUrl,$cobLogin,$cobPassword);
   $errorDetails = Utils::checkForError($response);
   echo "errorDetails[errorCode]::".$errorDetails['errorCode'];
   if(!empty($errorDetails['errorCode'])) {
			echo "errorDetails[errorCode]::".$errorDetails['errorCode'].'<br/>';
			echo "errorDetails[errorMessage]::".$errorDetails['errorMessage'].'<br/>';
			echo "errorDetails[referenceCode]::".$errorDetails['referenceCode'].'<br/>';
			$_SESSION["errorCode"] = $errorDetails['errorCode'];
			$_SESSION["errorMessage"] = $errorDetails['errorMessage'];
			$_SESSION["referenceCode"] = $errorDetails['referenceCode'];
			$_SESSION["cobSessionToken"] = null;
			header("Location: errorDetails.php");
			exit;
	} else {
			$cobSessionToken = $login->parseCobLogin($response );
			echo ("cobSessionToken2 :: ".$cobSessionToken);
			$_SESSION["cobSessionToken"] = $cobSessionToken;
			header("Location: userLogin.php");
			exit;
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
      <title>Cobrand Login</title>
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
     
</head>
<body>

<!-- Form Code Start -->
<div id='fg_membersite'>
<form id='coblogin' action='cobrandLogin.php' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>Cobrand Login</legend>

<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='cobLoginSubmitted' id='cobLoginSubmitted' value='1'/>
<div class='short_explanation'>* required fields</div>
<div class='container'>
    <label for='cobLogin' >Cobrand Login*:</label><br/>
    <input type='text' name='cobLogin' id='cobLogin' value='' maxlength="50" /><br/>
</div>
<div class='container'>
    <label for='cobPassword' >Cobrand Password*:</label><br/>
    <input type='text' name='cobPassword' id='cobPassword' maxlength="50" /><br/>
</div>
<div class='container'>
    <input type='submit' name='Submit' value='Submit' />
</div>
</fieldset>
</form>
</div>
</body>
</html>