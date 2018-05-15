<?php
	session_start();
	
	error_reporting(0);

	$s_id= $_POST['sid'];
	$lname = $_POST['lname'];
	$fname = $_POST['fname'];
	$professor = $_POST['professor'];
	$subject = $_POST['subject'];

	$it = $_POST['it'];
	$amount = $_POST['amount'];
	$max=$_POST['max'];
	$unit = $_POST['unit'];


	//Server Credentials
 	 $MyServerName = "localhost";
 	 $MyUserName = "root";
 	 $MyPassword = "";
 	 //Database
 	 $MyDBName = 'chem_glasswares';
 	 $MyConnection = mysqli_connect($MyServer, $MyUserName, $MyPassword, $MyDBName);
  
 	// include("verify.php");

    //fetch all student numbers 
    $MySearchQuery = "SELECT * FROM borrower";
	$MyValues = $MyConnection -> query($MySearchQuery);
	if (($MyValues -> num_rows) > 0){ 
		while ($MyResults = $MyValues -> fetch_assoc()){
			$sn_arr[] = $MyResults['Student_Number'];
		}//end while
	}//end if    

	
	$flag=0;
	$cnt=0;
	$s = null;

	$query = "SELECT * FROM group_table WHERE (Professor = '$professor' AND Subject = '$subject')";
	$id = mysqli_query($MyConnection, $query);
	$row = mysqli_fetch_assoc($id);
	
	$id = mysqli_query($MyConnection, "SELECT Group_Id FROM group_table WHERE (Professor = '$professor' AND Subject = '$subject');");

	$group_id = $row['Group_Id'];
	foreach($sn_arr as $sn){//check if all borrowers exist
		$result=mysqli_query($MyConnection,"SELECT * FROM borrower WHERE (Student_Number='$sn' AND Group_Id = $group_id )");
		if(mysqli_num_rows($result)>0)
		{
			$cnt = $cnt+1;
		}
	}//end for

	if(count($s_id)==$cnt){ //flag will tell us if borrowers already exist
		$flag=1;
	}//end if

	
	if ($flag==0){ //create a new group and make new borrower entries 
		//create new group
		$FixedName = mysqli_real_escape_string($MyConnection, $professor);
		mysqli_query($MyConnection, "INSERT INTO group_table (Professor,Subject) VALUES ('$FixedName','$subject');"); 
 		
 		//get group id of new group
		$result = mysqli_query($MyConnection,"SELECT MAX(Group_Id) AS max FROM group_table"); 
		$row = mysqli_fetch_array($result, MYSQLI_NUM); 
		$group_id= $row[0];

		//add new borrowers
		$i=0;
		while ($i < sizeof($s_id)){
			$f_name = $fname[$i];$l_name=$lname[$i];$sn=$s_id[$i];
			mysqli_query($MyConnection,"INSERT INTO borrower (First_Name,Last_Name,Student_Number,Amt_of_transactions,Group_Id) VALUES ('$f_name','$l_name','$sn','0','$group_id');"); 
			$i=$i+1;
		}//end while
	}//end if


	//CHEMICALS/GLASSWARES part

	$x=0; //to find index of amount and unit
	foreach($it AS $item){ //loop thru each item
		$query = "SELECT * FROM glasswares WHERE Name = '$item'";
		$result = mysqli_query($MyConnection,$query);

		if (mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_assoc($result);
			$id = $row['Glassware_Id'];
			$amt = $amount[$x];
			$date = date("Y-m-d");

			mysqli_query($MyConnection, "INSERT INTO transaction (Glassware_Id,Group_Id,Qty_Borrowed_Glasswares, Qty_Borrowed_Chemicals_mg, Qty_Borrowed_Chemicals_ml,Date_Borrowed) VALUES ($id, $group_id, $amt, 0, 0, '$date')");
			mysqli_query($MyConnection, "UPDATE glasswares SET Quantity_Available=Quantity_Available-'$amt' WHERE Glassware_Id='$id'");
			mysqli_query($MyConnection, "UPDATE borrower SET Amt_of_transactions=Amt_of_transactions+1 WHERE Group_Id='$group_id'");
		}

		else
		{
			$query = "SELECT * FROM chemicals WHERE Name = '$item'";
			$result = mysqli_query($MyConnection,$query);

			$row = mysqli_fetch_assoc($result);
			$id = $row['Chemical_Id'];
			$amt = $amount[$x];
			$date = date("Y-m-d");

			if ($unit[$x]=='ml'){
				mysqli_query($MyConnection, "UPDATE chemicals SET Quantity_Available_ml=Quantity_Available_ml-'$amt' WHERE Chemical_Id=$id");
				mysqli_query($MyConnection, "INSERT INTO transaction (Chemical_Id,Group_Id,Qty_Borrowed_Glasswares, Qty_Borrowed_Chemicals_mg, Qty_Borrowed_Chemicals_ml,Date_Borrowed,Date_Returned) VALUES ($id, $group_id, 0, 0, $amt, '$date','$date')");
			}else{
				mysqli_query($MyConnection, "UPDATE chemicals SET Quantity_Available_mg=Quantity_Available_mg-'$amt' WHERE Chemical_Id=$id");
				mysqli_query($MyConnection, "INSERT INTO transaction (Glassware_Id,Group_Id,Qty_Borrowed_Glasswares, Qty_Borrowed_Chemicals_mg, Qty_Borrowed_Chemicals_ml,Date_Borrowed,Date_Returned) VALUES ($id, $group_id, 0, $amt, 0, '$date','$date')");
			}

			
			
		}
		$x=$x+1;
		
	}//end for


	echo "<script>alert('Success!');</script>";
	header('location:home.php');
	exit();
?>