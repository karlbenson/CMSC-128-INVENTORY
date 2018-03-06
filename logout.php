<?php
	session_start();
	$username = $_SESSION['username'];
	
	session_unset();
	session_destroy();
	session_write_close();
	setcookie(session_name(),'',0,'/');
	session_regenerate_id(true);
	
	$con = mysqli_connect('127.0.0.1','root','');
	$query = "UPDATE user_accounts SET status = 0 WHERE Username = '$username'";
	mysqli_query($con,$query);
	mysqli_close($con);
	
	header("refresh:2;url=login.php");
?>