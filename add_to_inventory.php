<?php
	session_start();
	error_reporting(0);
	
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

	//Server Credentials
	$MyServerName = "localhost";
	$MyUserName = "root";
	$MyPassword = "";

	//Database
	$MyDBName = 'chem_glasswares';

	$MyConnection = mysqli_connect($MyServer, $MyUserName, $MyPassword, $MyDBName);

	if($_POST['save'])
	{
		$special = $_POST['special'];
		if ($special == 2)
		{
			
			$c_name = $_POST['c_name'];
			$c_amount = $_POST['c_amount'];

			$c_fixedName = mysqli_real_escape_string($MyConnection, $c_name);

			mysqli_query($MyConnection, "INSERT INTO chemicals (Name, Quantity_Available) VALUES ('$c_fixedName', $c_amount);");
		}

		else
		{
			
			$e_name = $_POST['e_name'];
			$e_amount = $_POST['e_amount'];

			$e_fixedName = mysqli_real_escape_string($MyConnection, $e_name);

			mysqli_query($MyConnection, "INSERT INTO glasswares (Name, Quantity_Available) VALUES ('$e_fixedName', $e_amount);");
		}

		echo "<script>alert('Added Successfully!');
			location = 'master.php';</script>";
	}
?>

<!DOCTYPE html>
<html>
	<!-- Head -->
	<head>
		<?php 
			echo include("head.php");
		?>
		<title>Add to Inventory</title>
	</head>

	<!-- Body -->
	<body onload="hideSpecial()">

		<!-- Navigation Bar -->
	    <nav class="navbar navbar-expand-md">
	    	<div class="container">
	    		<a class="navbar-brand" href="master.php">
	    			<b>Home</b>
	    		</a>
	    		<!-- Links -->
	    		<div class="collapse navbar-collapse text-center justify-content-end" id="navbar2SupportedContent">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="add_to_inventory.php"><i class="fa d-inline"></i>Add to Inventory</a>
						</li>
					</ul>
	       		</div>
	      	</div>
    	</nav>

    	<!--Body Contents-->
	
		<form class="form-signin" name="myForm" method="POST" enctype="multipart/form-data" name="addroom" onsubmit="return validateForm()">

			<div>
				<select name="special" class="form-control" onchange="updateSpecial(this.value)">
					<option value="2">Add Chemical</option>
					<option value="3">Add Equipment</option>
				</select>
			</div>

			<div id = "2">
				<h1 class="jumbotron-fluid text-center py-4" style="font-size: 30px"><em>Chemical</em></h1>
				<div class="form-group row">
					<label class="col-form-label">Name</label>
					<div class="col">
						<input class="form-control" name="c_name">
					</div>
					<label class="px-2 col-form-label">Amount</label>
					<div class="form-inline">
						<input class="form-control" name="c_amount">
					</div>
				</div>	
			</div>

			<div id = "3">
				<h1 class="jumbotron-fluid text-center py-4" style="font-size: 30px"><em>Equipment</em></h1>
				<div class="form-group row">
					<label class="col-form-label">Name</label>
					<div class="col">
						<input class="form-control" name="e_name">
					</div>
					<label class="px-2 col-form-label">Amount</label>
					<div class="form-inline">
						<input class="form-control" name="e_amount">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="container">
						<div class="row">
							<div class="col-md-12 center">
								<center>
									<button class="btn" type="submit" name="save" value="save" id="button1" style="width: 150px; height: 60px; padding: 5px"><span>Save</span>
									</button>
								</center>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>

		<!-- Scripts and Additional Styles-->
		<script type="text/javascript" src="scripts/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="scripts/bootstrap-datepicker.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap-datepicker3.css"/>
		<script>
			function hideForm(input)
			{
				$(input).hide();
			}

			function showForm(input)
			{
				$(input).show();
			}

			function hideSpecial()
			{
				hideForm("#3");
			}

			function updateSpecial(input)
			{
				if (input == "2")
				{
					showForm("#2");
					hideForm("#3");
				}

				else if (input == "3")
				{
					showForm("#3");
					hideForm("#2");
				}
			}
		</script>
		<script src="scripts/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="scripts/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="scripts/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		<script type="text/javascript" src="scripts/formden.js"></script>
		<link rel="stylesheet" href="css/bootstrap-iso.css" />
		<style>
			.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form
			{
				font-family: Arial, Helvetica, sans-serif;
				color: black;
			}

			.bootstrap-iso form button, .bootstrap-iso form button:hover
			{
				color: white !important;
			}

			.asteriskField
			{
				color: red;
			}
		</style>
	</body>
</html>