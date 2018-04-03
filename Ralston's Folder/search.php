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
    	<!-- Search -->
    	<div class="py-0">
    		<form class="form-signin" action="item_search_query.php">
    			<!-- Filter -->
    			<div class="form-group">
    				<select name = "search_Filter" id = "sell" class = "form-control">
						<option value = "0">Chemicals</option>
						<option value = "1">Glasswares</option>
						<option value = "2">Students</option>
						<option value = "3">Professors</option>
						<option value = "4">Subjects</option>
				    </select>
    			</div>
    			<!-- Search Bar -->
    			<div class="form-group" id = "search">
            		<input class = "form-control" type="search" id="search-input" name = "search_Query" placeholder="Search..."></input>
        		</div>
        		
        		<!-- Enter Button -->
      			<button type="submit" class="btn btn-primary">Enter</button>
    		</form>
    	</div>

    	<!-- Scripts -->
    	<script type = "text/javascript" src = "scripts/script.js"></script>
    	<script src="scripts/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="scripts/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="scripts/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	</body>
</html>