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
	
	
	foreach($sn_arr as $sn){//check if all borrowers exist

		//nagloloko siya here if kunyare may 2 different groups ang isang borrower. dun sa may cnt
		//di yata pwede ang case kapag magkagrupo kayo pero ibang prof and ibang subj
		//ang naisip kong solution is icheck if yung group at prof at subj ay nagmamatch and if not create a new group

		foreach($s_id as $new_sn){
			if ($sn==$new_sn){
				$cnt=$cnt+1;
			}
		}//end for
	}//end for

	if(sizeof($s_id)==$cnt){ //flag will tell us if borrowers already exist
		$flag=1;
	}//end if

	
	
	if ($flag){ //if borrowers already exist in table 
		
		foreach($s_id as $sn){ //fetch all their group ids
			$result = mysqli_query($MyConnection,"SELECT Group_Id FROM Borrower WHERE Student_Number='$sn'"); 
			$row = mysqli_fetch_array($result, MYSQLI_NUM);
			$arr_grp[]=$row[0];
		}//end for
		
		if (count(array_unique($arr_grp)) == 1) { //if all in same group do nothing
			$group_id=$row[0];
			
		}else{ //if not, create a new group and new borrower entry (magloloko ulit dito pero sa mga susunod na submissions hindi sa submission na to mismo)
			//create new group
			mysqli_query($MyConnection,"INSERT INTO group_table (Professor,Subject) VALUES ('$professor','$subject');"); 
 		
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
		}	

	}else{ //create a new group and make new borrower entries (Cinopy paste ko lang to from the code above huhu ang panget aaysuin ko to)
		//create new group
		mysqli_query($MyConnection,"INSERT INTO group_table (Professor,Subject) VALUES ('$professor','$subject');"); 
 		
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
		
	}
	
	

	//CHEMICALS/GLASSWARES part



	//bug: di nagbabawas yung susunod na chemicals (dapat nasa unahan siya)
	$x=0; //to find index of amount and unit
	foreach($it AS $item){ //loop thru each item
		$MySearchQuery = "SELECT * FROM glasswares WHERE Name = '$item'";
		$MyValues = $MyConnection -> query($MySearchQuery);

		if (($MyValues -> num_rows) > 0){ //if glassware
			$MyResults = $MyValues -> fetch_assoc();
			$id = $MyResults['Glassware_Id'];
			$is_glass=1;
			//deduct amount 
			$amt = $amount[$x];
			mysqli_query($MyConnection, "UPDATE glasswares SET Quantity_Available=Quantity_Available-'$amt' WHERE Glassware_Id='$id'");
		}else{
			$is_glass=0;
			$MySearchQuery = "SELECT * FROM chemicals WHERE Name = '$item'";
			$MyValues = $MyConnection -> query($MySearchQuery);

			if (($MyValues -> num_rows) > 0){ //if chemical
				$MyResults = $MyValues -> fetch_assoc();
				$id=$MyResults['Chemical_Id'];

				//deduct amount
				$amt = $amount[$x];
				$unit = $unit[$x];
				if($unit=='ml'){
					mysqli_query($MyConnection, "UPDATE chemicals SET Quantity_Available_ml=Quantity_Available_ml-'$amt' WHERE Chemical_Id='$id'");
				}else if($unit=='mg'){
					mysqli_query($MyConnection, "UPDATE chemicals SET Quantity_Available_mg=Quantity_Available_mg-'$amt' WHERE Chemical_Id='$id'");
				}//end if
				
			}//end if	
		}//end if
		
		$x=$x+1;//update amount index

		//add transaction entry
		$date_now=date("Y-m-d");
		
		//$date_today = date('Y-m-d H:i:s', strtotime($date_now));

		if($is_glass==1){
			mysqli_query($MyConnection,"INSERT INTO transaction (Glassware_Id,Group_Id,Qty_Borrowed_Glasswares,Date_Borrowed) VALUES ('$id','$group_id','$amt', NOW());");
			//add amt of transactions because it is glassware. does not apply to chemicals
			mysqli_query($MyConnection, "UPDATE borrower SET Amt_of_transactions=Amt_of_transactions+1 WHERE Group_Id='$group_id'");
		}else{
			if($unit=='mg'){
				mysqli_query($MyConnection,"INSERT INTO transaction (Chemical_Id,Group_Id,Qty_Borrowed_Chemicals_mg,Date_Borrowed,Date_Returned) VALUES ('$id','$group_id','$amt',NOW(),NOW());");
			}else{
				mysqli_query($MyConnection,"INSERT INTO transaction (Chemical_Id,Group_Id,Qty_Borrowed_Chemicals_ml,Date_Borrowed,Date_Returned) VALUES ('$id','$group_id','$amt',NOW(),NOW());");
			}//end if
		}//end if
		echo "<script>alert('Success!');</script>";
		header('location:home.php');
		exit();

		
	}//end for

?>