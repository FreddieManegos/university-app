<?php 
include("includes/header.php");
include("includes/classess/User.php");

function postgres_to_php_array($postgresArray){

	$postgresStr = trim($postgresArray,"{}");
	$elmts = explode(",",$postgresStr);
	return $elmts;
}
?>

<div class = "wrapper"> 
	<div class="user_details column" id="profiled"> 
		<a href="<?php echo $userLoggedIn; ?>" id= "profile"> <img src="<?php echo $user['profile_pic']; ?>"></a>
		<br>
		<a href="<?php echo $userLoggedIn; ?>">
		<br>
		<p style="text-align:center"><strong><?php echo $user['first_name'] . " " . $user['last_name']. "<br> <br>";?></strong></p>
	</a>
		<?php 
		echo "<p style='text-align:center'><strong>Courses</strong></p>";
		$datas = pg_query($db, "SELECT course_array FROM users WHERE username='$userLoggedIn'");
		$rows = pg_fetch_array($datas);
		$courses = $rows['course_array'];
		echo "<p style='text-align:center'>";
		foreach (postgres_to_php_array($courses) as $value) {
			echo "<a href='course.php?code=$value'>".$value."</a><br>";
		}
		echo "</p>";
		?>	
	</div>
	<div class="main_column column">
<!-- 		<form class="post_form" action="index.php" method="POST">
			<textarea name = "post_text" placeholder="Got something to say"></textarea>
			<input type="submit" id="post_button" value="POST">
			<br>
		</form> -->

		<?php 
		$user_obj = new User($db, $userLoggedIn);
		echo $user_obj->getFirstandLastName();
		echo "<br><br> All Courses in db <br>";
		$str = "<br>";
		$strs = "<br>";
		$data = pg_query($db, "SELECT * FROM course");
		while($row = pg_fetch_array($data)){
			$code = $row['code'];
			$str .= "<a href ='course.php?code=$code'>$code</a><br>";
		}
		echo $str;
		$datas = pg_query($db, "SELECT * FROM users ORDER BY username");
		while($row = pg_fetch_array($datas)){
			$code = $row['username'];
			echo '<img src="$row["profile_pic"]" >';
			$strs .= "<a href ='profile.php?profile_username=$code'>$code</a><br>";
		}
		echo $strs;

		?>

	</div>

	
</div>
</body>
</hmtl> 