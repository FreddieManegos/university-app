<?php 
include("includes/header.php");
include("includes/classess/Course.php");
include("includes/classess/User.php");

function postgres_to_php_array($postgresArray){

	$postgresStr = trim($postgresArray,"{}");
	$elmts = explode(",",$postgresStr);
	return $elmts;
}

$state = "";
$data = pg_query($db, "SELECT * FROM course WHERE code = '".$_REQUEST['code']."'");
$row = pg_fetch_array($data);
?>

<div class = "main_column column" id = "course">

	<div class = "courseInfo"> 
		<?php 
		$course_code = $_REQUEST['code'];
		echo "Code: ".$course_code;
		echo "<br>Description: ".$row['description'];
		echo "<br>Section: ".$row['section'];
		echo "<br>Room:".$row['roomNo'];
		echo "<br> ".$row['startTime']."-";
		echo $row['endTime']."  ". $row['days']."<br>";		
		echo "Sensei: ".$row['adviser']."<br>";
		$course_student_mod = new User($db,$userLoggedIn);
		$course_update = new Course($db, $course_code);
		echo "<form action='course.php?code=$course_code' method='POST'>";
		if($course_student_mod->isJoined($_REQUEST['code'])){
			echo '<input type="submit" name="Unjoined" class="danger" value="Leave"><br>';
		}	
		else{
			echo '<input type="submit" name="Join" class="success" value="Join"><br>';
		}
		echo "</form>";
		if(isset($_POST['Join'])){
			$course_student_mod->joinCourse($_REQUEST['code']);
			$course_update->addStudent($course_student_mod->getUsername());
			header("Location: course.php?code=$course_code ");
		} 

		if(isset($_POST['Unjoined'])){
			$course_student_mod->removeCourse($_REQUEST['code']);
			$course_update->removeStudent($course_student_mod->getUsername());
			header("Location: course.php?code=$course_code ");
		}
		?>
	</div>	
	
	<div class="persons">
		<div id= "adviser">
			<a href=""> <img src="<?php echo $row['adviserPicture'];?>"></a> 
			<p style="text-align:center"><?php  echo "<br>".$row['adviser'];?></p>
			<br>	
		</div>
		<div id= "students">
			<p style="text-align:center"><strong>Students Joined</strong></p>
			<?php  
			$datas = pg_query($db, "SELECT students_array FROM course WHERE code='$course_code'");
			$rows = pg_fetch_array($datas);
			$studentsA = $rows['students_array'];
			echo "<p style='text-align:center'>";
			foreach (postgres_to_php_array($studentsA) as $value) {
				echo "<a href='profile.php?profile_username=$value'>".$value."</a><br>";
			}
			echo "</p>";
			?>
		</div>
	</div>
	<div class="announcements">
		<p style="text-align:center">Announcements</p>
	</div>
	<!-- <div class="discussion"></div> -->
	<div class="ratings">
		<p style="text-align:center">Ratings</p>
	</div>

</div>


</div>

</body>
</html> 