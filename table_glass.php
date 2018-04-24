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
?>

<script src="datatables/DataTables/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="datatables/DataTables/js/dataTables.bootstrap4.js"></script>
<link rel="stylesheet" href="datatables/DataTables/css/dataTables.bootstrap4.css">

<h1 class="jumbotron-fluid py-4 text-center" style="font-size: 50px"><em>Equipments</em></h1>
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

<script>
	
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
</script>