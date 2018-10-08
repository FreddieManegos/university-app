
<?php 
include("dbconnect.php");
//The following 
	$username = ""; //studentID
	$fname = ""; // first name
	$lname = ""; // last name
 	$email = ""; //email
	$email2 = "";  //confirm email
	$password = "";  //password
	$password2 = ""; //confirm password
	$friends_array = ",";
	$course_array = ",";
	$user_type = "";
	$error_array = array(); // Stores the error messages


	if(isset($_POST['reg_button'])){
		$user_type = pg_escape_string($_POST['reg_user']);
		$username = pg_escape_string($_POST['reg_username']);
		$_SESSION['reg_username'] = $username;

		$fname = strip_tags(pg_escape_string($_POST['reg_fname']));
		$fname = str_replace(' ', '', $fname);
		$fname = ucfirst(strtolower($fname));
		$_SESSION['reg_fname'] = $fname;

		//last name
		$lname = strip_tags(pg_escape_string($_POST['reg_lname']));
		$lname = str_replace(' ', '', $lname);
		$lname = ucfirst(strtolower($lname));
		$_SESSION['reg_lname'] = $lname;

		//email
		$email = strip_tags(pg_escape_string($_POST['reg_email']));
		$email= str_replace(' ', '', $email);
		$email = ucfirst(strtolower($email));
		$_SESSION['reg_email'] = $email;

		//confirm email
		$email2 = strip_tags(pg_escape_string($_POST['reg_email2']));
		$email2= str_replace(' ', '', $email2);
		$email2 = ucfirst(strtolower($email2));
		$_SESSION['reg_email2'] = $email2;

		//Password
		$password = strip_tags($_POST['reg_password']);
		$password2 = strip_tags($_POST['reg_password2']);
		
		$date = date('Y-m-d');

		if($email === $email2){
			//Check if the email is in the valid format e.g. name@yahoo.com
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){

				$email = filter_var($email, FILTER_VALIDATE_EMAIL);
				$e_check = pg_query($db, "SELECT email FROM users WHERE email='$email'");
				$num_rows = pg_num_rows($e_check);
				if($num_rows > 0){
					echo "Email already uses";
				} 
			}else{
				array_push($error_array, "Invalid email format <br>");
			}
		}
		else
			array_push($error_array, "Emails don't match <br>");

		if(strlen($fname) > 25 || strlen($fname) < 2) {
			array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
		}

		if(strlen($lname) > 25 || strlen($lname) < 2) {
			array_push($error_array,  "Your last name must be between 2 and 25 characters<br>");
		}

		if($password != $password2) {
			array_push($error_array,  "Your passwords do not match<br>");
		}
		else {
			if(preg_match('/[^A-Za-z0-9]/', $password)) {
				array_push($error_array, "Your password can only contain english characters or numbers<br>");
			}
		}

		if(strlen($password > 30 || strlen($password) < 5)) {
			array_push($error_array, "Your password must be betwen 5 and 30 characters<br>");
		}

		if(empty($error_array)) {
			$password = md5($password);

			// $username = strtolower($fname."_". $lname);

			// $check_user_query = pg_query($db, "SELECT username FROM users WHERE username = $username");

			// $i = 0;
			// while(pg_num_rows($check_user_query) != 0){
			// 	$i++;
			// 	$username = $username ."_". $i;
			// 	$check_user_query = pg_query($db, "SELECT username FROM users WHERE username = $username");
			// }
			$rand = rand(1,2);
			if($rand == 1)
				$profile_pic = "assets/Images/profile_pics/defaults/head_belize_hole.png";
			else
				$profile_pic = "assets/Images/profile_pics/defaults/head_red.png";

			$query = pg_query($db, "INSERT INTO users( users, username, first_name,last_name, email, password, sigup_date, profile_pic, user_closed) VALUES ('$user_type','$username','$fname','$lname','$email','$password',CURRENT_DATE,'$profile_pic','no')");
			if($query){
			array_push($error_array, "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>");

			$_SESSION['reg_username'] = "";
			$_SESSION['reg_fname'] = "";
			$_SESSION['reg_lname'] = "";
			$_SESSION['reg_email'] = "";
			$_SESSION['reg_email2'] = "";
			}
	}
}	
		
	?>