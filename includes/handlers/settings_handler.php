<?php 
if(isset($_POST['update_details'])) {
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];

	$email_check = pg_query($db, "SELECT * FROM users WHERE email='$email'");
	$row = pg_fetch_array($email_check);
	$matched_user = $row['username'];

	if($matched_user == "" || $matched_user == $userLoggedIn) {
		$message = "Details updated!<br><br>";
		$query = pg_query($db,"UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email' WHERE username= '$userLoggedIn'");

	}else {
		$message = "That email is already in use!<br><br>";
	}
		header("Location: settings.php");
}
else {
	$message = "";
}


if(isset($_POST['update_pass'])) {
	$old_pass = strip_tags($_POST['old_pass']);
	$new_pass = strip_tags($_POST['new_pass']);
	$new2_pass = strip_tags($_POST['new2_pass']);

	$password_query = pg_query($db. "SELECT password FROM users WHERE username='$userLoggedIn'");
	$row = pg_fetch_array($password_query);
	$db_pass = $row['password'];

	if(md5($old_pass) == $db_pass) {
		if($new_pass==$new2_pass) {
			if(strlen($new_pass) <= 4) {
				$pass_message = "Sorry, your password must be greater than 4 characters<br><br>";
			} else {
				$new_pass_md5 = md5($new_pass);
				$password_query - pg_query($db, "UPDATE users SET password= '$new_pass_md5' WHERE username='$userLoggedIn");
				$pass_message = "Password has been changed!<br><br> ";
			}
		} else {
			$pass_message = "Your two new passwords need to match! <br><br> ";
		}
	}else {
		$pass_message = "The old password is incorrect <br><br>	";
	}
}

 ?>