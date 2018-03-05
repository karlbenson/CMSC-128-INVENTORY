<!DOCTYPE html>

<html lang="en">
<head>
	<title>Log in: UPB Glasswares and Chemicals Invetory</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/global.css" >
	<link rel="stylesheet" href="css/bootstrap.min.css">
	
	<script src='js/jquery-3.3.1.slim.min.js'></script>
	<script src='js/bootstrap.min.js'></script>	
</head>
<body>

<div class="container-fluid bg">
	<div class="container-fluid" style="text-align: center; padding-top: 1%; margin-bottom: 1%;"><a href="home.php"><img id=uplogo src="src/up.png" width="150px"></a></div>
	<div class="row">
			<div class="col-sm-12 stack container-fluid">
				<div style="height: 70px padding-bottom:20px;"><h2>University of The Philippines - Baguio</h2></div>
				<span class="hidden-sm-down">
					<div><h3>College of Science</h3></div>
					<div><h4>Glasswares and Chemicals Inventory</h4></div>
				</span>

			</div>
	</div>

	<div class="row">
	<div class="col-md-4 col-sm-4 col-xs-12"></div>
	<div class="col-md-4 col-sm-4 col-xs-12">
	<h3><!--LOG IN--></h3>
	<!--start of form-->
		<form class="form-container chenelin" style="margin-top:5%; margin-bottom: 4%;">
			<div class="form-group">
				<label for="exampleInputEmail1">USERNAME</label>
				<input type="text" name="username" class="form-control" id="exampleInputUsername1" placeholder="Username" required>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">PASSWORD</label>
				<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
			</div>
			<div class="checkbox">
				<label>
					<input title="Kapag nag-iisa~" type="checkbox"> Remember me
				</label>
			</div>
			<button type="submit" class="btn btn-success btn-block"  name="Login">LOG IN</button>
		</form>
	<!--end of form-->
	</div>
	<!--start of form-->
	</div>
</div>
</body>
