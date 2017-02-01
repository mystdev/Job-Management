<?php
include_once('../lib/class_lib.php');
session_start();
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$contact = $_POST['con_number'];
$company = $_POST['company'];
$username = $_POST['username'];
$pw = $_POST['password'];

$_SESSION['fname'] = $_POST['fname'];
$_SESSION['lname'] = $_POST['lname'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['con_number'] = $_POST['con_number'];
$_SESSION['company'] = $_POST['company'];
$_SESSION['username'] = $_POST['username'];


if ($fname == '' || $lname == '' || $email == '' || $contact == '' || $company == '' || $username == '' || $pw == '')
{
	$_SESSION['err'] = 'Please fill out all fields';
	header('Location:../adminpage.php?id=add_cust');
}else{
	$addcust = new dbQuery("INSERT INTO mdclientauth (clientauthid, clientauthuser, last_login_ip, last_login_date, fname, lname, contact_num, email, company_name, user_appended) 
							VALUES (NULL,'$username', 'NA', '', '$fname', '$lname', '$contact', '$email', '$company', NOW())");
	if($addcust->returnQuery())
	{
	$pw = sha1($pw);
	$addshadow = new dbQuery("INSERT INTO mdclientshadow (clientauthid, clientauthcode) VALUES (NULL, '$pw')");
	$addshadow->returnQuery();
	$newdir = new createDir('../../clients/'.$username.'', 0777);
	$newdir->confirmDir();
		header('Location: ../../adminpage.php');
		$_SESSION['success'] = 'Client successfully added to client';
	}else{

		echo '<b>Username already exists!</b> Returning to Add Customer Form in <i>5 seconds...</i> <a href="../../adminpage.php?id=addcust">[Go Back Now]</a>';
		echo '<meta http-equiv="refresh" content="5;url=../../adminpage.php?id=addcust"/>';
	}

}












?>