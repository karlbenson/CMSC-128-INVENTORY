<?php
	session_start();
	error_reporting(0);
	
	//Server Credentials
	$MyServerName = "localhost";
	$MyUserName = "root";
	$MyPassword = "";

	//Database
	$MyDBName = 'chem_glasswares';

	//Start Connection
	$MyConnection = mysqli_connect($MyServer, $MyUserName, $MyPassword, $MyDBName);

	$item = $_POST['Glassware_Id'];


	mysqli_query($MyConnection, "DELETE FROM glasswares WHERE (glasswares.Glassware_Id = $item)");
	
	
	
	header("Location: master.php");
?>