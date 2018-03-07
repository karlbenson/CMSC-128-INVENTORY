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

	$item = $_POST['Glassware_Id'];
	$MySearchQuery = "SELECT * FROM glasswares WHERE (glasswares.Glassware_Id = $item);";
	$MyValues = $MyConnection -> query($MySearchQuery);

	if (($MyValues -> num_rows) > 0)
	{
		while ($MyResults = $MyValues -> fetch_assoc())
		{
			$e_id = $MyResults['Glassware_Id'];
			$e_name = $MyResults['Name'];
			$e_amount = $MyResults['Quantity_Available'];
		}
	}

	if($_POST['save'])
	{
		
		$ne_name = $_POST['e_name'];
		$ne_amount = $_POST['e_amount'];
		$ne_id = $_POST['e_id'];
		
		if(empty($ne_id))
        {
        	$ne_id = $e_id;
        }

        if(empty($ne_name))
        {
        	$ne_name = $e_name;
        }

        if(empty($ne_amount))
        {
        	$ne_name = $e_amount;
        }

		$ne_fixedName = mysqli_real_escape_string($MyConnection, $ne_name);

		mysqli_query($MyConnection, "UPDATE glasswares SET Name = '$ne_fixedName', Quantity_Available = $ne_amount WHERE (glasswares.Glassware_Id = $ne_id);");

		echo "<script>alert('Edited Successfully!');
			location = 'master.php';</script>";
	}
?>

<!DOCTYPE html>
<html>
	<!-- Head -->
	<head>
		<?php include("head.php"); ?>
		<title>Add to Inventory</title>
	</head>

	<!-- Body -->
	<body onload="hideSpecial()">

    	<!--Body Contents-->
	
		<form class="form-signin" name="myForm" method="POST" enctype="multipart/form-data" name="addroom" onsubmit="return validateForm()">
			<div id = "2">
				<h1 class="jumbotron-fluid text-center py-4" style="font-size: 30px"><em>Edit Equipment</em></h1>
				<div class="form-group row">
					<label class="col-form-label">ID</label>
					<div class="col">
						<input class="form-control" name="e_id" placeholder="<?php echo $e_id ?>" value = "<?php echo $e_id ?>" readonly>
					</div>
					<label class="col-form-label">Name</label>
					<div class="col">
						<input class="form-control" name="e_name" placeholder="<?php echo $e_name ?>">
					</div>
					<label class="px-2 col-form-label">Amount</label>
					<div class="form-inline">
						<input class="form-control" name="e_amount" placeholder="<?php echo $e_amount ?>">
					</div>
				</div>	
			</div

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