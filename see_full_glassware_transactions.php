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
			<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Transaction History for Glassware</h1>
		</div>

		<div class="container" style="background-color: #edeef2; padding: 20px; margin-bottom: 50px; border-radius: 10px; border:2px solid #dbdbdb;">
			<div class="container" style="padding: 10px;">
			
			<div>
				<table class="table table table-striped table-hover" id="table_id">
					<thead class="text-center" >
					            	<tr>
						                <th>Glassware Borrowed</th>
										<th>Amount Borrowed</th>
										<th>Date Borrowed</th>
										<th>Date Returned</th>
						                <th>Borrowers</th>
						                <th>Professor</th>
										<th>Subject </th>
										
					            	</tr>
					            </thead>
					            <tbody >
								
									<?php
										$MySearchQuery = "SELECT * FROM transaction JOIN glasswares USING (Glassware_Id) ORDER BY transaction.Date_Returned LIMIT 5";
										$MyValues = $MyConnection -> query($MySearchQuery);
										if (($MyValues -> num_rows) > 0)
										{
											
											while ($MyResults = $MyValues -> fetch_assoc() ) //from transaction table
											{											
												echo '<tr>';
												echo '<td>'.$MyResults['Name'].'</td>';
												echo '<td>'.$MyResults['Qty_Borrowed_Glasswares'].'</td>';
												echo '<td>'.$MyResults['Date_Borrowed'].'</td>';
												if (is_null($MyResults['Date_Returned'])){
													echo '<td>'.'NOT YET RETURNED'.'</td>';
												}else{
													echo '<td>'.$MyResults['Date_Returned'].'</td>';
												}
												
												
												//get list of borrowers for this transaction
												$grp_id = $MyResults ['Group_Id'];
												$t_id = $MyResults['Trans_Id'];
											
												
												echo '<td>';
												$MySearchQuery2 = "SELECT * FROM borrower JOIN group_table USING (Group_Id) WHERE group_table.Group_Id = $grp_id";
												$MyValues2 = $MyConnection -> query($MySearchQuery2);
												while ($MyResults2 = $MyValues2 -> fetch_assoc()) 
												{											
													echo $MyResults2['Last_Name'].', '.$MyResults2['First_Name'].'<br> ';	
												}
												echo '</td>';
												
												$MySearchQuery3 = "SELECT * FROM group_table JOIN transaction USING (Group_Id) WHERE transaction.Glassware_Id>0  AND transaction.Group_Id = $grp_id AND transaction.Trans_Id = $t_id";
												$MyValues3 = $MyConnection -> query($MySearchQuery3);
											
												while ($MyResults3 = $MyValues3 -> fetch_assoc()) //from group table
												{											
													echo '<td>'.$MyResults3['Professor'].'</td>';
													echo '<td>'.$MyResults3['Subject'].'</td>';
													
												}
												
												echo '</tr>';
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
	
	</body>
	<?php include("footer.php")  ?>
</html>

<script>
		

		$('#table_id').DataTable(
	{
		"columns":
		[
			null,
			null,
		    null,
		    null,
		    null,
		    null,
		    null
		]
	});		
</script>