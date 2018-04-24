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
<h1 class="jumbotron-fluid py-4 text-center" style="font-size: 50px"><em>Chemicals</em></h1>
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

<script>
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
</script>