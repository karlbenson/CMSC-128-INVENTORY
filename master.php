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
			<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Master List</em></h1>

			<!-- Alert DIV -->
			<div>
				<div id = "error">
				</div>
			</div>

			<!-- CHEMICALS EDIT -->
			<div id="id03" class="w3-modal" style="z-index:9999;">
				<div class="w3-modal-content w3-animate-top" style="border-radius: 10px; padding: 20px;">
					<header class="w3-container" style="text-align: center;"> 
						<button  id = "CHEM_CLOSE_BTN" class="btn btn-danger"><i class="fas fa-times"></i></button>
						<h3 style="padding: 8px;"><strong>Edit Item</strong></h3>
					</header>
					<div class="w3-container">
						<div class="content">
							<div class="container">
						    	<div class="row">
						        	<div class="col-md-12">
						        		<form method="POST" id="CHEM_EDIT_FORM">
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
														<td class="align-middle text-center" align="center" id="CHEM_ID_EDIT">
															<!--echo yung id number-->
														</td>
														<td class="align-middle text-center" align="center" align="center" id = "CHEM_NAME_EDIT">
															
														</td>
														<td class="align-middle text-center" align="center" id = "CHEM_AMOUNT_EDIT">
															
														</td>
													</tr>
									        	</tbody>
							          		</table>
									        <footer class="w3-container">
												<div>
													<button class="btn btn-primary" type="submit" name="submit" value="Insert">EDIT</button>
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

			<!-- GLASSWARE EDIT -->
			<div id="id04" class="w3-modal" style="z-index:9999;">
				<div class="w3-modal-content w3-animate-top" style="border-radius: 10px; padding: 20px;">
					<header class="w3-container" style="text-align: center;"> 
						<button  id = "GLASS_CLOSE_BTN" class="btn btn-danger"><i class="fas fa-times"></i></button>
						<h3 style="padding: 8px;"><strong>Edit Item</strong></h3>
					</header>
					<div class="w3-container">
						<div class="content">
							<div class="container">
						    	<div class="row">
						        	<div class="col-md-12">
						        		<form method="POST" id="GLASS_EDIT_FORM">
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
														<td class="align-middle text-center" align="center" id="GLASS_ID_EDIT">
															<!--echo yung id number-->
														</td>
														<td class="align-middle text-center" align="center" align="center" id = "GLASS_NAME_EDIT">
															
														</td>
														<td class="align-middle text-center" align="center" id="GLASS_AMOUNT_EDIT">
															
														</td>
													</tr>
									        	</tbody>
							          		</table>
									        <footer class="w3-container">
												<div>
													<button class="btn btn-primary" type="submit">EDIT</button>
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

			<!-- DELETE -->
			<div id="id02" class="w3-modal" style="z-index:9999;">
				<div class="w3-modal-content w3-animate-top" style="border-radius: 10px; padding: 20px;">
					<header class="w3-container" style="text-align: center;"> 
						<button id = "DELETE_CLOSE_BUTTON" class="btn btn-danger"><i class="fas fa-times"></i></button>
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

			<!-- ADD TO INVENTORY -->
			<div id="id01" class="w3-modal" style="z-index:9999;">
				<div class="w3-modal-content w3-animate-top" style="border-radius: 10px; padding: 20px;">
					<header class="w3-container" style="text-align: center;"> 
						<button onclick="document.getElementById('id01').style.display='none'" class="btn btn-danger"><i class="fas fa-times"></i></button>
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
							            	<tbody class="text-center" id = "data_input">
								            	<tr>
													<td class="align-middle text-center" align="center">
														<select name="item_type[]" class="form-control" onchange="test(this.id, this.value)" id = "myType">
															<option value="chem" selected="selected">Add Chemical</option>
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
																	<option value = "ml" selected="selected">ml</option>
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
											<button class="btn btn-primary" type="submit" name="submit" value="Insert">SAVE</button>
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

		<div class="container" style="background-color: #edeef2; padding: 20px; margin-bottom: 50px; border-radius: 10px; border:2px solid #dbdbdb;">
			<div class="tab">
				<button onclick="document.getElementById('id01').style.display='block'" class="tablinks btn btn-primary" style="float: left;"><i class="fas fa-plus" style="margin-right: 10px;"></i>Add to Inventory</button>
				<button class="tablinks btn btn-light" onclick="openTab(event, 'Chemicals')">Chemicals</button>
				<button class="tablinks btn btn-light" onclick="openTab(event, 'Equipments')">Equipment</button>
				<button class="tablinks btn btn-light" id="allbtn" onclick="openTab(event, 'All')">All</button>
			</div>
		

			<div id="All" class="tabcontent">
				<!--table for both chemicals+equipments-->
				<?php include("table_all.php");?>
			</div>

			<div id="Chemicals" class="tabcontent">
				<!--table for chemicals only*/ -->
				<?php include("table_chem.php");?>
			</div>

			<div id="Equipments" class="tabcontent">
				<!--table for equipments only*/-->
				<?php include("table_glass.php");?>
			</div>
		</div>
		<div id = "ARRAY_VALUES">
			
		</div>
	</body>

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
				tablinks[i].className = tablinks[i].className.replace("active", "");
			}

			document.getElementById(tabName).style.display = "block";
			evt.currentTarget.className += " active";
		}
		
		function editFunction(ID_VALUE, type)
		{
			if (type == "CHEMICAL")
			{
				var DIV_ID = "";
				DIV_ID += '<div class="col"><input style = "text-align: center;" readonly = "readonly" class="form-control" name="CHEM_ID_VALUE" value = "';
				DIV_ID += ID_VALUE;
				DIV_ID += '"></div>';
				$('#CHEM_ID_EDIT').html("");
				$('#CHEM_ID_EDIT').append(DIV_ID);
				document.getElementById('id03').style.display='block';

				$.ajax
				(
					{
						url: "get_item_array.php",
					    method: "POST",
					    data: {ID: ID_VALUE, TYPE: type},
					    success: function(result)
					    {
					    	var myArray = JSON.parse(result);

					      	var NAME_DIV = "";
							NAME_DIV += '<div class="col"><input required="required" class="form-control" name="name" placeholder="Name" value = "';
							NAME_DIV += myArray[1];
							NAME_DIV += '"></div>';

							$('#CHEM_NAME_EDIT').html("");
							$('#CHEM_NAME_EDIT').append(NAME_DIV);

							if (myArray[2] != null)
							{
								var AMOUNT_DIV = "";
								AMOUNT_DIV += '<div class = "row align-content-center"><input class="form-control col-6" name="amount" placeholder="Amount" required="required" value = "';
								AMOUNT_DIV += myArray[2];
								AMOUNT_DIV += '"><select name = "unit" class="form-control col-6"><option value = "ml" selected="selected">ml</option><option value = "mg">mg</option></select></div>';

								$('#CHEM_AMOUNT_EDIT').html("");
								$('#CHEM_AMOUNT_EDIT').append(AMOUNT_DIV);
							}

							else
							{
								var AMOUNT_DIV = "";
								AMOUNT_DIV += '<div class = "row align-content-center"><input class="form-control col-6" name="amount" placeholder="Amount" required="required" value = "';
								AMOUNT_DIV += myArray[3];
								AMOUNT_DIV += '"><select name = "unit" class="form-control col-6"><option value = "ml" >ml</option><option value = "mg" selected="selected">mg</option></select></div>';

								$('#CHEM_AMOUNT_EDIT').html("");
								$('#CHEM_AMOUNT_EDIT').append(AMOUNT_DIV);
							}
					    }
					}
				);
			}

			else
			{
				var DIV_ID = "";
				DIV_ID += '<div class="col"><input style = "text-align: center;" readonly = "readonly" class="form-control" name="GLASS_ID_VALUE" value = "';
				DIV_ID += ID_VALUE;
				DIV_ID += '"></div>';
				$('#GLASS_ID_EDIT').html("");
				$('#GLASS_ID_EDIT').append(DIV_ID);
				document.getElementById('id04').style.display='block';

				$.ajax
				(
					{
						url: "get_item_array.php",
					    method: "POST",
					    data: {ID: ID_VALUE, TYPE: type},
					    success: function(result)
					    {
					    	var myArray = JSON.parse(result);

					      	var NAME_DIV = "";
							NAME_DIV += '<div class="col"><input required="required" class="form-control" name="name" placeholder="Name" value = "';
							NAME_DIV += myArray[1];
							NAME_DIV += '"></div>';

							$('#GLASS_NAME_EDIT').html("");
							$('#GLASS_NAME_EDIT').append(NAME_DIV);

							
							var AMOUNT_DIV = "";
							AMOUNT_DIV += '<div class = "row align-content-center"><input class="form-control col" name="amount" placeholder="Amount" required="required" value = "';
							AMOUNT_DIV += myArray[2];
							AMOUNT_DIV += '"></div>';

							$('#GLASS_AMOUNT_EDIT').html("");
							$('#GLASS_AMOUNT_EDIT').append(AMOUNT_DIV);
					    }
					}
				);
			}
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

		$('#DELETE_CLOSE_BUTTON').on('click', function(event)
			{
				event.preventDefault();
				document.getElementById('id02').style.display='none';
				topFunction();
		      	$('#error').html('<div class="alert alert-danger"><strong>Delete Cancelled!</strong><button class="btn btn-sm btn-danger" onclick = "hideDiV(this.parentElement)"><i class="fas fa-times"></button></div>');
			}
		);

		$('#NO_ON_DELETE').on('click', function(event)
			{
				event.preventDefault();
				document.getElementById('id02').style.display='none';
				topFunction();
		      	$('#error').html('<div class="alert alert-danger"><strong>Delete Cancelled!</strong><button class="btn btn-sm btn-danger" onclick = "hideDiV(this.parentElement)"><i class="fas fa-times"></button></div>');
			}
		);

		$('#CHEM_CLOSE_BTN').on('click', function(event)
			{
				event.preventDefault();
				document.getElementById('id03').style.display='none';
				topFunction();
		      	$('#error').html('<div class="alert alert-danger"><strong>Edit Cancelled!</strong><button class="btn btn-sm btn-danger" onclick = "hideDiV(this.parentElement)"><i class="fas fa-times"></button></div>');
			}
		);

		$('#GLASS_CLOSE_BTN').on('click', function(event)
			{
				event.preventDefault();
				document.getElementById('id04').style.display='none';
				topFunction();
		      	$('#error').html('<div class="alert alert-danger"><strong>Edit Cancelled!</strong><button class="btn btn-sm btn-danger" onclick = "hideDiV(this.parentElement)"><i class="fas fa-times"></button></div>');
			}
		);

		$('#CHEM_EDIT_FORM').on('submit', function(event)
			{
				event.preventDefault();
				document.getElementById('id03').style.display='none';
				var form_data = $(this).serialize();

				$.ajax
				(
					{
					    url: "edit_chemical_item.php",
					    method: "POST",
					    data: form_data,
					    success: function(result)
					    {
					    	topFunction();
					      	$('#error').html('<div class="alert alert-success"><strong>Item Details Saved!</strong><button class="btn btn-sm btn-success" onclick = "hideDiV(this.parentElement)"><i class="fas fa-times"></button></div>');
					      	$('#All').load("table_all.php");
					      	$('#Chemicals').load("table_chem.php");
					      	$('#Equipments').load("table_glass.php");
					    }
				   	}
		   		);
		   	}
	 	);

	 	$('#GLASS_EDIT_FORM').on('submit', function(event)
			{
				event.preventDefault();
				document.getElementById('id04').style.display='none';
				var form_data = $(this).serialize();

				$.ajax
				(
					{
					    url: "edit_glassware_item.php",
					    method: "POST",
					    data: form_data,
					    success: function(result)
					    {
					    	topFunction();
					      	$('#error').html('<div class="alert alert-success"><strong>Item Details Saved!</strong><button class="btn btn-sm btn-success" onclick = "hideDiV(this.parentElement)"><i class="fas fa-times"></button></div>');
					      	$('#All').load("table_all.php");
					      	$('#Chemicals').load("table_chem.php");
					      	$('#Equipments').load("table_glass.php");
					    }
				   	}
		   		);
		   	}
	 	);

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
				      	$('#error').html('<div class="alert alert-success"><strong>Item Deleted!</strong><button class="btn btn-sm btn-success" onclick = "hideDiV(this.parentElement)"><i class="fas fa-times"></button></div>');
				      	$('#All').load("table_all.php");
				      	$('#Chemicals').load("table_chem.php");
				      	$('#Equipments').load("table_glass.php");
				    }
			   	}
		   	);
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
				      	$('#error').html('<div class="alert alert-success"><strong>Item Deleted!</strong><button class="btn btn-sm btn-success" onclick = "hideDiV(this.parentElement)"><i class="fas fa-times"></button></div>');
				      	$('#All').load("table_all.php");
				      	$('#Chemicals').load("table_chem.php");
				      	$('#Equipments').load("table_glass.php");
				    }
			   	}
		   	);
		}

		$(document).ready(function()
		{

			$(document).on('click', '.add', function()
			{
				var html = '';
				html += '<tr>';
				html += '<td class="align-middle text-center" align="center"><select name="item_type[]" class="form-control" onchange="test(this.id, this.value)" id = "myType"><option value="chem" selected="selected">Add Chemical</option><option value="glass">Add Equipment</option></select></td>';
				html += '<td class="align-middle text-center" align="center" align="center"><div class="col"><input class="form-control" name="name[]" placeholder="Name" required="required"></div></td>';
				html += '<td class="align-middle text-center" align="center"><div class = "row align-content-center"><input class="form-control col-6" name="amount[]" placeholder="Amount" required="required" id="MyAmount"><select name = "unit[]" class="form-control col-6" id="ChemUnit"><option value = "ml" selected="selected">ml</option><option value = "mg">mg</option></select></div></td>';
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

			$.ajax
			(
				{
				    url: "multiple_insert.php",
				    method: "POST",
				    data: form_data,
				    success: function()
				    {
			      		var html = '';
						html += '<tr>';
						html += '<td class="align-middle text-center" align="center"><select name="item_type[]" class="form-control" onchange="test(this.id, this.value)" id = "myType"><option value="chem" selected="selected">Add Chemical</option><option value="glass">Add Equipment</option></select></td>';
						html += '<td class="align-middle text-center" align="center" align="center"><div class="col"><input class="form-control" name="name[]" placeholder="Name" required="required"></div></td>';
						html += '<td class="align-middle text-center" align="center"><div class = "row align-content-center"><input class="form-control col-6" name="amount[]" placeholder="Amount" required="required" id="MyAmount"><select name = "unit[]" class="form-control col-6" id="ChemUnit"><option value = "ml" selected="selected">ml</option><option value = "mg">mg</option></select></div></td>';
						html += '<td align="center"><button type="button" name="remove" class="button button5 remove" id="remover" style="visibility: hidden;"><i class="fas fa-minus"></i></button></td>';

						
						$('#item_table').find("tr:gt(0)").remove();

						$('#data_input').innerHTML = '';

						$('#data_input').append(html);

				      	$('#error').html('<div class="alert alert-success"><strong>Item Details Saved!</strong><button class="btn btn-sm btn-success" onclick = "hideDiV(this.parentElement)"><i class="fas fa-times"></button></div>');
				      	$('#All').load("table_all.php");
				      	$('#Chemicals').load("table_chem.php");
				      	$('#Equipments').load("table_glass.php");
				    }
			   	}
		   	);
		});

		jQuery(function()
		{
		   jQuery('#allbtn').click();
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

		jQuery(function()
		{
		   jQuery('#allbtn').click();
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

		function hideDiV(input)
		{
			input.style.display = 'none';
		}
	</script>
</html>