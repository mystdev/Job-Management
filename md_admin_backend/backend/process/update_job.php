<?php
include_once('../lib/class_lib.php');
session_start();
$status = $_POST['status'];
$jobid = $_POST['jobid'];

$updatejob = new dbQuery("UPDATE mdjobs SET status = '$status' WHERE jobid = '$jobid'");
      if(!$updatejob->returnQuery())
      {

        echo 'Error Bing Bing Bong Bong WRONNNNNNG';
      }
     
      header('Location:../../adminpage.php?id=edit_job');

      $_SESSION['success'] = 'Job status successfully updated to <b>'.$status.'</b>';


?>