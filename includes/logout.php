<?php  session_start(); ?>
<?php include "functions.php" ?>
<?php include "dbconfig.php"; ?>

<?php
$log_action="Loggedout";
create_log($_SERVER['REMOTE_ADDR'], $_SESSION['staff_username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 

$_SESSION['staff_id'] = null;
$_SESSION['staff_username'] = null;
$_SESSION['email'] = null;

header("location: ../login.php");