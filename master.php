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
		<link rel="stylesheet" href="css/font-awesome.min.js">
		<link rel="stylesheet" href="datatables/DataTables/css/dataTables.bootstrap4.css">
		<script src="js/jquery.min.js"></script>
		<script src="datatables/DataTables/js/jquery.dataTables.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript" charset="utf8" src="datatables/DataTables/js/dataTables.bootstrap4.js"></script>
		<?php 'loading head';include("head.php"); ?>
	</head>
	<body>
		<div id="container-fluid">
			<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Master List</h1>
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
											<button class="btn btn-danger" type="submit" name="submit">Yes</button>
											</div>
											<div style="padding: 0px 80px 0px">
											<button class="btn btn-default" type="submit" name="submit" style="border: 1px solid #ccc" onclick="document.getElementById('id02').style.display='none'">No</button>
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
			<!--trigger the modal for add to inventory-->
			<div id="id01" class="w3-modal" style="z-index:9999;" onload="defAmt()">
				<div class="w3-modal-content w3-animate-bottom" style="border-radius: 10px; padding: 20px;">
					<header class="w3-container" style="text-align: center;"> 
						<button onclick="document.getElementById('id01').style.display='none'" 
						class="btn btn-danger"><i class="fas fa-times"></i></button>
						<h3 style="padding: 8px;"><strong>Add to Inventory</strong></h3>
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
									                <th class="align-middle text-center" style="width: 25%">Type</th>
									                <th class="align-middle text-center" style="width: 48%">Name</th>
									                <th class="align-middle text-center" style="width: 40%">Amount</th>
													<th class="align-middle text-center" style="width: 10%"><button type="button" name="add" class="button button5 add"><i class="fas fa-plus"></i></button></th>
								            	</tr>
							            	</thead>
							            	<tbody class="text-center">
								            	<tr>
													<td class="align-middle text-center" align="center">
														<select name="special[]" class="form-control" onchange="test(this.id, this.value)" id = "myType">
															<option value="chem">Add Chemical</option>
															<option value="glass">Add Equipment</option>
														</select>
													</td>
													<td class="align-middle text-center" align="center" align="center">
														<div class="col"><input class="form-control" name="name[]" placeholder="Name" required="required"></div>
													</td>
													<td class="align-middle text-center" align="center">
														<div class = "row align-content-center">
															<input class="form-control col-6" name="amount[]" placeholder="Amount" required="required" id="MyAmount">
															<select name = "unit[]" class="form-control col-6" id="ChemUnit">
																	<option value = "ml">ml</option>
																	<option value = "mg">mg</option>
															</select>
														</div>
													</td>
													<td align="center">
														<button type="button" name="remove" class="button button5 remove" id="remover" style="visibility: hidden;"><i class="fas fa-minus"></i></button>
													</td>
												</tr>
								        	</tbody>
								        </table>
								        <footer class="w3-container">
											<button class="btn btn-primary" type="submit" name="submit" value="Insert">Save</button>
										</footer>
										</form>
								    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
		<div class="container" style="background-color: #edeef2; padding: 20px; margin-bottom: 50px; border-radius: 10px;">
			<div class="tab">
				<button onclick="document.getElementById('id01').style.display='block'" class="tablinks btn btn-primary" style="float: left;"><i class="fas fa-plus" style="margin-right: 10px;"></i>Add to Inventory</button>
				<button class="tablinks btn btn-light" onclick="openTab(event, 'Chemicals')">Chemicals</button>
				<button class="tablinks btn btn-light" onclick="openTab(event, 'Equipments')">Equipment</button>
				<button class="tablinks btn btn-light" id="allbtn" onclick="openTab(event, 'All')">All</button>
			</div>
		
		<div id="All" class="tabcontent">
			<!--table for both chemicals+equipments-->
			<h1 class="jumbotron-fluid py-4 text-center" style="font-size: 50px"><em>Chemicals</h1>
		    	<div>
		    		<div class="container">
				    	<div class="row">
				        	<div class="col-md-12">
				          		<table class="table table-sm table-striped table-condensed table-hover" id="table_id">
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
													echo '<td class="align-middle text-center">'.$MyResults['Chemical_Id'].'</td>';
													echo '<td class="align-middle">'.$MyResults['Name'].'</td>';
													echo '<td class="align-middle">'.$MyResults['Quantity_Available_mg'].'</td>';
													echo '<td class="align-middle">'.$MyResults['Quantity_Available_ml'].'</td>';
													echo '<td>
													<button type="submit" class="button button5 onclick="editFunction()"><i class="fas fa-pencil-alt"></i></button>
													</td>';
												
												
													echo '<td>
													<button type="submit" class="button button5" onclick="deleteFunction()"><i class="fas fa-trash-alt"></i></button> 
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
				<h1 class="jumbotron-fluid py-4 text-center" style="font-size: 50px"><em>Equipment</em></h1>
		    	<div>
		    		<div class="container">
				    	<div class="row">
				        	<div class="col-md-12">
				          		<table class="table table-sm table-striped table-condensed table-hover" id="table_id2">
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
													echo '<td class="align-middle text-center">'.$MyResults['Glassware_Id'].'</td>';
													echo '<td class="align-middle">'.$MyResults['Name'].'</td>';
													echo '<td class="align-middle">'.$MyResults['Quantity_Available'].'</td>';
												
													echo '<td>
													<form method="POST" action = "edit_glassware_item.php">
													<input type="hidden" class="hide" placeholder="'.$MyResults['Glassware_Id'].'" value="'.$MyResults['Glassware_Id'].'" name="Glassware_Id" readonly>
													<button type="submit" class="button button5"><i class="fas fa-pencil-alt"></i></button>
													</form>
													</td>';
													
													
													echo '<td>
													<button type="submit" class="button button5" onclick="deleteFunction()"><i class="fas fa-trash-alt"></i></button> 
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
				          		<table class="table table-sm table-striped table-condensed table-hover" id="table_id3">
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
													echo '<td class="align-middle text-center">'.$MyResults['Chemical_Id'].'</td>';
													echo '<td class="align-middle">'.$MyResults['Name'].'</td>';
													echo '<td class="align-middle">'.$MyResults['Quantity_Available_mg'].'</td>';
													echo '<td class="align-middle">'.$MyResults['Quantity_Available_ml'].'</td>';
												
													echo '<td>
													<form method="POST" action = "edit_chemical_item.php">
													<input type="hidden" class="hide" placeholder="'.$MyResults['Chemical_Id'].'" value="'.$MyResults['Chemical_Id'].'" name="Chemical_Id" readonly>
													<button type="submit" class="button button5"><i class="fas fa-pencil-alt"></i></button>
													</form>
													</td>';
													
													
													echo '<td>
													<button type="submit" class="button button5" onclick="deleteFunction()"><i class="fas fa-trash-alt"></i></button> 
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
				          		<table class="table table-sm table-striped table-condensed table-hover" id="table_id4">
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
													echo '<td class="align-middle text-center">'.$MyResults['Glassware_Id'].'</td>';
													echo '<td class="align-middle">'.$MyResults['Name'].'</td>';
													echo '<td class="align-middle">'.$MyResults['Quantity_Available'].'</td>';
												
													echo '<td>
													<form method="POST" action = "edit_glassware_item.php">
													<input type="hidden" class="hide" placeholder="'.$MyResults['Glassware_Id'].'" value="'.$MyResults['Glassware_Id'].'" name="Glassware_Id" readonly>
													<button type="submit" class="button button5"><i class="fas fa-pencil-alt"></i></button>
													</form>
													</td>';
													
													
													echo '<td>
													<button type="submit" class="button button5" onclick="deleteFunction()"><i class="fas fa-trash-alt"></i></button> 
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
	</div>

		<script>
			function openTab(evt, tabName)
			{
				var i, tabcontent, tablinks;
				tabcontent = document.getElementsByClassName("tabcontent");

				for (i = 0; i < tabcontent.length; i++)
				{
					tabcontent[i].style.display = "none";
				}

				tablinks = document.getElementsByClassName("tablinks");

				for (i = 0; i < tablinks.length; i++)
				{
					tablinks[i].className = tablinks[i].className.replace(" active", "");
				}

				document.getElementById(tabName).style.display = "block";
				evt.currentTarget.className += " active";
			}
		
		
			function deleteFunction()
			{
				document.getElementById("id02").style.display = "block";
			}

			function deleteChem()
			{
				
			}

			function deleteGlass()
			{
				
			}
		
			$(document).ready(function()
			{

				$(document).on('click', '.add', function()
				{
					var html = '';
					html += '<tr>';
					html += '<td class="align-middle text-center" align="center"><select name="special[]" class="form-control" onchange="test(this.id, this.value)" id = "myType"><option value="chem">Add Chemical</option><option value="glass">Add Equipment</option></select></td>';
					html += '<td class="align-middle text-center" align="center" align="center"><div class="col"><input class="form-control" name="name[]" placeholder="Name" required="required"></div></td>';
					html += '<td class="align-middle text-center" align="center"><div class = "row align-content-center"><input class="form-control col-6" name="amount[]" placeholder="Amount" required="required" id="MyAmount"><select name = "unit[]" class="form-control col-6" id="ChemUnit"><option value = "ml">ml</option><option value = "mg">mg</option></select></div></td>';
					html += '<td align="center"><button type="button" name="remove" class="button button5 remove" id="remover"><i class="fas fa-minus"></i></button></td>';
					$('#item_table').append(html);

					$('#remover').css({
				        visibility: ''
				    });
				    $('#remover').first().css({
				        visibility: 'hidden'
				    });
					
					changeID();
				});

				$(document).on('click', '.remove', function()
				{
					$(this).closest('tr').remove();
				});
				
			});

			$('#insert_form').on('submit', function(event)
			{
				event.preventDefault();
				document.getElementById('id01').style.display='none';
				var form_data = $(this).serialize();

				$('#item_table').append(form_data); 
				$.ajax
				(
					{
					    url: "multiple_insert.php",
					    method: "POST",
					    data: form_data,
					    success: function(data)
					    {
				      		$('#item_table').find("tr:gt(0)").remove();
					      	$('#error').html('<div class="alert alert-success">Item Details Saved</div>');
					    }
				   	}
			   	);
			   	location.reload();
			});
		
			jQuery(function()
			{
			   jQuery('#allbtn').click();
			});

			$('#table_id').DataTable(
			{
					"columns":
					[
						null,
						null,
					    null,
					    null,
						
					    { "orderable": false },
					    { "orderable": false }
		  			]
			});

			$('#table_id2').DataTable(
			{
					"columns":
					[
						null,
						null,
					    null,
						
					    { "orderable": false },
					    { "orderable": false }
		  			]
			});

			$('#table_id3').DataTable(
			{
					"columns":
					[
						null,
						null,
					    null,
					    null,
						
					    { "orderable": false },
					    { "orderable": false }
		  			]
			});

			$('#table_id4').DataTable(
			{
					"columns":
					[
						null,
						null,
					    null,
						
					    { "orderable": false },
					    { "orderable": false }
		  			]
			});
			
			function changeID()
			{
				var i=0;
				$('[id*=ChemUnit]').each(function(){
				    i++;
				    var newID='ChemUnit_' + i;
				    $(this).attr('id',newID);
				});

				i = 0;
				$('[id*=MyAmount]').each(function(){
				    i++;
				    var newID='MyAmount_' + i;
				    $(this).attr('id',newID);
				});

				i = 0;
				$('[id*=myType]').each(function(){
				    i++;
				    var newID='myType_' + i;
				    $(this).attr('id',newID);
				});
			}

			function test(name, value)
			{
				if (name == "myType")
				{
					if (value == "chem")
					{
						$("#ChemUnit").show();
						$("#MyAmount").removeClass().addClass('form-control col-6');
						$("#ChemUnit").removeClass().addClass('form-control col-6');
						$("#ChemUnit")[0].selectedIndex = 0;
					}

					else
					{
						$("#ChemUnit").hide();
						$("#MyAmount").removeClass().addClass('form-control');
						$("#ChemUnit").removeClass().addClass('form-control');
						$("ChemUnit")[0].selectedIndex = 0;
					}
				}

				else
				{
					var iD_Split = name.trim().split('_');
					var Count = iD_Split[1];
					
					//alert("#ChemUnit_" + Count.toString());

					if (value == "chem")
					{
						$('#ChemUnit_' + Count.toString()).show();
						$('#MyAmount_' + Count.toString()).removeClass().addClass('form-control col-6');
						$('#ChemUnit_' + Count.toString()).removeClass().addClass('form-control col-6');
						$('#ChemUnit_' + Count.toString())[0].selectedIndex = 0;
					}

					else
					{
						$('#ChemUnit_' + Count.toString()).hide();
						$('#MyAmount_' + Count.toString()).removeClass().addClass('form-control');
						$('#ChemUnit_' + Count.toString()).removeClass().addClass('form-control');
						$('#ChemUnit_' + Count.toString())[0].selectedIndex = 0;
					}
				}
			}
		</script>
	</body>
</html>