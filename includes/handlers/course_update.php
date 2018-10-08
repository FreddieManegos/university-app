<?php 
if(isset($_POST['update_details'])) {
	$code = $_POST['ed_code'];
	$desc = $_POST['ed_desc'];
	$sec = $_POST['ed_sec'];
	$rom = $_POST['ed_room'];
	$t1 = $_POST['ed_time'];
	$t2 = $_POST['ed_time2'];

	$email_check = pg_query($db, "SELECT * FROM course WHERE code='$code'");
	$row = pg_fetch_array($email_check);
	if(isset($code)){
		$query = pg_query($db,"UPDATE course SET code='$code', description='$description', section='$sec', starttime = '$t1' , endtime = '$t2',roomno = '$rom' WHERE code= '$code'");
	}
	header("Location: course.php?code=$code");
}
else {
	$message = "";
}


 ?>