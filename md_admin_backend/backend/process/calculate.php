<?php

$des_package = $_POST['design_type'];
$des_hours = $_POST['des_hours'] * 27.00;
$pagecount = $_POST['nav_page_count'] * 20.00;
$contactform = $_POST['contact_form'];
$cms = $_POST['cms'];
$commerce = $_POST['ecommerce'];

session_start();
$_SESSION['cost'] = $des_package + $des_hours + $pagecount + $contactform + $cms + $commerce;
header('Location: ../../adminpage.php?id=new_job_selected');








?>