<!DOCTYPE html>
<?php
	session_start();
	
	//verify if any user is logged in... otherwise kick them out!!
	if (isset($_SESSION['username'])){
		$con = mysqli_connect('127.0.0.1','root','');
		$username=$_SESSION['username'];
		$query = "SELECT status FROM user_accounts WHERE Username = '$username'";
		
		if (!$con){
			echo 'Not connected to server';
		}
	
		if (!mysqli_select_db($con,'chem_glasswares')){
			echo 'Database not selected';
		}
		
		if ($result=mysqli_query($con,$query)){
		
			while ($row=mysqli_fetch_row($result)){
				$status=$row[0];
				echo $status;
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
<html>
<head>
	<title>Home: UPB Glasswares and Chemicals Inventory</title>
	<link rel="stylesheet" type="text/css" href="css/home.css">
	<?php include("head.php"); ?>
</head>
<body>
	<div class="container-fluid hbod">
		<div class="container-fluid row justify-content-center first-row">
			<div class="col-lg-8">
				<h2>ALERTS</h2>
			</div>
			<span style="width: 8%;"></span>
			<div class="col-lg-3">
				
			</div>
		</div>

		<div class="container-fluid row justify-content-between sec-row">
			<div class="col-lg-12">
				<h2>TRANSACTION HISTORY</h2>

			</div>	
		</div>
	</div>
	
	<?php
	
	?>
</body>
</html>

