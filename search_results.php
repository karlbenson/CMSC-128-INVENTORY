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
	
	$SearchFilter = $_GET['search_Filter'];
	$MySearchRequest = $_GET['search_Query'];

	echo '<table class="table table-sm table-striped table-hover" id="table_id">';
	if($SearchFilter == 0 && $MySearchRequest != "")
	{
		$MySearchQuery = "SELECT * FROM chemicals WHERE (chemicals.Name LIKE '%$MySearchRequest%') OR (chemicals.Chemical_Id LIKE '%$MySearchRequest%');";
		$MyValues = $MyConnection -> query($MySearchQuery);

		if (($MyValues -> num_rows) > 0)
		{
			echo
			"
			<thead class=text-center>  	
			<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Amount (mg)</th>
			<th>Amount (ml)</th>
			<th>Edit</th>
			<th>Delete</th>
			</tr>
			</thead>
			";
			while ($MyResults = $MyValues -> fetch_assoc())
			{
				echo '<tr>';

				echo '<td>'.$MyResults['Chemical_Id'].'</td>';
				echo '<td>'.$MyResults['Name'].'</td>';
				echo '<td>'.$MyResults['Quantity_Available_mg'].'</td>';
				echo '<td>'.$MyResults['Quantity_Available_ml'].'</td>';

				echo '<td><button type="submit" class="button button5"';
				echo 'onclick = "editFunction('.$MyResults['Chemical_Id'].', &quot;CHEMICAL&quot;)"';
				echo '><i class="fas fa-pencil-alt"></i></button></td>';

				echo '<td><button type="submit" class="button button5"';
				echo 'onclick = "deleteFunction('.$MyResults['Chemical_Id'].', &quot;CHEMICAL&quot;)"';
				echo'><i class="fas fa-trash-alt"></i></button> </td>';

				echo '</tr>';
			}
			echo '</table>';
			echo '<div class = "text-center py-5"><a href="search.php"><button class="btn btn-primary text-center" style="cursor:pointer;"">BACK</button></a></div>';
		}

		else
		{
			echo '</table>';
			echo '<div class = "text-center py-0 jumbotron"><h1>Empty Search Results</h1></div>';
			echo '<div class = "text-center py-5"><a href="search.php"><button class="btn btn-primary text-center" style="cursor:pointer;"">BACK</button></a></div>';
		}
	}

	else if ($SearchFilter == 1 && $MySearchRequest != "")
	{
		$MySearchQuery = "SELECT * FROM glasswares WHERE (glasswares.Name LIKE '%$MySearchRequest%') OR (glasswares.Glassware_Id LIKE '%$MySearchRequest%');";
		$MyValues = $MyConnection -> query($MySearchQuery);

		if (($MyValues -> num_rows) > 0)
		{
			echo
			"
			<thead class=text-center>  	
			<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Amount</th>
			<th>Edit</th>
			<th>Delete</th>
			</tr>
			</thead>
			";
			while ($MyResults = $MyValues -> fetch_assoc())
			{
				echo '<tr>';

				echo '<td>'.$MyResults['Glassware_Id'].'</td>';
				echo '<td>'.$MyResults['Name'].'</td>';
				echo '<td>'.$MyResults['Quantity_Available'].'</td>';

				echo '<td><button type="submit" class="button button5"';
				echo 'onclick = "editFunction('.$MyResults['Glassware_Id'].', &quot;GLASS&quot;)"';
				echo '><i class="fas fa-pencil-alt"></i></button></td>';

				echo '<td><button type="submit" class="button button5"';
				echo 'onclick = "deleteFunction('.$MyResults['Glassware_Id'].', &quot;GLASS&quot;)"';
				echo'><i class="fas fa-trash-alt"></i></button> </td>';

				echo '</tr>';
									//ADD DELETE CONFIRMATION
			}
			echo '</table>';
			echo '<div class = "text-center py-5"><a href="search.php"><button class="btn btn-primary text-center" style="cursor:pointer;"">BACK</button></a></div>';
		}

		else
		{
			echo '</table>';
			echo '<div class = "text-center py-0 jumbotron"><h1>Empty Search Results</h1></div>';
			echo '<div class = "text-center py-5"><a href="search.php"><button class="btn btn-primary text-center" style="cursor:pointer;"">BACK</button></a></div>';
		}
	}

	else if ($SearchFilter == 2 && $MySearchRequest != "")
	{
		$MySearchQuery = "SELECT * FROM borrower WHERE (borrower.First_Name LIKE '%$MySearchRequest%') OR (borrower.Borrower_Id LIKE '%$MySearchRequest%') or (borrower.Last_Name LIKE '%$MySearchRequest%') OR (borrower.Student_Number LIKE '%$MySearchRequest%');";
		$MyValues = $MyConnection -> query($MySearchQuery);

		if (($MyValues -> num_rows) > 0)
		{
			echo
			"
			<thead class=text-center>  	
			<tr>
			<th>ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Student Number</th>
			</tr>
			</thead>
			";
			while ($MyResults = $MyValues -> fetch_assoc())
			{
				echo '<tr>';
				echo '<td>'.$MyResults['Borrower_Id'].'</td>';
				echo '<td>'.$MyResults['First_Name'].'</td>';
				echo '<td>'.$MyResults['Last_Name'].'</td>';
				echo '<td>'.$MyResults['Student_Number'].'</td>';
			}
			echo '</table>';
			echo '<div class = "text-center py-5"><a href="search.php"><button class="btn btn-primary text-center" style="cursor:pointer;"">BACK</button></a></div>';
		}

		else
		{
			echo '</table>';
			echo '<div class = "text-center py-0 jumbotron"><h1>Empty Search Results</h1></div>';
			echo '<div class = "text-center py-5"><a href="search.php"><button class="btn btn-primary text-center" style="cursor:pointer;"">BACK</button></a></div>';
		}
	}

	else
	{
		echo '</table>';
		echo '<div class = "text-center py-0 jumbotron"><h1>Empty Search Results</h1></div>';
		echo '<div class = "text-center py-5"><a href="search.php"><button class="btn btn-primary text-center" style="cursor:pointer;"">BACK</button></a></div>';
	}

	echo '</div>';
?>