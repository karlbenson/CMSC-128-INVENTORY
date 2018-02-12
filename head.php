<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--LINKS TO CSS-->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/head.css">
	<link rel="stylesheet" href="css/fa/css/fontawesome-all.css">
	<script type="text/javascript" src="js/sideMenuBar.js"></script>
</head>

<!--BODY STARTS HERE-->
<body>
	<button class="btn-danger" onclick="topFunction()" id="myBtn" title="Go to top"><i class="far fa-arrow-alt-circle-up"></i></button>
	<div id="mySidemenu" class="sidemenu">
		<a href="javascript:void(0)" class="close" onclick="closeSM()">&times;</a>
		<div class="sm-wrapper">
			<a href="#"><i class="fas fa-search"></i> Search</a>
			<a href="master.php"><i class="fas fa-th-list"></i> Master List</a>
			<a href="#"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
		</div>
	</div>
	<div class="container-fluid topmost">
		<div class="hidden-md-up container-fluid" style="text-align: center;"><a href="home.php"><img id=uplogo src="src/up.png" width="180px"></a></div>
		<div class="row">
			<div class="col-sm-2 hidden-sm-down"><a href="home.php"><img src="src/up.png" width="180px"></a></div>
			<div class="col-sm-8 stack container-fluid">
				<div style="height: 70px padding-bottom:20px;"><h1>University of The Philippines - Baguio</h1></div>
				<span class="hidden-sm-down">
					<div><h2>College of Science</h2></div>
					<div><h3>Glasswares and Chemicals Inventory</h3></div>
				</span>
			</div>
			<div class="col-sm-2 hidden-sm-down"><img src="src/cs.png" width="180px" style="right: 20px;"></div>
		</div>
	</div>
	<div class="container-fluid second">
		<div class="container">
			<div class="row">
			<div class="col-sm-3"><a href="home.php"><i class="fas fa-home"></i> HOME</a></div>

			<div class="col-sm-9 hidden-sm-down">
				<div class="row fix-width" style="float: right;">
					<div><a href="#"><i class="fas fa-search"></i> Search</a></div>
					<div><a href="master.php"><i class="fas fa-th-list"></i> Master List</a></div>
					<div><a href="#"><i class="fas fa-sign-out-alt"></i> Sign Out</a></div>
				</div>
			</div>
			<div class="container-fliud hidden-md-up col-sm-9" style="text-align: right; position: absolute; right: 5%;">
				<button type="button" class="btn btn-secondary" id="pg-content" onclick="openSM()"><i class="fas fa-bars"></i>
			</div>
			
			</div>
		</div>
	</div>
</body>



<!--END HTML-->
</html>