<?PHP

require_once("../include/include.php");
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Error Details</title>
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
     
</head>
<body>

<div id='fg_membersite'>
<fieldset >
<legend>Error Details</legend>
<div class='container'>
    <label for='errorCode'>Error Code :  </label><br/>
	<input type='text' name='username' id='username' value='<?php echo $_SESSION['errorCode'] ?>' disabled/><br/>
	<label for='errorCode' >Error Message : </label><br/>
	<input type='text' name='username' id='username' value='<?php echo $_SESSION['errorMessage'] ?>' disabled/><br/>
	<label for='errorCode' >Reference Code : </label><br/>
	<input type='text' name='username' id='username' value='<?php echo $_SESSION['referenceCode'] ?>' disabled/><br/>
	<br/>
	<a href="javascript:history.back()">Go Back</a>
</div>
</fieldset>
</form>
</div>
</body>
</html>