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
		<link rel="stylesheet" href="css/modal.css">
		<link rel="stylesheet" href="css/master.css">
		<title>Search Results</title>
		<?php 'loading head';include("head.php"); ?>
	</head>

	<!-- Body -->
	<body>
		<!--trigger the modal for confirm delete for chemical-->
			<div id="id02" class="w3-modal" style="z-index:9999;">
				<div class="w3-modal-content w3-animate-bottom" style="border-radius: 10px; padding: 20px;">
					<header class="w3-container" style="text-align: center;"> 
						<button onclick="document.getElementById('id02').style.display='none'" 
						class="btn btn-danger"><i class="fas fa-times"></i></button>
						<h3 style="padding: 8px;"><strong>Delete Item</strong></h3>
					</header>
					<div class="w3-container">
						<div class="content">
							<div class="container">
						    	<div class="row">
						        	<div class="col-md-12">
										<p>Are you sure you want to delete this item from the inventory?</p>
								        <footer class="w3-container">
											<div>
												<button class="btn btn-danger" id = "YES_ON_DELETE">Yes</button>
											</div>
											<div style="padding: 0px 80px 0px">
												<button class="btn btn-default" style="border: 1px solid #ccc" onclick="document.getElementById('id02').style.display='none'" id = "NO_ON_DELETE">No</button>
											</div>
										</footer>
										</form>
								    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="id03" class="w3-modal" style="z-index:9999;">
				<div class="w3-modal-content w3-animate-bottom" style="border-radius: 10px; padding: 20px;">
					<header class="w3-container" style="text-align: center;"> 
						<button onclick="document.getElementById('id03').style.display='none'" 
						class="btn btn-danger"><i class="fas fa-times"></i></button>
						<h3 style="padding: 8px;"><strong>Edit Item</strong></h3>
					</header>
					<div class="w3-container">
						<div class="content">
							<div class="container">
						    	<div class="row">
						        	<div class="col-md-12">
										<table class="table table-fit">
						          			<thead class="text-center">
								            	<tr>
									                <th class="align-middle text-center" style="width: 13%">ID</th>
									                <th class="align-middle text-center" style="width: 55%">Name</th>
									                <th class="align-middle text-center" style="width: 35%">Amount</th>
								            	</tr>
							            	</thead>
											<tbody class="text-center">
								            	<tr>
													<td class="align-middle text-center" align="center">
														<!--echo yung id number-->
													</td>
													<td class="align-middle text-center" align="center" align="center">
														<div class="col"><input class="form-control" name="name[]" placeholder="Name" required="required"></div>
													</td>
													<td class="align-middle text-center" align="center">
														<div class = "row align-content-center">
															<input class="form-control col-6" name="amount[]" placeholder="Amount" required="required">
															<select name = "unit[]" class="form-control col-6">
																	<option value = "ml" selected="selected">ml</option>
																	<option value = "mg">mg</option>
															</select>
														</div>
													</td>
												</tr>
								        	</tbody>
						          		</table>
								        <footer class="w3-container">
											<div>
												<button class="btn btn-primary">EDIT</button>
											</div>
										</footer>
										</form>
								    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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
						<button type="submit" class="button button5" onclick="editFunction()"><i class="fas fa-pencil-alt"></i></button>
						</td>';
						
						
						echo '<td>
						<button type="submit" class="button button5"';
						echo 'onclick = "deleteFunction('.$MyResults['Chemical_Id'].', &quot;CHEMICAL&quot;)"';
						echo'><i class="fas fa-trash-alt"></i></button> 
						</td>';
						echo '</tr>';
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
						<button type="submit" class="button button5" onclick="editFunction()"><i class="fas fa-pencil-alt"></i></button>
						</td>';
						
						
						echo '<td>
						<button type="submit" class="button button5"';
						echo 'onclick = "deleteFunction('.$MyResults['Glassware_Id'].', &quot;GLASSWARE&quot;)"';
						echo'><i class="fas fa-trash-alt"></i></button> 
						</td>';
						echo '</tr>';
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

<script>
	function editFunction(ID_VALUE)
			{
				document.getElementById("id03").style.display = "block";

			}

	function deleteFunction(ID_VALUE, type)
			{
				document.getElementById("id02").style.display = "block";

				if (type == "CHEMICAL")
				{
					$('#YES_ON_DELETE').on('click', function(event)
						{
							event.preventDefault();
							document.getElementById('id02').style.display='none';
							deleteChem(ID_VALUE);
						}
					);
				}

				else
				{
					$('#YES_ON_DELETE').on('click', function(event)
						{
							event.preventDefault();
							document.getElementById('id02').style.display='none';
							deleteGlass(ID_VALUE);
						}
					);
				}
			}

			function deleteChem(ID_VALUE)
			{
				$.ajax
				(
					{
					    url: "delete_chemical_item.php",
					    method: "POST",
					    data: {CHEM_ID: ID_VALUE},
					    success: function()
					    {
					    	topFunction();
					      	//$('#error').html('<div class="alert alert-success"><strong>Item Deleted!</strong><button class="btn btn-sm btn-success" onclick = "hideFunc()"><i class="fas fa-times"></button></div>');
							location.reload();
					    }
				   	}
			   	);
			}
			
			function hideFunc(){
				$('#error').hide;
			}

			function deleteGlass(ID_VALUE)
			{
				$.ajax
				(
					{
					    url: "delete_glassware_item.php",
					    method: "POST",
					    data: {GLASS_ID: ID_VALUE},
					    success: function()
					    {
					    	topFunction();
					      	//$('#error').html('<div class="alert alert-success"><strong>Item Deleted!</strong><button class="btn btn-sm btn-success" onclick = "hideDiV(this.parentElement)"><i class="fas fa-times"></button></div>');
							location.reload();
					    }
				   	}
			   	);
			}
</script>

