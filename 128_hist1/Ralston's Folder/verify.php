<?php

	error_reporting(0);

//Server Credentials
	$MyServerName = "localhost";
	$MyUserName = "root";
	$MyPassword = "";

	//Database
	$MyDBName = 'chem_glasswares';

	$MyConnection = mysqli_connect($MyServer, $MyUserName, $MyPassword, $MyDBName);
if (isset($_SESSION['username'])){
		
		$username=$_SESSION['username'];
		$query = "SELECT status FROM user_accounts WHERE Username = '$username'";
		
		if (!$MyConnection){
			echo 'Not connected to server';
		}
	
		if (!mysqli_select_db($MyConnection,'chem_glasswares')){
			echo 'Database not selected';
		}
		
		if ($result=mysqli_query($MyConnection,$query)){
		
			while ($row=mysqli_fetch_row($result)){
				$status=$row[0];
			}
		}//end if
		
		if ($status==0){
			
			echo 
			'<script type="text/javascript"> alert("ACCESS DENIED") 
			window.location.href = "login.php"
			</script>';
			
		}
		mysqli_close($con);
	}else{
		echo 
		'<script type="text/javascript"> alert("ACCESS DENIED") 
		window.location.href = "login.php"
		</script>';
	}//end if
?>	