<!DOCTYPE html>

<html lang="en">
<head>
	<title>Log in: UPB Glasswares and Chemicals Invetory</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min2.css">
	<link href="css/global.css" rel="stylesheet">
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
	<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>	
</head>
<body>

<div class="container-fluid bg">
	<div class="container-fluid topmost">
		<div class="row">
		<a href="login.php"><img src="pics/uplogo.png" width="120px" class="center"></a>
		</div>
	</div>

	<div class="row">
	<h2 class="mid">University of The Philippines - Baguio</h2>
	<!--<h3 class="mid">University of the Philippines</h3>-->
	<h3 class="mid sec">College of Science <br/>Glasswares and Chemicals Inventory</h3>
	<div class="col-md-4 col-sm-4 col-xs-12"></div>
	<div class="col-md-4 col-sm-4 col-xs-12">
	<h3><!--LOG IN--></h3>
	<!--start of form-->
		<form class="form-container">
		
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
				<input type="checkbox"> Remember me
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