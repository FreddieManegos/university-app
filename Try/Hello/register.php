<?php  
include('dbconnect.php');
include('includes/form-handlers/register_handler.php');
include( 'includes/form-handlers/login_handler.php');
?>


<html>
<head>
	<title>Welcome to MSUIIT Circle</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
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

		<div class="login_box">

			<div class="login_header">
				<h1>MSUIIT CIRCLE!</h1>
				Login or Sign Up
			</div>
			<br>
			<div id="first">

				<form action = "login.php" method = "POST">
					<input type="text" name="log_in_studentID" placeholder="StudentID" value= "<?php 
					if(isset($_SESSION['log_in_studentID'])){
						echo $_SESSION['log_in_studentID'];
					}?>"> <br>
					<input type="password" name="log_in_password" placeholder="Password"> <br>
					<?php if(in_array("Email or password was incorrect<br>", $error_array)) echo  "Email or password was incorrect<br>"; ?>
					<input type="Submit" name="log_in_button" value="Login"> <br>
					<a href="#" id="signup" class="signup">Need and account? Register here!</a>
				</form>
			</div>

			<div id="second">

				<form action='register.php' method='post'>
					<p style="font-size: 75%"><em>Recommended to set username from your name e.g. juan.cruz</em></p>
					<input type="text" name="reg_username" placeholder="Username " 
					value = "<?php if(isset($_SESSION['reg_username'])){
						echo $_SESSION['reg_username'];
					}
					?>" required>

					<input type="text" id="fname" name="reg_fname" placeholder="First Name" 
					value = "<?php if(isset($_SESSION['reg_fname'])){
						echo $_SESSION['reg_fname'];
					}
					?>"
					required> <br>
					<?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) echo "Your first name must be between 2 and 25 characters<br>"; ?>

					<input type="text" id="lname" name="reg_lname" placeholder="Last Name" 
					value = "<?php if(isset($_SESSION['reg_lname'])){
						echo $_SESSION['reg_lname'];
					}
					?>"
					required><br>
					<?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) echo "Your first name must be between 2 and 25 characters<br>"; ?>

					<input type="email" id="email" name="reg_email" placeholder="Email" 
					value = "<?php if(isset($_SESSION['reg_email'])){
						echo $_SESSION['reg_email'];
					}
					?>"
					required><br>

					<input type="email" id="email2" name="reg_email2" placeholder="Confirm Email" 
					value = "<?php if(isset($_SESSION['reg_email2'])){
						echo $_SESSION['reg_email2'];
					}
					?>"
					required autocomplete="off"><br>
					<?php if(in_array("Email already in use<br>", $error_array)) echo "Email already in use<br>"; 
					else if(in_array("Invalid email format<br>", $error_array)) echo "Invalid email format<br>";
					else if(in_array("Emails don't match<br>", $error_array)) echo "Emails don't match<br>"; ?>

					<input type="password"  id="password" name="reg_password" placeholder="Password" 
					required><br>

					<input type="password"  id="password2" name="reg_password2" placeholder="Confirm Password" required><br>
					<?php if(in_array("Your passwords do not match<br>", $error_array)) echo "Your passwords do not match<br>"; 
					else if(in_array("Your password can only contain english characters or numbers<br>", $error_array)) echo "Your password can only contain english characters or numbers<br>";
					else if(in_array("Your password must be betwen 5 and 30 characters<br>", $error_array)) echo "Your password must be betwen 5 and 30 characters<br>"; ?>

					<input type="text" id="student_id" name="reg_student_id" placeholder="StudentID number">
					<br>
					<input type="submit" name="reg_button" value="Register">
					<br>

					<?php if(in_array("<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>", $error_array)) echo "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>"; ?>
						<a href="#" id="signin" class="signin">Already have an account? Sign in here!</a>
					</form>
				</div>
			</div>
		</div>
	</body>
	</html>