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

	$item = $_POST['GLASS_ID'];
	$null = null;
	$MySearchQuery = "SELECT * FROM transaction WHERE (Glassware_Id = $item and Date_Returned = NULL);";
	$MyValues = mysqli_query($MyConnection, $MySearchQuery);

	if (mysqli_num_rows($MyValues) > 0)
	{
		echo json_encode(array(
    		'status' => 'error'
		));
	}

	else
	{
		mysqli_query($MyConnection, "SET FOREIGN_KEY_CHECKS=0");
		mysqli_query($MyConnection, "DELETE FROM glasswares WHERE (glasswares.Glassware_Id = $item)");
		mysqli_query($MyConnection, "SET FOREIGN_KEY_CHECKS=1");
		echo json_encode(array(
    		'status' => 'success'
		));
	}

	exit();
	
?>