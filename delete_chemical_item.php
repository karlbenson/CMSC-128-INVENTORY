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

	$MySearchQuery = "SELECT * FROM transaction WHERE (Chemical_Id = $item);";
	$MyValues = mysqli_query($MyConnection, $MySearchQuery);

	if (mysqli_num_rows($MyValues) > 0)
	{
		echo json_encode(array(
    		'status' => 'error'
		));
	}

	else
	{
		mysqli_query($MyConnection, "DELETE FROM chemicals WHERE (chemicals.Chemical_Id = $item)");
		echo json_encode(array(
    		'status' => 'success'
		));
	}
	
?>