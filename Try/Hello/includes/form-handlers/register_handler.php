
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
	$college = "";
	$course = "";
	$year = "";
	$friends_array = ",";
	$course_array = ",";
	$error_array = array(); // Stores the error messages


	if(isset($_POST['reg_button'])){
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

		$college = pg_escape_string($_POST['reg_college']);
		$_SESSION['reg_college'] = $college;
		$course = pg_escape_string($_POST['reg_course']);
		$_SESSION['reg_course'] = $course;
		$year = pg_escape_string($_POST['reg_year']);
		$_SESSION['reg_year'] = $year;

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

			$query = pg_query($db, "INSERT INTO users(username, first_name,last_name, email, password, sigup_date, profile_pic, college, course, year, user_closed) VALUES ('$username','$fname','$lname','$email','$password',CURRENT_DATE,'$profile_pic','$college','$course','$year','no')");
			if(!$query){
				echo "Error";
			} else {
				echo "Success";
			}
		}
	}
	
	?>
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
	$college = "";
	$course = "";
	$year = "";
	$friends_array = ",";
	$course_array = ",";
	$error_array = array(); // Stores the error messages


	if(isset($_POST['reg_button'])){
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

		$college = pg_escape_string($_POST['reg_college']);
		$_SESSION['reg_college'] = $college;
		$course = pg_escape_string($_POST['reg_course']);
		$_SESSION['reg_course'] = $course;
		$year = pg_escape_string($_POST['reg_year']);
		$_SESSION['reg_year'] = $year;

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

			$query = pg_query($db, "INSERT INTO users(username, first_name,last_name, email, password, sigup_date, profile_pic, college, course, year, user_closed) VALUES ('$username','$fname','$lname','$email','$password',CURRENT_DATE,'$profile_pic','$college','$course','$year','no')");
			if(!$query){
				echo "Error";
			} else {
				echo "Success";
			}
		}
	}
	
	?>