<?php
	session_start();
	error_reporting(0);
	
	//Server Credentials
	$MyServerName = "localhost";
	$MyUserName = "root";
	$MyPassword = "";

	//Database
	$MyDBName = 'chem_glasswares';

	//Create Connection
	$MyConnection = mysqli_connect($MyServerName, $MyUserName, $MyPassword, $MyDBName);

	//Check Connection Status
	if ($MyConnection -> connect_error)
	{
		die("Connection Failed: ". $MyConnection -> connect_error);
	}
?>
<!DOCTYPE html>
<html>
	<!-- Head -->
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
  		<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
  		<link rel="stylesheet" href="home.css" type="text/css">
		<title>Search Page</title>
		<?php 'loading head';include("head.php"); ?>
	</head>

	<!-- Body -->
	<body>
		<div class="container-fluid">
			<!-- Search -->
	    	<div class="container" style="padding: 20px; margin-bottom: 50px; border-radius: 10px; background-color: #edeef2; border:2px solid #dbdbdb;">
	    		<div class="py-5">
		    		<form class="form-signin" action="item_search_query.php">
		    			<!-- Filter -->
		    			<div class="form-group" >
		    				<select name = "search_Filter" id = "sell" class = "form-control" style="cursor: pointer;">
								<option value = "0">Chemicals</option>
								<option value = "1">Glasswares</option>
								<option value = "2">Students</option>
						    </select>
		    			</div>
		    			<!-- Search Bar -->
		    			<div class="form-group" id = "search">
		            		<input class = "form-control" type="search" id="search-input" name = "search_Query" placeholder="Search..." required="required"></input>
		        		</div>
		        		
		        		<!-- Enter Button -->
		      			<button type="submit" class="btn btn-primary" style="cursor: pointer;">Enter</button>
		    		</form>
	    		</div>
	    		
	    	</div>
		</div>
    	
    	
		
    	<!-- Scripts -->
    	<script type = "text/javascript" src = "scripts/script.js"></script>
    	<script src="scripts/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="scripts/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="scripts/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

		<!--Style-->
		<style type="text/css">
			.py-5 form
			{
				display: table;
				margin: auto;
			}

			.py-5 button
			{
				display: table;
				margin: auto;
			}

			input[type = search]
			{
				text-align: center;
				display: table;
				margin: auto;
				width: 200px;
				box-sizing: border-box;
				border: 2px solid #ccc;
				border-radius: 4px;
				font-size: 20px;
				background-color: white;
				background-position: 10px 10px; 
				background-repeat: no-repeat;
				-webkit-transition: width 0.4s ease-in-out;
				transition: width 0.4s ease-in-out;
			}

			input[type = search]:focus
			{	
				display: table;
				margin: auto;
				width: 1000px;
				text-align: left;
			}

			.py-5 select
			{
				width: auto;
				display: table;
				margin: auto;
			}
		</style>
	</body>
	<footer class="footer" style="position: absolute;right: 0;bottom: 0;left: 0; flex-shrink: 0;">
		<?php include("footer.php"); ?>
	</footer>
	
</html>