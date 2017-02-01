<?php
$pagetitle = 'MystDev Admin Area';
include_once('backend/includes/header.php');
?>
<!-- Login Form -->
<h1 class="login">MystDev Admin Area</h1>
	<div id="loginform">
        <form method="post" action="backend/process/login.php">
        <legend>Username:</legend>
        <input type="text" name="user" />
        <legend>Password:</legend>
        <input type="password" name="pw"  />
        <input type="submit" name="login" value="Login" />
        </form>
 <?php 
 // Error dispalyed on unsuccesful login.
 if (@$_GET['err'] == 1) {
	 	echo '<p class="err">Incorrect login details.</p>';
 }
 ?>
    </div>

<?php
include_once('backend/includes/footer.php');
?>
