<?php
	$grp_id= $_POST['Group_Id'];
	$b_id= $_POST['Borrower_Id'];
	$g_id= $_POST['Glassware_Id'];
	$t_id =$_POST['Trans_Id'];
	$qty= $_POST['Qty'];

	//#include("verify.php");

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
	
	
	$date_today = date("Y-m-d");

	mysqli_query($MyConnection, "UPDATE transaction SET Date_Returned='$date_today' WHERE transaction.Trans_Id=$t_id"); //set date returned to today
	mysqli_query($MyConnection, "UPDATE glasswares SET Quantity_Available=Quantity_Available+$qty WHERE glasswares.Glassware_Id=$g_id"); //Add quantity available
	mysqli_query($MyConnection, "UPDATE borrower SET Amt_of_transactions=Amt_of_transactions-1 WHERE borrower.Group_Id=$grp_id"); //Deduct amt of transactions by 1 for all groupmates
	
	header("Refresh:0; url=home.php");
?>