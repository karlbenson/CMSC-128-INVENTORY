<?php
	session_start();
	$username = $_SESSION['username'];
	

	setcookie(session_name(),'',0,'/');
	session_unset();
	session_destroy();
	session_write_close();
	
	$con = mysqli_connect('127.0.0.1','root','');
	
	if (!$con){
		echo 'Not connected to server';
	}
	
	if (!mysqli_select_db($con,'chem_glasswares')){
		echo 'Database not selected';
	}
	
	$query = "UPDATE user_accounts SET status = 0 WHERE Username = '$username'";
	mysqli_query($con,$query);
	mysqli_close($con);
	
	
	header("Location: login.php");
?>