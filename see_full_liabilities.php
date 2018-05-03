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
			<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Liabilities</h1>
		</div>

		<div class="container" style="background-color: #edeef2; padding: 20px; margin-bottom: 50px; border-radius: 10px; border:2px solid #dbdbdb;">
			<div class="container" style="padding: 10px;">
			
			<div>
				<table class="table table table-striped table-hover" id="table_id">
					<thead class="text-center">
						<tr>
							<th>Student Number</th>
							<th>Last Name</th>
							<th>First Name</th>
							<th>No. of Transactions</th>
							<th class="text-center">Details</th>
						</tr>
					</thead>
					<tbody>
								<?php
										$MySearchQuery = "SELECT * FROM borrower WHERE Amt_of_transactions > 0 LIMIT 5";
										$MyValues = $MyConnection -> query($MySearchQuery);
										if (($MyValues -> num_rows) > 0)
										{
											while ($MyResults = $MyValues -> fetch_assoc()) //from transaction table
											{		
												echo "<tr>";
												echo '<td>'.$MyResults['Student_Number'].'</td>';
												echo '<td>'.$MyResults['Last_Name'].'</td>';
												echo '<td>'.$MyResults['First_Name'].'</td>';
												echo '<td>'.$MyResults['Amt_of_transactions'].' transaction/s</td>';
											
												$grp_id = $MyResults['Group_Id'];
												$b_id = $MyResults['Borrower_Id'];
												
												echo '
												

									          <!-- Modal -->
									          <div class="modal" id="myModal" role="dialog">
									            <div class="modal-dialog modal-dialog-centered" style="max-width: 1000px !important;">
									              <div class="modal-content" style="border-radius: 10px; padding: 20px;">
									              	<!-- Modal Header -->
									                <div class="modal-header" style="background-color: white; color: black;">
									                	<div class="row">
									                		<div class="col-sm-12">
									                			<h3><strong>'.$MyResults['First_Name'].' '.$MyResults['Last_Name'].'</strong> </h3>
									                		</div>
									                		<div class="w-100"></div>
									                		<div class="col-sm-12">
									                			<div>Student Number: '. $MyResults['Student_Number'].'</div>
									                		</div>
									                	</div>
									                	<button type="button" class="close_modal btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i></button>
									                    
									                </div>
									                <div class="modal-body">
									                	<p> </p>';

															//Fetch all unresolved transactions for this person
															$MySearchQuery2 = "SELECT * FROM transaction JOIN borrower USING (Group_Id) WHERE transaction.Group_Id = $grp_id AND transaction.Date_Returned IS NULL AND borrower.Borrower_Id = $b_id";
															$MyValues2 = $MyConnection -> query($MySearchQuery2);

															if (($MyValues2 -> num_rows) > 0){ //get all transactions where date returned is null
																while ($MyResults2 = $MyValues2 -> fetch_assoc() ) {

																	$gid = $MyResults2['Glassware_Id'];
																	$q = "SELECT Name FROM Glasswares  WHERE Glassware_Id=$gid";
																	$r = $MyConnection -> query($q);
																	$i = $r->fetch_assoc();
																	$g_name = $i['Name'];
																	
																	$t_id=$MyResults2['Trans_Id'];

																	//actual data here
																	echo '<div class="container">
																					<div class="row">';
																	echo '
																		<div class = "col-8">
																		<h2>'.$g_name.'</h2>
																	
																		<ul>
																			<li>Date Borrowed: '.$MyResults2['Date_Borrowed'].'
																			<li>Number of Pieces: '.$MyResults2['Qty_Borrowed_Glasswares'].'
																		</ul>
																		</div>
																		<div class = "col-4">
																		<form role="form" action = "clear_liability.php" method="POST">
																			<input class="hide" name="Group_Id" type="hidden" value="'.$grp_id.'" />
																			<input class="hide" name="Borrower_Id" type="hidden" value="'.$b_id.'" />
																			<input class="hide" name="Glassware_Id" type="hidden" value="'.$gid.'" />
																			<input class="hide" name="Trans_Id" type="hidden" value="'.$t_id.'" />
																			<input class="hide" name="Qty" type="hidden" value="'.$MyResults2['Qty_Borrowed_Glasswares'].'" />
																			
																			<input class="btn" style="cursor:pointer;margin:0 auto; float:right;" type="submit"  value="Clear Liability" Onclick="return confirm_clear()" >
																		</form>
																		</div>
																	';

																	echo '</div>
																		</div>
																		<p></p><p></p>';					
																}
															}
									                echo'  
									                </div>
									              </div>
									            </div>
									          </div>
									        </form>
									        </div>
												
												<td class="text-center">
													<!-- Button trigger modal -->
										          	<button type="button" class="openmodal btn btn-success" data-toggle="modal" data-target="#myModal" style="cursor: pointer; ">
										            	See Details
										          	</button>
												</td>';
												echo "</tr>";
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
		    { "orderable": false }
		]
	});

	//-------------Modal scripting
		var modals = document.getElementsByClassName('modal');
		var btns = document.getElementsByClassName("openmodal");
		var spans=document.getElementsByClassName("close_modal");

		for(let i=0;i<btns.length;i++){
   			 btns[i].onclick = function() {
        		modals[i].style.display = "block";
    		}
		}

		for(let i=0;i<spans.length;i++){
    		spans[i].onclick = function() {
        		modals[i].style.display = "none";
        		$('.modal').modal('hide');
    		}	
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
		    if (event.target == modal) {
		        modal.style.display = "none";
		    }
		}		
</script>