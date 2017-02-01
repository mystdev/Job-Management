<?php
include_once('../lib/class_lib.php');
session_start();
$id = $_POST['id'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$contact = $_POST['con_number'];
$company = $_POST['company'];
$username = $_POST['username'];

$_SESSION['clientid'] = $_POST['id'];
$_SESSION['fname'] = $_POST['fname'];
$_SESSION['lname'] = $_POST['lname'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['con_number'] = $_POST['con_number'];
$_SESSION['company'] = $_POST['company'];
$_SESSION['username'] = $_POST['username'];


if ($fname == '' || $lname == '' || $email == '' || $contact == '' || $company == '' || $username == '')
{
  $_SESSION['err'] = 'Please fill out all fields';
  header('Location:../adminpage.php?id=editerr');
}else{
      $updateclient = new dbQuery("UPDATE mdclientauth SET fname = '$fname', lname = '$lname', contact_num = '$contact', email = '$email', company_name = '$company' WHERE clientauthid = '$id'");
      if(!$updateclient->returnQuery())
      {

        echo 'Error Bing Bing Bong Bong WRONNNNNNG';
      }
     
      header('Location:../../adminpage.php?id=edit_cust');
     
      $_SESSION['success'] = 'Client successfully updated';
}


?>