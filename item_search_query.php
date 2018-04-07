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
		<title>Search Results</title>
		<?php 'loading head';include("head.php"); ?>
	</head>

	<!-- Body -->
	<body>
    	<!-- Search Results-->
    	<?php
			$SearchFilter = $_REQUEST['search_Filter'];
 			$MySearchRequest = $_REQUEST['search_Query'];

 			if($SearchFilter == 0 && $MySearchRequest != "")
			{
				$MySearchQuery = "SELECT * FROM chemicals WHERE (chemicals.Name LIKE '%$MySearchRequest%') OR (chemicals.Chemical_Id LIKE '%$MySearchRequest%');";
 				$MyValues = $MyConnection -> query($MySearchQuery);

				if (($MyValues -> num_rows) > 0)
				{
					echo "<div class=py-3> <div class=container> <div class=row>";
					$TableClass = "table";
	                echo "<table class =".$TableClass.">";
	                echo
	                "
	              	<thead class=text-center>  	
						<tr>
			                <th>ID</th>
			                <th>Name</th>
			                <th>Amount (mg)</th>
							<th>Amount (ml)</th>
			                <th>Edit</th>
			                <th>Delete</th>
		            	</tr>
		            </thead>
	    			";
	                while ($MyResults = $MyValues -> fetch_assoc())
	                {
						echo '<tr>';
						echo '<td>'.$MyResults['Chemical_Id'].'</td>';
						echo '<td>'.$MyResults['Name'].'</td>';
						echo '<td>'.$MyResults['Quantity_Available_mg'].'</td>';
						echo '<td>'.$MyResults['Quantity_Available_ml'].'</td>';
						echo '<td>
						<form method="POST" action = "edit_chemical_item.php">
						<input type="hidden" class="hide" placeholder="'.$MyResults['Chemical_Id'].'" value="'.$MyResults['Chemical_Id'].'" name="Chemical_Id" readonly>
						<button type="submit" class="button button5 btn btn-success" style="cursor:pointer;"><i class="fa fa-pencil-alt fa-fw"></i></button>
						</form>
						</td>';
						
						
						echo '<td>
						<form method="POST" action = "delete_chemical_item.php">
						<input type="hidden" class="hide" placeholder="'.$MyResults['Chemical_Id'].'" value="'.$MyResults['Chemical_Id'].'" name="Chemical_Id" readonly>
						<button type="submit" class="button button5 btn btn-danger" style="cursor:pointer;"><i class="fa fa-trash-alt fa-fw"></i></button> 
						</form>
						</td>
						</tr>';
	                }
            		echo "</table>";
            		echo "</div> </div> </div>";
				}

				else
				{
					$EmptySearchResults = "Your search returned no matches.";
					$DivClass = "text-center py-5 jumbotron";
					echo "<div class = py-5><div class = ".$DivClass."><h3>".$EmptySearchResults."</h3><a href='search.php'><button class='btn btn-primaty text-center' style='cursor:pointer;'>BACK</button></a></div></div>";
				}
			}

			else if ($SearchFilter == 1 && $MySearchRequest != "")
			{
				$MySearchQuery = "SELECT * FROM glasswares WHERE (glasswares.Name LIKE '%$MySearchRequest%') OR (glasswares.Glassware_Id LIKE '%$MySearchRequest%');";
 				$MyValues = $MyConnection -> query($MySearchQuery);

				if (($MyValues -> num_rows) > 0)
				{
					echo "<div class=py-3> <div class=container> <div class=row>";
					$TableClass = "table";
	                echo "<table class =".$TableClass.">";
	                echo
	                "
	              	<thead class=text-center>  	
						<tr>
			                <th>ID</th>
			                <th>Name</th>
			                <th>Amount</th>
			                <th>Edit</th>
			                <th>Delete</th>
		            	</tr>
		            </thead>
	    			";
	                while ($MyResults = $MyValues -> fetch_assoc())
	                {
						echo '<tr>';
						echo '<td>'.$MyResults['Glassware_Id'].'</td>';
						echo '<td>'.$MyResults['Name'].'</td>';
						echo '<td>'.$MyResults['Quantity_Available'].'</td>';
					
						echo '<td>
						<form method="POST" action = "edit_glassware_item.php">
						<input type="hidden" class="hide" placeholder="'.$MyResults['Glassware_Id'].'" value="'.$MyResults['Glassware_Id'].'" name="Glassware_Id" readonly>
						<button type="submit" class="button btn button5 btn-success" style="cursor: pointer;"><i class="fas fa-pencil-alt fa-fw " ></i></button>
						</form>
						</td>';
						
						
						echo '<td>
						<form method="POST" action = "delete_glassware_item.php">
						<input type="hidden" class="hide" placeholder="'.$MyResults['Glassware_Id'].'" value="'.$MyResults['Glassware_Id'].'" name="Glassware_Id" readonly>
						<button type="submit" class="button button5 btn btn-danger" style="cursor:pointer;"><i class="fas fa-trash-alt fa-fw" ></i></button> 
						</form>
						</td>
						</tr>';
						//ADD DELETE CONFIRMATION
	                }
            		echo "</table>";
            		echo "</div> </div> </div>";
				}

				else
				{
					$EmptySearchResults = "Your search returned no matches.";
					$DivClass = "text-center py-5 jumbotron";
					echo "<div class = py-5><div class = ".$DivClass."><h3>".$EmptySearchResults."</h3><a href='search.php'><button class='btn btn-primaty text-center' style='cursor:pointer;'>BACK</button></a></div></div>";
				}
			}

			else if ($SearchFilter == 2 && $MySearchRequest != "")
			{
				$MySearchQuery = "SELECT * FROM borrower WHERE (borrower.First_Name LIKE '%$MySearchRequest%') OR (borrower.Borrower_Id LIKE '%$MySearchRequest%') or (borrower.Last_Name LIKE '%$MySearchRequest%') OR (borrower.Student_Number LIKE '%$MySearchRequest%');";
 				$MyValues = $MyConnection -> query($MySearchQuery);

				if (($MyValues -> num_rows) > 0)
				{
					echo "<div class=py-3> <div class=container> <div class=row>";
					$TableClass = "table";
	                echo "<table class =".$TableClass.">";
	                echo
	                "
	              	<thead class=text-center>  	
						<tr>
			                <th>ID</th>
			                <th>First Name</th>
			                <th>Last Name</th>
			                <th>Student Number</th>
		            	</tr>
		            </thead>
	    			";
	                while ($MyResults = $MyValues -> fetch_assoc())
	                {
						echo '<tr>';
						echo '<td>'.$MyResults['Borrower_Id'].'</td>';
						echo '<td>'.$MyResults['First_Name'].'</td>';
						echo '<td>'.$MyResults['Last_Name'].'</td>';
						echo '<td>'.$MyResults['Student_Number'].'</td>';
	                }
            		echo "</table>";
            		echo "</div> </div> </div>";
				}

				else
				{
					$EmptySearchResults = "Your search returned no matches.";
					$DivClass = "text-center py-5 jumbotron";
					echo "<div class = py-5><div class = ".$DivClass."><h3>".$EmptySearchResults."</h3><a href='search.php'><button class='btn btn-primaty text-center' style='cursor:pointer;'>BACK</button></a></div></div>";
				}
			}

 		?>
 		
    	<!-- Scripts -->
    	<script type = "text/javascript" src = "scripts/script.js"></script>
    	<script src="scripts/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="scripts/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="scripts/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	</body>
</html>