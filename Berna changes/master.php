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
	
	//include("verify.php");

	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Master List: UPB Glasswares and Chemicals Inventory</title>
	<link rel="stylesheet" href="css/master.css">
	<link rel="stylesheet" href="css/modal.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<?php 'loading head';include("head.php"); ?>
</head>
<body>
	<div id="container-fluid">
	
	<div class="tab">
		<button onclick="document.getElementById('id01').style.display='block'" class="tablinks">Add to Inventory</button>
		<button class="tablinks" onclick="openTab(event, 'Chemicals')">Chemicals</button>
		<button class="tablinks" onclick="openTab(event, 'Equipments')">Equipments</button>
		<button class="tablinks" onclick="openTab(event, 'All')">All</button>
		
	<!--trigger the modal for add to inventory-->
	<div id="id01" class="w3-modal">
		<div class="w3-modal-content">
		<header class="w3-container" style="text-align: center;"> 
			<span onclick="document.getElementById('id01').style.display='none'" 
			class="w3-button w3-display-topright">&times;</span>
			<h3><strong>Add to Inventory</strong></h3>
		</header>
		<div class="w3-container">
			<div class="content">
				<div class="container">
			    	<div class="row">
			        	<div class="col-md-12">
							<form method="post" id="insert_form">
			          		<table class="table table-fit" id="item_table">
			          			<thead class="text-center">
					            	<tr>
						                <th style="width: 23%">Type</th>
						                <th style="width: 48%">Name</th>
						                <th style="width: 19%">Amount</th>
										<th style="width: 10%"></th>
					            	</tr>
					            </thead>
					            <tbody>
								<tr>
						            <td>
										<select name="special" class="form-control" onchange="updateSpecial(this.value)">
											<option value="2">Add Chemical</option>
											<option value="3">Add Equipment</option>
										</select>
									</td>
						            <td>
										<div class="col">
											<input class="form-control" name="c_name" placeholder="Name">
										</div>
									</td>
						            <td>
										<div class="col">
											<input class="form-control" name="e_amount" placeholder="Amount">
										</div>
									</td>
									<td><button type="button" name="add" class="button button5 add"><i class="fas fa-plus"></i></button></td>
					            </tr>
					        	</tbody>
					        </table>
							</form>
					    </div>
					</div>
				</div>
			</div>
		</div>
		<footer class="w3-container">
			<button class="btnclose" type="submit" name="submit" value="Insert" onclick="document.getElementById('id01').style.display='none'">Save</button>
		</footer>
		</div>
	</div>
	</div>
	

	<div id="All" class="tabcontent">
		<!--table for both chemicals+equipments-->
		<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Chemicals</h1>
	    	<div>
	    		<div class="container">
			    	<div class="row">
			        	<div class="col-md-12">
			          		<table class="table">
			          			<thead class="text-center">
					            	<tr>
						                <th>ID</th>
						                <th>Name</th>
						                <th>Amount (mg)</th>
										 <th>Amount (ml)</th>
						                <th>Edit</th>
						                <th>Delete</th>
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
												echo '<td>'.$MyResults['Quantity_Available_mg'].'</td>';
												echo '<td>'.$MyResults['Quantity_Available_ml'].'</td>';
												echo '<td>
												<form method="POST" action = "edit_chemical_item.php">
												<input type="hidden" class="hide" placeholder="'.$MyResults['Chemical_Id'].'" value="'.$MyResults['Chemical_Id'].'" name="Chemical_Id" readonly>
												<button type="submit" class="button button5"><i class="fas fa-pencil-alt"></i></button>
												</form>
												</td>';
												
												
												echo '<td>
												<form method="POST" action = "delete_chemical_item.php">
												<input type="hidden" class="hide" placeholder="'.$MyResults['Chemical_Id'].'" value="'.$MyResults['Chemical_Id'].'" name="Chemical_Id" readonly>
												<button type="submit" class="button button5" ><i class="fas fa-trash-alt"></i></button> 
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
			<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Equipment</em></h1>
	    	<div>
	    		<div class="container">
			    	<div class="row">
			        	<div class="col-md-12">
			          		<table class="table">
			          			<thead class="text-center">
					            	<tr>
						                <th>ID</th>
						                <th>Name</th>
						                <th>Amount</th>
						                <th>Edit</th>
						                <th>Delete</th>
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
												<button type="submit" class="button button5"><i class="fas fa-pencil-alt"></i></button>
												</form>
												</td>';
												
												
												echo '<td>
												<form method="POST" action = "delete_glassware_item.php">
												<input type="hidden" class="hide" placeholder="'.$MyResults['Glassware_Id'].'" value="'.$MyResults['Glassware_Id'].'" name="Glassware_Id" readonly>
												<button type="submit" class="button button5" ><i class="fas fa-trash-alt"></i></button> 
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
			        	<div class="col-md-12">
			          		<table class="table">
			          			<thead class="text-center">
					            	<tr>
						                <th>ID</th>
						                <th>Name</th>
						                <th>Amount (mg)</th>
										<th>Amount (ml) </th>
						                <th>Edit</th>
						                <th>Delete</th>
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
												echo '<td>'.$MyResults['Quantity_Available_mg'].'</td>';
												echo '<td>'.$MyResults['Quantity_Available_ml'].'</td>';
											
												echo '<td>
												<form method="POST" action = "edit_chemical_item.php">
												<input type="hidden" class="hide" placeholder="'.$MyResults['Chemical_Id'].'" value="'.$MyResults['Chemical_Id'].'" name="Chemical_Id" readonly>
												<button type="submit" class="button button5"><i class="fas fa-pencil-alt"></i></button>
												</form>
												</td>';
												
												
												echo '<td>
												<form method="POST" action = "delete_chemical_item.php">
												<input type="hidden" class="hide" placeholder="'.$MyResults['Chemical_Id'].'" value="'.$MyResults['Chemical_Id'].'" name="Chemical_Id" readonly>
												<button type="submit" class="button button5" ><i class="fas fa-trash-alt"></i></button> 
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
		<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Equipment</em></h1>
	    	<div>
	    		<div class="container">
			    	<div class="row">
			        	<div class="col-md-12">
			          		<table class="table">
			          			<thead class="text-center">
					            	<tr>
						                <th>ID</th>
						                <th>Name</th>
						                <th>Amount</th>
						                <th>Edit</th>
						                <th>Delete</th>
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
												<button type="submit" class="button button5"><i class="fas fa-pencil-alt"></i></button>
												</form>
												</td>';
												
												
												echo '<td>
												<form method="POST" action = "delete_glassware_item.php">
												<input type="hidden" class="hide" placeholder="'.$MyResults['Glassware_Id'].'" value="'.$MyResults['Glassware_Id'].'" name="Glassware_Id" readonly>
												<button type="submit" class="button button5" ><i class="fas fa-trash-alt"></i></button> 
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

<script>
	$(document).ready(function(){
		$(document).on('click', '.add', function(){
			var html = '';
			html += '<tr>';
			html += '<td><select name="special" class="form-control" onchange="updateSpecial(this.value)"><option value="2">Add Chemical</option><option value="3">Add Equipment</option></select></td>';
			html += '<td><div class="col"><input class="form-control" name="c_name" placeholder="Name"></div></td>';
			html += '<td><div class="col"><input class="form-control" name="e_amount" placeholder="Amount"></div></td>';
			html += '<td><button type="button" name="remove" class="button button5 remove"><i class="fas fa-minus"></i></button></td></tr>';
			$('#item_table').append(html)
		});
		
		$(document).on('click', '.remove', function(){
			$(this).closest('tr').remove();
		});
		
	});
</script>