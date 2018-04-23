<?php
	session_start();
	error_reporting(0);

	//Server Credentials
	$MyServerName = "localhost";
	$MyUserName = "root";
	$MyPassword = "";

	//Database
	$MyDBName = 'chem_glasswares';

	$MyConnection = mysqli_connect($MyServer, $MyUserName, $MyPassword, $MyDBName);
	
	//include("verify.php");
	
	for($count = 0; $count < count($_POST['special']); $count++)
	{
		$special = $_POST['special'][$count];

		if ($special == 'chem')
		{
			$c_name = $_POST['name'][$count];
			$c_unit = $_POST['unit'][$count];
			$c_amount_orig = $_POST['amount'][$count];
			$c_fixedName = mysqli_real_escape_string($MyConnection, $c_name);

			if ($c_unit == 'ml')
			{
				$c_amount_ml = $_POST['amount'][$count];
				mysqli_query($MyConnection, "INSERT INTO chemicals (Name, Quantity_Available_ml, Original_Amt) VALUES ('$c_fixedName', $c_amount_ml, $c_amount_orig);");
			}

			else
			{
				$c_amount_mg = $_POST['amount'][$count];
				mysqli_query($MyConnection, "INSERT INTO chemicals (Name, Quantity_Available_mg, Original_Amt) VALUES ('$c_fixedName', $c_amount_mg, $c_amount_orig);");
			}
		}

		else
		{
			$e_name = $_POST['name'][$count];
			$e_amount = $_POST['amount'][$count];

			$e_fixedName = mysqli_real_escape_string($MyConnection, $e_name);


			mysqli_query($MyConnection, "INSERT INTO glasswares (Name, Quantity_Available) VALUES ('$e_fixedName', $e_amount);");
		}
	}

	header("location =master.php");

?>