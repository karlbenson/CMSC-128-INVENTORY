<!DOCTYPE html>
<?php
	session_start();
	
	include("verify.php");
?>
<html>
<head>
	<title>Home: UPB Glasswares and Chemicals Inventory</title>
	<link rel="stylesheet" type="text/css" href="css/home.css">
	<?php 'loading head';include("head.php"); ?>
	<script type="text/javascript" src="js/date_time.js"></script>
</head>
<body>
	<div class="container-fluid hbod">
		<div class="container-fluid row justify-content-center first-row">
			<div class="col-lg-8">
				<h2>ALERTS</h2>
			</div>
			<span style="width: 8%;"></span>
			<div class="col-lg-3 timestamp align-text-middle">
				<h3>TODAY IS</h3>
				<h1><span id="date_time"></span></h1>
				<h1>
            		<script type="text/javascript">window.onload = date_time('date_time');</script>
				</h1>
			</div>
		</div>

		<div class="container-fluid row justify-content-between sec-row">
			<div class="col-lg-12">
				<h2>TRANSACTION HISTORY</h2>

			</div>	
		</div>
	</div>

	
</body>
</html>