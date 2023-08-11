<?php  

require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
?>

<?php

if(isset($_SESSION['username'])){
	header("Location: index.php");
}


if(isset($_COOKIE['thingonearth'])){
	$thecookie=$_COOKIE['thingonearth'];
$sqlthing = "SELECT username FROM users WHERE cookie='$thecookie'";
$resultthing = $con->query($sqlthing);
$theusernamething="";

if ($resultthing->num_rows > 0) {
  while($rowthing = $resultthing->fetch_assoc()) {
    $theusernamething=$rowthing['username'];
  }
}
		$_SESSION['username'] = $theusernamething;
		header("Location: index.php");
}


?>

<html>
<head>
	<title>DeepCrests</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
	<script src="assets/js/register.js"></script>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>


	
</head>
<body>

	<?php  

	if(isset($_POST['register_button'])) {
		echo '
		<script>

		$(document).ready(function() {
			$("#first").hide();
			$("#second").show();
		});

		</script>

		';
	}


	?>

	<div class="wrapper">


<div id="block1" style="background-color: #a189a9; width: 30%; float: left; height: 100%; border-end-end-radius: 400px">
<div id="block2" style="background-color: #713c85; width: 70%; float: left; height: 100%; border-end-end-radius: 400px">


<div id="block3" style="background-color: #4e1163; width: 70%; float: left; height: 100%;border-end-end-radius: 400px;">
	
</div>

	
</div>
</div>



		<div class="login_box">

			<div class="login_header">
				<h1>DeepCrests</h1>
				
			</div>
			<br>
			<div id="first">

				<form action="register.php" method="POST">
					<input id="emailenter" type="email" name="log_email" placeholder="Email Address" value="<?php 
					if(isset($_SESSION['log_email'])) {
						echo $_SESSION['log_email'];
					} 
					?>" required>
					<br>
					<input id="emailenter" type="password" name="log_password" placeholder="Password">
					<br>
					<?php if(in_array("Email or password was incorrect<br>", $error_array)) echo  "<span style='color: red;'>Email or password was incorrect</span><br>"; ?>

					<span id="rememberme">Remember me</span> <input type="checkbox" name="rememberme" value="remember">
					<br>
					<input id="loginsubmit" type="submit" name="login_button" value="Login">
					<br>
					<a href="#" id="signup" class="signup">Don't have an account? Click here</a>

				</form>

			</div>

			<div id="second">

				<form action="register.php" method="POST">
					<input id="emailenter" type="text" name="reg_fname" placeholder="First Name" value="<?php 
					if(isset($_SESSION['reg_fname'])) {
						echo $_SESSION['reg_fname'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) echo "<span style='color: red;'>Your first name must be between 2 and 25 characters</span><br>"; ?>
					
					


					<input id="emailenter" type="text" name="reg_lname" placeholder="Last Name" value="<?php 
					if(isset($_SESSION['reg_lname'])) {
						echo $_SESSION['reg_lname'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) echo "<span style='color: red;'>Your last name must be between 2 and 25 characters</span><br>"; ?>

					<input id="emailenter" type="email" name="reg_email" placeholder="Email" value="<?php 
					if(isset($_SESSION['reg_email'])) {
						echo $_SESSION['reg_email'];
					} 
					?>" required>
					<br>

					<input id="emailenter" type="email" name="reg_email2" placeholder="Confirm Email" value="<?php 
					if(isset($_SESSION['reg_email2'])) {
						echo $_SESSION['reg_email2'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Email already in use<br>", $error_array)) echo "<span style='color: white;'>Email already in use</span><br>"; 
					else if(in_array("Invalid email format<br>", $error_array)) echo "<span style='color: white;'>Invalid email format</span><br>";
					else if(in_array("Emails don't match<br>", $error_array)) echo "<span style='color: white;'>Emails don't match</span><br>"; ?>


					<input id="emailenter" type="password" name="reg_password" placeholder="Password" required>
					<br>
					<input id="emailenter" type="password" name="reg_password2" placeholder="Confirm Password" required>
					<br>
					<?php if(in_array("Your passwords do not match<br>", $error_array)) echo "<span style='color: red;'>Your passwords do not match</span><br>"; 
					else if(in_array("Your password can only contain english characters or numbers<br>", $error_array)) echo "<span style='color: red;'>Your password can only contain english characters or numbers</span><br>";
					else if(in_array("Your password must be between 6 and 30 characters<br>", $error_array)) echo "<span style='color: red;'>Your password must be betwen 6 and 30 characters</span><br>"; ?>


					<input id="loginsubmit" type="submit" name="register_button" value="Register">
					<br>

					<?php if(in_array("<span style='color: red;'>Registered successfully! Login to continue</span><br>", $error_array)) echo "<span style='color: white;'>Registered successfully! Login to continue</span><br>"; ?>
					<a href="#" id="signin" class="signin">Already have an account? Click here</a>
				</form>
			</div>

		</div>

	</div>


</body>
</html>