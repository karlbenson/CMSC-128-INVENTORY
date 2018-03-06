<!DOCTYPE html>
<html>
<head>
	<title>Master List: UPB Glasswares and Chemicals Inventory</title>
	<?php include("head.php"); ?>
	<link rel="stylesheet" href="css/master.css">
</head>
<body>
	<div id="container-fluid">
	<div class="edit">
		<button class="button button5">yes</button>
		<button class="button button5">no</button>
	</div>
	<div class="tab">
		
		<button class="tablinks" onclick="openTab(event, 'Chemicals')">Chemicals</button>
		<button class="tablinks" onclick="openTab(event, 'Equipments')">Equipments</button>
		<button class="tablinks" onclick="openTab(event, 'All')">All</button>
	</div>

	<div id="All" class="tabcontent">
		<!--table for both chemicals+equipments-->
		<div class="table-responsive">
			<table width="100%" class="table table-hover table-bordered">
				<thead>
					<tr>
					<th style="width: 18%">Quantity Available</th>
					<th style="width: 18%">Total Available</th>
					<th style="width: 64%">Name</th>
					</tr>
				</thead>
				<tbody>
				
				</tbody>
			</table>
		</div>
	</div>

	<div id="Chemicals" class="tabcontent">
		<!--table for chemicals only*/ -->
		<table width="100%" class="table table-hover table-bordered">
				<thead>
					<tr>
					<th style="width: 18%">Quantity Available</th>
					<th style="width: 18%">Total Available</th>
					<th style="width: 64%">Chemical Name</th>
					</tr>
				</thead>
				<tbody>
				
				</tbody>
			</table>
	</div>

	<div id="Equipments" class="tabcontent">
		<!--table for equipments only*/-->
		<table width="100%" class="table table-hover table-bordered">
				<thead>
					<tr>
					<th style="width: 18%">Quantity Available</th>
					<th style="width: 18%">Total Available</th>
					<th style="width: 64%">Equipment Name</th>
					</tr>
				</thead>
				<tbody>
				
				</tbody>
			</table>
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