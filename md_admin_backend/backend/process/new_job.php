<?php
include_once('../lib/class_lib.php');
session_start();
$clientdir = 'clients/';
$id = $_POST['clientid'];
$dir = $_POST['directory'];
$desc = $_POST['description'];
$estimated = $_POST['estimated_cost'];
$des_type = $_POST['des_type'];
$des_hours = $_POST['des_hours'];
$dev_pagecount = $_POST['dev_pagecount'];
@$dev_contact = $_POST['dev_contact'];
@$dev_cms = $_POST['dev_cms'];
@$dev_commerce = $_POST['dev_commerce'];
$dev_hours = $_POST['dev_hours'];
$status = $_POST['status'];

$_SESSION['dir'] = $_POST['directory'];
$_SESSION['desc'] = $_POST['description'];
$_SESSION['estimated'] = $_POST['estimated_cost'];
$_SESSION['des_hours'] = $_POST['des_hours'];
$_SESSION['dev_pagecount'] = $_POST['dev_pagecount'];
$_SESSION['dev_hours'] = $_POST['dev_hours'];
$_SESSION['status'] = $_POST['status'];



if ($id == '' || $dir == '' || $desc == '' || $estimated == '' || $des_type == '' || $des_hours == '' || $dev_pagecount == '' || $dev_hours == '' || $status == '')
{
	$_SESSION['err'] = 'Please fill out all fields';
	$_SESSION['options'] = 'Please reselect these options';
	header('Location:../../adminpage.php?id=new_job_selected');
}else{
	 $addjob = new dbQuery("INSERT INTO mdjobs (jobid, date_appended, clientauthid, estimated_cost, description, directory, des_type, des_hours, dev_pagecount, dev_contact,
												dev_cms, dev_commerce, dev_hours, status) 
							VALUES (NULL,NOW(), '$id', '$estimated', '$desc', '$dir', '$des_type', '$des_hours', '$dev_pagecount', '$dev_contact', '$dev_cms', '$dev_commerce',
									'$dev_hours','$status' )");

	

	if(!$addjob->returnQuery())
	{
			echo 'Database Error - Please contact your web administrator.';
	
	}else{
		$retrieveuser = new dbQuery("SELECT * FROM mdclientauth WHERE clientauthid = '$id'");
		$result = $retrieveuser->returnQuery();
		while ($row = mysqli_fetch_array($result))
		{
			$user = $row['clientauthuser'];
		}
			$newdir = new createDir(ROOT.$clientdir.$user.'/'.$dir.'', 0777);
			if(!$newdir->confirmDir())
			{
			
				echo 'Could not create Directory at '.ROOT.$clientdir.$user.'/'.$dir.' - Contact luke@mystdev.com';
				
			}else{
				$newcontractdir = new createDir(ROOT.$clientdir.$user.'/'.$dir.'/contract', 0777);
				$newlayoutdir = new createDir(ROOT.$clientdir.$user.'/'.$dir.'/layout', 0777);
				$newtempdir = new createDir(ROOT.$clientdir.$user.'/'.$dir.'/temp', 0777);
				$newcontractdir->confirmDir();
				$newlayoutdir->confirmDir();
				$newtempdir->confirmDir();
				unset($_SESSION['dir']);
				unset($_SESSION['desc']);
				unset($_SESSION['estimated']);
				unset($_SESSION['des_hours']);
				unset($_SESSION['dev_pagecount']);
				unset($_SESSION['dev_hours']);
				unset($_SESSION['status']);
				unset($_SESSION['clientid']);

				header('Location: ../../adminpage.php?id=new_job');
				$_SESSION['success'] = 'Job successfully started.';
				}
			}
		}

?>