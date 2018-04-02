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
	
	include("verify.php");
?>
<html>
<head>
	<title>Home: UPB Glasswares and Chemicals Inventory</title>
	<link rel="stylesheet" type="text/css" href="css/home.css">
	<?php 'loading head';include("head.php"); ?>
	<script type="text/javascript" src="js/date_time.js"></script>
</head>
<body>
	<div class="container-fluid hbod">
		<div class="container-fluid row justify-content-center first-row">
			<div id="home-tops" class="col-lg-8"  >
				
				<div class="card-columns" style="background-color: #014421;opacity:1;color:#f3aa2c;">
					<div class="card p-3" id = "card-format" >
						
						<div class="card-block" id = "card-format">
						  <h4 class="card-title">List of equipment that are not currently in stock</h4>
						  <p class="card-text">
							<ul>
								<li> 0 dapat yung quantity
							</ul>
						  </p>
						  <!-- Pag okay na yung search, redirect to searched items -->
							 <a href="search.php" class="btn btn-primary">See items</a>
						</div>
					</div>
					
					<div class="card p-3" id = "card-format">
						
						<div class="card-block" id = "card-format">
						  <h4 class="card-title">List of chemicals with low quantities</h4>
						  <p class="card-text">
							<ul>
								<li> Dapat less than smth %
							</ul>
						  </p>
						  <!-- Pag okay na yung search, redirect to searched items -->
							 <a href="search.php" class="btn btn-primary">See items</a>
						  
						</div>
						 
					</div>
					
					<div class="card p-3" id = "card-format" id = "card-format">
						<div class="card-block" id = "card-format">
						  <h4 class="card-title">Students with accountabilities</h4>
						  <p class="card-text">
							<ul>
								<li>Student 1
								<li>Student 2
								<li>Student 3
							</ul>
						  
						  </p>
						</div>
					</div>
			</div>		
				
				
			</div>
			
			<span style="width: 8%;"></span>
			<div class="col-lg-3 timestamp align-text-middle" id="home-tops">
			
			
				<h1><span id="date_time" style="color:white"></span></h1>
				<h1>
            		<script type="text/javascript">window.onload = date_time('date_time');</script>
				</h1>

				
					<ul style="color:white">
						<li> Last day of classes: May 18, 2018
						<li> Deadline of submission of chuva on:
					</ul>
				
			</div>
		</div>

		<div  >
		
			<div class="col-lg-12" style="background-color:white">
			
				<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Transaction History for Glassware</h1>
	    	
	    		<div class="container" style="background-color:white">
			          		<table class="table" style="background-color:white">
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
										$MySearchQuery = "SELECT * FROM transaction JOIN glasswares USING (Glassware_Id)";
										$MyValues = $MyConnection -> query($MySearchQuery);
										if (($MyValues -> num_rows) > 0)
										{
											while ($MyResults = $MyValues -> fetch_assoc()) //from transaction table
											{											
												echo '<tr>';
												echo '<td>'.$MyResults['Name'].'</td>';
												echo '<td>'.$MyResults['Qty_Borrowed_Glasswares'].'</td>';
												echo '<td>'.$MyResults['Date_Borrowed'].'</td>';
												echo '<td>'.$MyResults['Date_Returned'].'</td>';
												
												//get list of borrowers for this transaction
												$Glassware_Id=$MyResults['Glassware_Id'];
												$Group_Id = $MyResults ['Group_Id'];
												
												echo '<td>';
												$MySearchQuery2 = "SELECT * FROM borrower ";
												$MyValues2 = $MyConnection -> query($MySearchQuery2);
												while ($MyResults2 = $MyValues2 -> fetch_assoc()) 
												{											
													echo $MyResults2['Last_Name'].'<br> ';	
												}
												echo '</td>';
												
												$MySearchQuery3 = "SELECT * FROM group_table JOIN transaction USING (Group_Id) WHERE transaction.Glassware_Id>0";
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
				
				<h1 class="jumbotron-fluid text-center py-4" style="font-size: 50px"><em>Transaction History for Chemicals</h1>
				<div class="container" style="background-color:white">
			          		<table class="table" style="background-color:white">
			          			<thead class="text-center" >
					            	<tr>
						                <th>Chemical Requested</th>
										<th>Amount (mg)</th>
										<th>Amount (ml)</th>
						                <th>Date Requested</th>
										<th>Borrowers</th>
						                <th>Professor</th>
										<th>Subject </th>
										
					            	</tr>
					            </thead>
					            <tbody >
									<?php
										$MySearchQuery = "SELECT * FROM transaction JOIN chemicals USING (Chemical_Id)";
										$MyValues = $MyConnection -> query($MySearchQuery);
										if (($MyValues -> num_rows) > 0)
										{
											while ($MyResults = $MyValues -> fetch_assoc()) //from transaction table
											{											
												echo '<tr>';
												echo '<td>'.$MyResults['Name'].'</td>';
												echo '<td>'.$MyResults['Qty_Borrowed_Chemicals_mg'].'</td>';
												echo '<td>'.$MyResults['Qty_Borrowed_Chemicals_ml'].'</td>';
												echo '<td>'.$MyResults['Date_Borrowed'].'</td>';
												
												
												//get list of borrowers for this transaction
												$Glassware_Id=$MyResults['Glassware_Id'];
												$Group_Id = $MyResults ['Group_Id'];
												
												echo '<td>';
												$MySearchQuery2 = "SELECT * FROM borrower ";
												$MyValues2 = $MyConnection -> query($MySearchQuery2);
												while ($MyResults2 = $MyValues2 -> fetch_assoc()) 
												{											
													echo $MyResults2['Last_Name'].'<br> ';	
												}
												echo '</td>';
												
												$MySearchQuery3 = "SELECT * FROM group_table JOIN transaction USING (Group_Id) WHERE transaction.Glassware_Id>0 ";
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

	
</body>
</html>