<?php 
	include("../../dbconnect.php");
	include("../classess/Course.php");

	$query = $_POST['query'];
	$userLoggedIn = $_POST['userLoggedIn'];
	$course = explode(" ", $query);

	$queryReturned = pg_query($db, "SELECT * FROM course WHERE code LIKE '$course%' LIMIT 8");

	if($query != "") {
		while($row = pg_fetch_array($queryReturned)){
			echo "<div class='resultDisplay'>
				<div class='LiveSearchText'>
					<a href='course.page?code='".$row['code']."'>'".$row['code']."'</a>
				</div>
			</div>
			";
		}
	}
 ?>