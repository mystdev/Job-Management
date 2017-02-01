<?php
include_once('../lib/class_lib.php');
$user = $_POST['user'];
$pw = sha1($_POST['pw']);
$ip = $_SERVER['REMOTE_ADDR'];

// Query to login
$login = new dbQuery("SELECT * FROM mdclientauth,mdclientshadow WHERE mdclientauth.clientauthuser = '$user' AND mdclientauth.clientauthid = mdclientshadow.clientauthid AND mdclientshadow.clientauthcode = '$pw'");
// Login succes if returns true, else return error.
if ($login->rowCount()) {
	session_start();
	$_SESSION['user'] = $user;
	$updatelogin = new dbQuery("UPDATE mdclientauth SET last_login_ip = '$ip', last_login_date = NULL WHERE clientauthuser = '$user'");
	$updatelogin->returnQuery();
	
	$retrieveid = new dbQuery("SELECT clientauthid, fname FROM mdclientauth WHERE clientauthuser = '$user'");
	$retrieve = $retrieveid->returnQuery();
    $cred = $retrieve->fetch_assoc();
    $_SESSION['id'] = $cred['clientauthid'];
    $_SESSION['fname'] = $cred['fname'];

	header('Location:../../clientpage.php');
}else{
	header('Location:../../index.php?err=1');
}






	








?>