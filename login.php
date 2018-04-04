<?php
	session_start();
?>

<!DOCTYPE html>


<html lang="en">
<head>
	<title>Log in: UPB Glasswares and Chemicals Inventory</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min2.css">
	<link href="css/global.css" rel="stylesheet">
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
	<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>	
</head>
<body>

<div class="container-fluid bg">
	<div class="container-fluid topmost">
		<div class="row">
		<a href="login.php"><img src="src/up.png" width="120px" style="padding-top: 1.5%;"class="center"></a>
		</div>
	</div>

	<div class="row">
	<h2 class="mid">University of The Philippines - Baguio</h2>
	<!--<h3 class="mid">University of the Philippines</h3>-->
	<h3 class="mid sec">College of Science <br/>Glasswares and Chemicals Inventory</h3>
	<div class="col-md-4 col-sm-4 col-xs-12"></div>
	<div class="col-md-4 col-sm-4 col-xs-12">
	<h3><!--LOG IN--></h3>
	<!--start of form-->
		<form class="form-container" method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<?php
			//put remember me code here
		?>
		<div class="form-group">
			<label for="exampleInputEmail1">USERNAME</label>
			<input type="text" name="username" class="form-control" id="exampleInputUsername1" placeholder="Username" required >
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">PASSWORD</label>
			<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required >
		</div>
		<div class="checkbox">
			<label>
				<input title="kapag nag-iisa~" type="checkbox" name="remember_me"> Remember me
			</label>
		</div>
		<button type="submit" class="btn btn-success btn-block"  name="Login">LOG IN</button>
		</form>
	<!--end of form-->
	</div>
	<!--start of form-->
	</div>
</div>
</body>

<?php


$username = $password = "";


				
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//validate form data to prevent XSS attacks
	$username = test_input($_POST["username"]);
	$password = test_input($_POST["password"]);
	
	

	$con = mysqli_connect('127.0.0.1','root','');
	$query = "SELECT * FROM user_accounts WHERE Username = '$username'";
	
	if (!$con){
		echo 'Not connected to server';
	}
	
	if (!mysqli_select_db($con,'chem_glasswares')){
		echo 'Database not selected';
	}
	$valid=false;
	if ($result=mysqli_query($con,$query)){
	// Fetch one and one row
		while ($row=mysqli_fetch_row($result)){
			$active_user = $row[0];
			$hashed_password=$row[3];
			$valid=true;
		}
	}//end if
	
	mysqli_free_result($result);
	//use bcrypt to hash passwords and verify
	if ($valid && password_verify($password, $hashed_password)){		
		//update user online status
		$query = "UPDATE user_accounts SET status = 1 WHERE Username = '$username'";
		mysqli_query($con,$query);
		
		$_SESSION['username']=$_POST['username'];
		
		
		mysqli_close($con);
		header("refresh:2;url=home.php");
	}else{
		//login failure
		echo '<script type="text/javascript"> alert("Incorrect Credentials.") </script>';
	}//end if
}//end if
	
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
