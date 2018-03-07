<!DOCTYPE html>
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
	
	if (isset($_SESSION['username'])){
		
		$username=$_SESSION['username'];
		$query = "SELECT status FROM user_accounts WHERE Username = '$username'";
		
		if (!$MyConnection){
			echo 'Not connected to server';
		}
	
		if (!mysqli_select_db($MyConnection,'chem_glasswares')){
			echo 'Database not selected';
		}
		
		if ($result=mysqli_query($MyConnection,$query)){
		
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

	
?>
<html>
<head>
	<title>Master List: UPB Glasswares and Chemicals Inventory</title>
	<?php echo include("head.php"); ?>
	<link rel="stylesheet" href="css/master.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div id="container-fluid">
	
	<div class="tab">
		<button class="tablinks" onclick="window.location.href='add_to_inventory.php'">Add to Inventory</button>
		<button class="tablinks" onclick="openTab(event, 'Chemicals')">Chemicals</button>
		<button class="tablinks" onclick="openTab(event, 'Equipments')">Equipments</button>
		<button class="tablinks" onclick="openTab(event, 'All')">All</button>
	</div>
	

	<div id="All" class="tabcontent">
		<!--table for both chemicals+equipments-->
		<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Chemicals</em></h1>
	    	<div>
	    		<div class="container">
			    	<div class="row">
			        	<div class="col-md-12 table-responsive">
			          		<table width="100%" class="table table-hover">
			          			<thead class="text-center">
					            	<tr>
						                <th style="width: 13%">ID</th>
						                <th style="width: 42%">Name</th>
						                <th style="width: 25%">Amount</th>
						                <th style="width: 10%">Edit</th>
						                <th style="width: 10%">Delete</th>
					            	</tr>
					            </thead>
					            <tbody>
								
									<?php
										$MySearchQuery = "SELECT * FROM chemicals ORDER BY Chemical_Id;";
										$MyValues = $MyConnection -> query($MySearchQuery);
										if (($MyValues -> num_rows) > 0)
										{
											while ($MyResults = $MyValues -> fetch_assoc())
											{
												echo '<tr>';
												echo '<td>'.$MyResults['Chemical_Id'].'</td>';
												echo '<td>'.$MyResults['Name'].'</td>';
												echo '<td>'.$MyResults['Quantity_Available'].'</td>';
											
												echo '<td>
												<form method="POST" action = "edit_chemical_item.php">
												<input type="hidden" class="hide" placeholder="'.$MyResults['Chemical_Id'].'" value="'.$MyResults['Chemical_Id'].'" name="Chemical_Id" readonly>
												<button type="submit" class="button button5"><i class="fa fa-pencil fa-fw" ></i></button>
												</form>
												</td>';
												
												
												echo '<td>
												<form method="POST" action = "delete_chemical_item.php">
												<input type="hidden" class="hide" placeholder="'.$MyResults['Chemical_Id'].'" value="'.$MyResults['Chemical_Id'].'" name="Chemical_Id" readonly>
												<button type="submit" class="button button5" ><i class="fa fa-trash fa-fw"></i></button> 
												</form>
												</td>
												</tr>';
												//ADD DELETE CONFIRMATION
	
											}
										}
									?>
					        	</tbody>
					        </table>
					    </div>
					</div>
				</div>
			</div>
			<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Equipments</em></h1>
	    	<div>
	    		<div class="container">
			    	<div class="row">
			        	<div class="col-md-12 table-responsive">
			          		<table width="100%" class="table table-hover">
			          			<thead class="text-center">
					            	<tr>
						                <th style="width: 13%">ID</th>
						                <th style="width: 42%">Name</th>
						                <th style="width: 25%">Amount</th>
						                <th style="width: 10%">Edit</th>
						                <th style="width: 10%">Delete</th>
					            	</tr>
					            </thead>
					            <tbody>
								
									<?php
										$MySearchQuery = "SELECT * FROM glasswares ORDER BY Glassware_Id;";
										$MyValues = $MyConnection -> query($MySearchQuery);
										if (($MyValues -> num_rows) > 0)
										{
											while ($MyResults = $MyValues -> fetch_assoc())
											{
												echo '<tr>';
												echo '<td>'.$MyResults['Glassware_Id'].'</td>';
												echo '<td>'.$MyResults['Name'].'</td>';
												echo '<td>'.$MyResults['Quantity_Available'].'</td>';
											
												echo '<td>
												<form method="POST" action = "edit_glassware_item.php">
												<input type="hidden" class="hide" placeholder="'.$MyResults['Glassware_Id'].'" value="'.$MyResults['Glassware_Id'].'" name="Glassware_Id" readonly>
												<button type="submit" class="button button5"><i class="fa fa-pencil fa-fw" ></i></button>
												</form>
												</td>';
												
												
												echo '<td>
												<form method="POST" action = "delete_glassware_item.php">
												<input type="hidden" class="hide" placeholder="'.$MyResults['Glassware_Id'].'" value="'.$MyResults['Glassware_Id'].'" name="Glassware_Id" readonly>
												<button type="submit" class="button button5" ><i class="fa fa-trash fa-fw"></i></button> 
												</form>
												</td>
												</tr>';
												//ADD DELETE CONFIRMATION
	
											}
										}
									?>
					        	</tbody>
					        </table>
					    </div>
					</div>
				</div>
			</div>
			
	</div>

	<div id="Chemicals" class="tabcontent">
		<!--table for chemicals only*/ -->
		<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Chemicals</em></h1>
	    	<div>
	    		<div class="container">
			    	<div class="row">
			        	<div class="col-md-12 table-responsive">
			          		<table width="100%" class="table table-hover">
			          			<thead class="text-center">
					            	<tr>
						                <th style="width: 13%">ID</th>
						                <th style="width: 42%">Name</th>
						                <th style="width: 25%">Amount</th>
						                <th style="width: 10%">Edit</th>
						                <th style="width: 10%">Delete</th>
					            	</tr>
					            </thead>
					            <tbody>
								
									<?php
										$MySearchQuery = "SELECT * FROM chemicals ORDER BY Chemical_Id;";
										$MyValues = $MyConnection -> query($MySearchQuery);
										if (($MyValues -> num_rows) > 0)
										{
											while ($MyResults = $MyValues -> fetch_assoc())
											{
												echo '<tr>';
												echo '<td>'.$MyResults['Chemical_Id'].'</td>';
												echo '<td>'.$MyResults['Name'].'</td>';
												echo '<td>'.$MyResults['Quantity_Available'].'</td>';
											
												echo '<td>
												<form method="POST" action = "edit_chemical_item.php">
												<input type="hidden" class="hide" placeholder="'.$MyResults['Chemical_Id'].'" value="'.$MyResults['Chemical_Id'].'" name="Chemical_Id" readonly>
												<button type="submit" class="button button5"><i class="fa fa-pencil fa-fw" ></i></button>
												</form>
												</td>';
												
												
												echo '<td>
												<form method="POST" action = "delete_chemical_item.php">
												<input type="hidden" class="hide" placeholder="'.$MyResults['Chemical_Id'].'" value="'.$MyResults['Chemical_Id'].'" name="Chemical_Id" readonly>
												<button type="submit" class="button button5" ><i class="fa fa-trash fa-fw"></i></button> 
												</form>
												</td>
												</tr>';
												//ADD DELETE CONFIRMATION
	
											}
										}
									?>
					        	</tbody>
					        </table>
					    </div>
					</div>
				</div>
			</div>
	</div>

	<div id="Equipments" class="tabcontent">
		<!--table for equipments only*/-->
		<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Equipments</em></h1>
	    	<div>
	    		<div class="container">
			    	<div class="row">
			        	<div class="col-md-12 table-responsive">
			          		<table width="100%" class="table table-hover">
			          			<thead class="text-center">
					            	<tr>
						                <th style="width: 13%">ID</th>
						                <th style="width: 42%">Name</th>
						                <th style="width: 25%">Amount</th>
						                <th style="width: 10%">Edit</th>
						                <th style="width: 10%">Delete</th>
					            	</tr>
					            </thead>
					            <tbody>
								
									<?php
										$MySearchQuery = "SELECT * FROM glasswares ORDER BY Glassware_Id;";
										$MyValues = $MyConnection -> query($MySearchQuery);
										if (($MyValues -> num_rows) > 0)
										{
											while ($MyResults = $MyValues -> fetch_assoc())
											{
												echo '<tr>';
												echo '<td>'.$MyResults['Glassware_Id'].'</td>';
												echo '<td>'.$MyResults['Name'].'</td>';
												echo '<td>'.$MyResults['Quantity_Available'].'</td>';
											
												echo '<td>
												<form method="POST" action = "edit_glassware_item.php">
												<input type="hidden" class="hide" placeholder="'.$MyResults['Glassware_Id'].'" value="'.$MyResults['Glassware_Id'].'" name="Glassware_Id" readonly>
												<button type="submit" class="button button5"><i class="fa fa-pencil fa-fw" ></i></button>
												</form>
												</td>';
												
												
												echo '<td>
												<form method="POST" action = "delete_glassware_item.php">
												<input type="hidden" class="hide" placeholder="'.$MyResults['Glassware_Id'].'" value="'.$MyResults['Glassware_Id'].'" name="Glassware_Id" readonly>
												<button type="submit" class="button button5" ><i class="fa fa-trash fa-fw"></i></button> 
												</form>
												</td>
												</tr>';
												//ADD DELETE CONFIRMATION
	
											}
										}
									?>
					        	</tbody>
					        </table>
					    </div>
					</div>
				</div>
			</div>
	</div>
	
</div>

	<script>
	function openTab(evt, tabName) {
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		document.getElementById(tabName).style.display = "block";
		evt.currentTarget.className += " active";
	}
	</script>
</body>
</html>
