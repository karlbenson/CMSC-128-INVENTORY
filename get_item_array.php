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

	$ID = $_POST['ID'];
	$TYPE = $_POST['TYPE'];

	if ($TYPE == "CHEMICAL")
	{
		$QUERY = "SELECT * FROM CHEMICALS WHERE Chemical_Id = $ID";
		$ARRAY = mysqli_fetch_row(mysqli_query($MyConnection, $QUERY));
	}

	else
	{
		$QUERY = "SELECT * FROM GLASSWARES WHERE Glassware_Id = $ID";
		$ARRAY = mysqli_fetch_row(mysqli_query($MyConnection, $QUERY));
	}

	echo json_encode($ARRAY);
?>