<?php 
include("dbconnect.php");
if(isset($_POST["log_in_button"])){
	$studentID = pg_escape_string($_POST['log_in_studentID']);
	$_SESSION['log_in_studendID'] = $studentID;

	$password = md5($_POST['log_in_password']);

	$check_db_query = pg_query($db,"SELECT * FROM users WHERE username = '$studentID' and password = '$password'");

	$check_login_query = pg_num_rows($check_db_query);

	if($check_login_query == 1) {
		$row = pg_fetch_array($check_db_query);
		$username = $row['username'] ;
		if($row['users'] == 'student'){
			$_SESSION['username'] = $username;
			header("Location: index.php");
			exit();
		} else if($row['users'] == 'admin') {
			$_SESSION['username'] = $username;
			header("Location: adminindex.php");
			exit();
		}
	} 
	else {
		array_push($error_array, "Email or password was incorrect<br>");
	}
}

?> 
