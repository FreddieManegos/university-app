<?php 
include("../../dbconnect.php");
include("../classess/User.php");
include("../classess/Course.php");

$query = $_POST['query'];
$userLoggedIn = $_POST['userLoggedIn'];

$course = explode(" ",$query); 
$name = explode(" ", $query); 

error_reporting(0);
if(isset($query)) { 
	$usersReturnedQuery = pg_query($db, "SELECT * FROM course WHERE (code LIKE '$course[0]' OR code LIKE '%$course[1]%') LIMIT 8 ");
}

//error_reporting(0);
if($query != ""){
	while($row = pg_fetch_array($usersReturnedQuery)) {
		$user = new User($db, $userLoggedIn);
		echo "<div class='resultDisplay'>
		<a href=course.php?code=".$row['code'].">

		<div class='liveSearchProfilePic'>
			<img src='". $row['adviserpicture'] . "'>
		</div>

		<div class='liveSearchText'>
			".$row['code']."<br>".$row['description']."
		<p style='margin: 0;'>". $row['adviser'] . "</p>

		</div>
		</a>
		</div>		
		";
	}
// 	while ($row = pg_fetch_array($courseReturnedQuery)) {
// 		$course = new Course($db,$userLoggedIn); 
// 		echo "<div class= 'resultDisplay'>
// 		<a href='".$row['code']."' style='color: #1485BD'>";
// }
}
?>	

<!-- Button trigger modal -->

