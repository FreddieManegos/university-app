<?php 
include("includes/header.php");
include("includes/classess/User.php");
include("includes/form-handlers/courseadd_handler.php");

function postgres_to_php_array($postgresArray){

	$postgresStr = trim($postgresArray,"{}");
	$elmts = explode(",",$postgresStr);
	return $elmts;
}

if(isset($_POST['AddCourse'])){
	header("Location: courseadd.php");
}
?>
<style type="text/css">
	.modal-body input[type=text]{
			width: 275px;
    		height: 31px;
    		border-radius: 7px;
    		border: solid 2px grey;
	}	
	.modal-body input[type=time]{
			width: 131px;
    		height: 31px;
    		border-radius: 7px;
   			 border: solid 2px grey;
	}
</style>

<div class = "wrapper"> 
	<div class="user_details column" id="profiled"> 
		<a href="<?php echo $userLoggedIn; ?>" id= "profile"> <img src="<?php echo $user['profile_pic']; ?>"></a>
		<br>
		<a href="<?php echo $userLoggedIn; ?>">
			<br>
			<p style="text-align:center"><strong><?php echo $user['first_name'] . " " . $user['last_name']. "<br> <br>";?></strong></p>
		</a>
		<?php 
		echo "<p style='text-align:center'><strong>Admin</strong></p>";
		// $datas = pg_query($db, "SELECT course_array FROM users WHERE username='$userLoggedIn'");
		// $rows = pg_fetch_array($datas);
		// $courses = $rows['course_array'];
		// echo "<p style='text-align:center'>";
		// foreach (postgres_to_php_array($courses) as $value) {
		// 	echo "<a href='course.php?code=$value'>".$value."</a><br>";
		// }
		// echo "</p>";
		?>
		<form action= "adminindex.php" method="post">
			<!-- Button trigger modal -->
			<button onclick="$('#yourModal').modal({'backdrop': 'static'});" type="button" class="success" data-toggle="modal" data-target="#exampleModal" style="text-align:center">
				Add Course
			</button>

		</form>
		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h1  style="text-align:center" class="modal-title" id="exampleModalLabel">AddCourse</h1>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="adminindex.php" method="POST" style="margin-left: 150px;
																			font-size: 14px;
																			font-family: Arial, Helvetica, Sans-serif;
																			">
							Course Code:<input type="text" name="add_code" style="margin-right : 150px;"><br><br>
							Description: <input type="text" name="add_desc" style="margin-right: 150px;"><br><br>
							Section: <input type="text" name="add_sec" style="margin-right: 150px;"><br><br>
							Time: <br><input type="time" name="add_start" > - <input type="time" name="add_end" > <br><br>
							Days: <input type="text" name="add_day" placeholder="e.g. MTh" style="margin-right: 150px;"> <br><br>
							RoomNo: <input type="text" name="add_roomNumber" style="margin-right: 150px;"> <br><br>	
							<input type="submit" name="add_submit" value="Add" class="success" style="margin-right: 150px;">
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
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