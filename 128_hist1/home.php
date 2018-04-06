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
	<title>Home: UPB Glasswares and Chemicals Inventory</title>
	<link rel="stylesheet" type="text/css" href="css/home.css">
	<?php 'loading head';include("head.php"); ?>
	<script type="text/javascript" src="js/date_time.js"></script>
</head>
<body>

	<div class="container-fluid hbod">
		<div class="container-fluid row justify-content-center first-row">
			<div id="home-tops" class="col-lg-8"  >

				<!--
					LOOB NG LEFT BOX
				-->
				<div class="container-fluid" style="background-color: #014421;color:white;">

					<!-- Place columns here -->
					<div class="row" id="no-gutter" style="padding-top:0;padding-left:0;padding-right:0;">
						<div class="col-sm" style="background-color: #014421;color:white;">
							<h2> Glassware that are currently not in stock</h2>
      						<p>
      							<ul>
								<?php
									$MySearchQuery = "SELECT * FROM glasswares WHERE Quantity_Available = 0";
										$MyValues = $MyConnection -> query($MySearchQuery);
										if (($MyValues -> num_rows) > 0)
										{
											while ($MyResults = $MyValues -> fetch_assoc()) //from transaction table
											{											
												echo '<li>'.$MyResults['Name'];
												
											}
										}	
									?>	

</ul>
      						</p>
   						 </div>
    					<div class="col-sm" style="background-color: #014421;color:white;">
    						<h2> Chemicals with less than 30% of its original amount</h2>
      						<p >
							<ul>
								
									<?php
										$MySearchQuery = "SELECT * FROM chemicals WHERE Quantity_Available_ml < 0.3*(Original_Amt) OR Quantity_Available_mg < 0.3*(Original_Amt)";
										$MyValues = $MyConnection -> query($MySearchQuery);
										if (($MyValues -> num_rows) > 0)
										{
											while ($MyResults = $MyValues -> fetch_assoc()) //from transaction table
											{					
												echo '<li>'.$MyResults['Name'].' (';						
												if (is_null($MyResults['Quantity_Available_ml'])){
													echo $MyResults['Quantity_Available_mg'].' mg)';
												}else{
													echo $MyResults['Quantity_Available_ml'].' ml)';
												}
												
												
											}
										}	
									?>
							</ul>
</p>
    					</div>
   						 <div class="col-sm" style="background-color: #014421;color:white;">
   						 	<h2> Students with unfinished transactions</h2>
      						<p>
      							<ul>
								<?php
										$MySearchQuery = "SELECT * FROM borrower WHERE Amt_of_transactions > 0";
										$MyValues = $MyConnection -> query($MySearchQuery);
										if (($MyValues -> num_rows) > 0)
										{
											while ($MyResults = $MyValues -> fetch_assoc()) //from transaction table
											{											
												echo '<li>'.$MyResults['Last_Name'].', '.$MyResults['First_Name'].' ('.$MyResults['Amt_of_transactions'].')';
												
												
											}
										}	
									?>
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
										$MySearchQuery = "SELECT * FROM transaction JOIN glasswares USING (Glassware_Id) ORDER BY transaction.Date_Returned";
										$MyValues = $MyConnection -> query($MySearchQuery);
										if (($MyValues -> num_rows) > 0)
										{
											while ($MyResults = $MyValues -> fetch_assoc()) //from transaction table
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
										$MySearchQuery = "SELECT * FROM transaction JOIN chemicals USING (Chemical_Id) ORDER BY transaction.Date_Returned";
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
												
												$MySearchQuery3 = "SELECT * FROM group_table JOIN transaction USING (Group_Id) WHERE transaction.Chemical_Id>0  AND transaction.Group_Id = $grp_id AND transaction.Trans_Id = $t_id";
												$MyValues3 = $MyConnection -> query($MySearchQuery3);
											
												while ($MyResults3 = $MyValues3 -> fetch_assoc()) //from group table
												{											
													echo '<td>'.$MyResults3['Professor'].'</td>';
													echo '<td>'.$MyResults3['Subject'].'</td>';
													
												}//end while
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