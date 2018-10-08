<?php 
if (isset($_POST['add_submit'])) {
	if($_POST['add_code'] !=''){
	$code = $_POST['add_code'];
	$desc = $_POST['add_desc'];
	$section = $_POST['add_sec'];
	$startT = date('H:i:s',strtotime($_POST['add_start']));
	$endT = date('H:i:s',strtotime($_POST['add_end']));
	$days = $_POST['add_day'];
	$roomNo = $_POST['add_roomNumber'];

	$user_obj = new User($db, $userLoggedIn);
	$adviser = $user_obj->getFirstAndLastName();
	$adviser_profilePic = $user_obj->getProfilePic();

	$query = pg_query($db, "INSERT INTO course(code, description, section, starttime, endtime, days, roomNo, adviser, adviserpicture)VALUES ('$code','$desc','$section','$startT','$endT','$days','$roomNo','$adviser','$adviser_profilePic')");
	$course_adviser = new User($db, $userLoggedIn);
	$course_adviser->joinCourse($code);
	if(!$query )	
		echo 'failure';
}
}

 ?>