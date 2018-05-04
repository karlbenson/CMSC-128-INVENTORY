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

	$C_ID = $_POST['CHEM_ID_VALUE'];
	$C_NAME = $_POST['name'];
	$C_AMOUNT = $_POST['amount'];
	$C_UNIT = $_POST['unit'];

	$C_FixedName = mysqli_real_escape_string($MyConnection, $C_NAME);

	$MyQuery = "SELECT * FROM CHEMICALS WHERE Chemical_Id = $C_ID;";
	$MyValues = $MyConnection -> query($MyQuery);

	while ($MyResults = $MyValues -> fetch_assoc())
	{
		$C_ORIG_AMT = $MyResults['Original_Amt'];
		$C_ORIG_NAME = $MyResults['Name'];
	}

	if ($C_UNIT == 'ml')
	{
		if ($C_AMOUNT > $C_ORIG_AMT)
		{
			$MyQuery = "UPDATE CHEMICALS SET Name = '$C_FixedName', Quantity_Available_ml = $C_AMOUNT, Quantity_Available_mg = NULL, Original_Amt = $C_AMOUNT WHERE (CHEMICALS.Chemical_Id = $C_ID);";
			mysqli_query($MyConnection, $MyQuery);
		}

		else
		{
			$MyQuery = "UPDATE CHEMICALS SET Name = '$C_FixedName', Quantity_Available_ml = $C_AMOUNT, Quantity_Available_mg = NULL, Original_Amt = $C_ORIG_AMT WHERE (CHEMICALS.Chemical_Id = $C_ID);";
			mysqli_query($MyConnection, $MyQuery);
		}
	}

	else
	{
		if ($C_AMOUNT > $C_ORIG_AMT)
		{
			$MyQuery = "UPDATE CHEMICALS SET Name = '$C_FixedName', Quantity_Available_ml = NULL, Quantity_Available_mg = $C_AMOUNT, Original_Amt = $C_AMOUNT WHERE (CHEMICALS.Chemical_Id = $C_ID);";
			mysqli_query($MyConnection, $MyQuery);
		}

		else
		{
			$MyQuery = "UPDATE CHEMICALS SET Name = '$C_FixedName', Quantity_Available_ml = NULL, Quantity_Available_mg = $C_AMOUNT, Original_Amt = $C_ORIG_AMT WHERE (CHEMICALS.Chemical_Id = $C_ID);";
			mysqli_query($MyConnection, $MyQuery);
		}
	}
?>