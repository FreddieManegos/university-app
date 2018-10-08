<?php 
include("dbconnect.php");
include("includes/classess/User.php")

$query = $_POST['query'];
$userLoggedIn = $_POST['userLoggedIn'];

//The commented code are for the course ..

// $course = explode(" ",$query); 
$name = explode("", $query); 

// $courseReturnedQuery = pg_query("SELECT * FROM course WHERE code LIKE '$course[0]%' LIMIT 8");
// if($query != ""){
// 	while ($row = pg_fetch_array($courseReturnedQuery)) {
// 			//$course = new Course($db,$userLoggedIn); 
// 		echo "<div class= 'resultDisplay'>
// 		<a href='".$row['code']."' style='color: #1485BD'>";
// 	}
// } 

if(strpos($query, '_') !==  false){
	$usersReturnedQuery = pg_query($db, "SELECT * FROM users WHERE username LIKE '$query%' AND user_closed='no' LIMIT 8");
else if(count($name) == 2)
	$usersReturnedQuery = pg_query($db, "SELECT * FROM users WHERE username (first_name LIKE '$name[0]%' AND last_name LIKE '$name[1]%') AND user_closed = 'no' LIMIT 8 ");
else 
	$usersReturnedQuery = pg_query($db, "SELECT * FROM users WHERE username (first_name LIKE '$name[0]%' AND last_name LIKE '$name[1]%') AND user_closed = 'no' LIMIT 8 ");

if($query != ""){
	while($row = pg_fetch_array($usersReturned)) {

		$user = new User($db, $userLoggedIn);
		//if($user->isFriend($row['username'])) {
			echo "<div class='resultDisplay'>
					<a href=".$row['username']."' style='color: #000'>
						<div class='liveSearchProfilePic'>
							<img src='". $row['profile_pic'] . "'>
						</div>

						<div class='liveSearchText'>
							".$row['first_name'] . " " . $row['last_name']. "
							<p style='margin: 0;'>". $row['username'] . "</p>
						</div>
					</a>
				</div>";
		//	}

}

?>	