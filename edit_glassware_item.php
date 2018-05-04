<?php
	session_start();
	error_reporting(0);
	
	//include("verify.php");

	//Server Credentials
	$MyServerName = "localhost";
	$MyUserName = "root";
	$MyPassword = "";

	//Database
	$MyDBName = 'chem_glasswares';

	$MyConnection = mysqli_connect($MyServer, $MyUserName, $MyPassword, $MyDBName);

	$E_ID = $_POST['GLASS_ID_VALUE'];
	$E_NAME = $_POST['name'];
	$E_AMOUNT = $_POST['amount'];

	$E_FixedName = mysqli_real_escape_string($MyConnection, $E_NAME);

	$MyQuery = "UPDATE GLASSWARES SET Name = '$E_FixedName', Quantity_Available = $E_AMOUNT WHERE (GLASSWARES.Glassware_Id = $E_ID);";
	mysqli_query($MyConnection, $MyQuery);
?>