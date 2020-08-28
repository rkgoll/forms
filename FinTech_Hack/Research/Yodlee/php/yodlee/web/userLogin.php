<?PHP

require_once("../include/include.php");
session_start();
$cobSession = $_SESSION["cobSessionToken"];
if(empty($cobSession)) {
	
	header("Location: cobrandLogin.php");
}

try {
if(isset($_POST['submitted']))
{
   $login = new Login();
   $userLogin=$_REQUEST['userLogin']; 
   $userPassword=$_REQUEST['userPassword']; 
   $response = $login->userLogin($userLoginUrl,$cobSession,$userLogin,$userPassword);
   $errorDetails = Utils::checkForError($response);
   echo "errorDetails[errorCode]::".$errorDetails['errorCode'];
   if(!empty($errorDetails['errorCode'])) {
			$_SESSION["errorCode"] = $errorDetails['errorCode'];
			$_SESSION["errorMessage"] = $errorDetails['errorMessage'];
			$_SESSION["referenceCode"] = $errorDetails['referenceCode'];
			//$_SESSION["cobSessionToken"] = null;
			header("Location: errorDetails.php");
			exit;
	} else {
			$userSessionToken = $login->parseUserLogin($response );
			echo ("userSessionToken :: ".$userSessionToken);
			$_SESSION["userSessionToken"] = $userSessionToken;
			header("Location: home.php");
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
      <title>User Login</title>
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
     
</head>
<body>

<div id='fg_membersite'>
<form id='userlogin' action='userlogin.php' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>User Login</legend>

<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='userLoginSubmitted' id='userLoginSubmitted' value='1'/>
<div class='short_explanation'>* required fields</div>
<div class='container'>
    <label for='userLogin' >User Login*:</label><br/>
    <input type='text' name='userLogin' id='userLogin' value='' maxlength="50" /><br/>
</div>
<div class='container'>
    <label for='userPassword' >User Password*:</label><br/>
    <input type='text' name='userPassword' id='userPassword' maxlength="50" /><br/>
</div>
<div class='container'>
    <input type='submit' name='Submit' value='Submit' />
</div>
</fieldset>
</form>
</div>
</body>
</html>