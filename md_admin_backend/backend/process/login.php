<?php
include_once('../lib/class_lib.php');
$user = $_POST['user'];
$pw = sha1($_POST['pw']);
$ip = $_SERVER['REMOTE_ADDR'];

// Query to login
$login = new dbQuery("SELECT * FROM mdadminauth,mdadminshadow WHERE mdadminauth.adminauthuser = '$user' AND mdadminauth.adminauthid = mdadminshadow.adminauthid AND mdadminshadow.adminauthcode = '$pw'");
// Login succes if returns true, else return error.
if ($login->rowCount()) {
	session_start();
	$_SESSION['authcomplete'] = $user;
	$updatelogin = new dbQuery("UPDATE mdadminauth SET last_login_ip = '$ip', last_login_date = NULL WHERE adminauthuser = '$user'");
	$updatelogin->returnQuery();
	header('Location:../../adminpage.php');
}else{
	header('Location:../../index.php?err=1');
}






	








?>