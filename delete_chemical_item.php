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

	$item = $_POST['CHEM_ID'];
	

	mysqli_query($MyConnection, "DELETE FROM chemicals WHERE (chemicals.Chemical_Id = $item)");
?>