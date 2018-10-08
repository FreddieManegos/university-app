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

		$_SESSION['username'] = $username;
		header("Location: index.php");
		exit();
	} 
}

?> 

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Student Portal 2.0</title> 
</head>
<body>
	<form action = "log_in.php" method = "POST">
		<input type="text" name="log_in_studentID" placeholder="StudentID" value= "<?php 
		if(isset($_SESSION['log_in_studentID'])){
			echo $_SESSION['log_in_studentID'];
		}?>"> <br>
		<input type="password" name="log_in_password" placeholder="Password"> <br>
		<input type="Submit" name="log_in_button" value="Login">
	</form>

</body>
</html>