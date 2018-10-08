<?php 
include("includes/header.php");
include("includes/classess/Course.php");
include("includes/classess/User.php");
include("includes/classess/Discussion.php");
include("includes/classess/Announcement.php");
include("includes/classess/Review.php");
include("includes/handlers/course_update.php");

function postgres_to_php_array($postgresArray){

	$postgresStr = trim($postgresArray,"{}");
	$elmts = explode(",",$postgresStr);
	return $elmts;
}
 
if(isset($_POST['post'])){
	$post = new Discussion($db, $_REQUEST['code'],$userLoggedIn);
	$post->submitPost($_POST['post_text'], $_REQUEST['code']);
}

if(isset($_POST['review'])){
	$post = new Review($db, $_REQUEST['code'],$userLoggedIn);
	$post->submitReview($_POST['post-body'], $_REQUEST['code']);
}

if(isset($_POST['announce'])){
	$post = new Announcement($db, $_REQUEST['code'],$userLoggedIn);
	$post->submitAnnouncement($_POST['post-body'], $_REQUEST['code']);
}

$state = "";
$data = pg_query($db, "SELECT * FROM course WHERE code = '".$_REQUEST['code']."'");
$row = pg_fetch_array($data);
?>
	<?php  
	if(isset($_POST['post'])) {
		$link = '#discussion_tabs a[href="#discussion_div"]';
		 echo "<script> 
          $(function() {
              $('" . $link ."').tab('show');
          });
        </script>";
        }

	?>

<style type="text/css">
	*{
		font-size: 14px;
		font-family: Arial, Helvetica, Sans-serif;
	}
</style>

<div class = "course_wrapper" id = "course">

	<div class ="courseInfo" style="text-align: center;
									font-size: 15px;
									font-family: Arial, Helvetica, Sans-serif;
										"> 
		<?php 
		$course_code = $_REQUEST['code'];
		echo "Code: ".$course_code;
		echo "<br>Description: ".$row['description'];
		echo "<br>Section: ".$row['section'];
		echo "<br>Room:".$row['roomno'];
		echo "<br> ".$row['starttime']."-";
		echo $row['endtime']."  ". $row['days']."<br>";		
		echo "Sensei: ".$row['adviser']."<br>";
		$course_student_mod = new User($db,$userLoggedIn);
		$course_update = new Course($db, $course_code);
		if($user['users'] == 'student'){
			echo "<form action='course.php?code=$course_code' method='POST'>";
			if($course_student_mod->isJoined($_REQUEST['code'])){
				echo '<input type="submit" name="Unjoined" class="danger" value="Leave" style="float: left;">';
			}	
			else{
				echo '<input type="submit" name="Join" class="success" value="Join" style="float: left;">';
			}
			echo '<button type="button" class="default" data-toggle="modal" data-target="#ReviewModal" style = "float: right;">
					Add Review
				  </button>';
			echo "</form>";
		} else {
			if($course_student_mod->isJoined($_REQUEST['code'])){
			echo <<<EOF
			<button type="button" class="success" data-toggle="modal" data-target="#exampleModal" style = "float: left;">
			Announce
			</button>
			<button type="button" class="default" data-toggle="modal" data-target="#editModal" style = "float: right;">
			Edit
			</button>
EOF;
		}
	}
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

	
	</div>
	<div class="persons">
			<div id= "adviser">
				<a href=""> <img src="<?php echo $row['adviserpicture'];?>"></a> 
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
					// echo " <a href='$value'>".$value."</a><br>";
					$query = pg_query($db,"SELECT first_name, last_name, profile_pic FROM users WHERE username='$value'");
					$querys= pg_fetch_array($query);

					echo "	<div class='personSt'>
								<img src=".$querys['profile_pic']." width='50' style='border-radius:100%;'>&nbsp; &nbsp; &nbsp;
								<a href='$value'> ".$querys['first_name'].' '.$querys['last_name']." </a>
							</div><br>
						";
				}
				echo "</p>";
				?>
			</div>
		</div>

<?php 
	 if($course_student_mod->isJoined($_REQUEST['code'])){

?>

<div class="discussion">
	<ul class="nav nav-tabs" role="tablist" id="discussion_tabs">
		<li role="presentation" class="active"><a href="#announcement_div" aria-controls="announcement_div" role="tab" data-toggle="tab">Announcement</a></li>
		<li role="presentation"><a href="#discussion_div" aria-controls="discussion_div" role="tab" data-toggle="tab">Discussion</a></li>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane fade in active" id="announcement_div">
			<div class="posts_area">
				<?php 
				$posts = new Announcement($db, $_GET['code'], $userLoggedIn);
				$posts->loadPostsAnnouncement();
				?>
			</div>
		</div>

		<div role="tabpanel" class="tab-pane fade" id="discussion_div">
			<div class="posts_area">
				<?php 
				$data = pg_query($db, "SELECT * FROM course WHERE code = '".$_REQUEST['code']."'");
				$row = pg_fetch_array($data);
			

				echo"<form class= 'post_form' action='course.php?code=$course_code' method='POST'>";
				?>
				<textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
				<input type="submit" name="post" id="post_button" value="Post">
			</form>
			<?php 
			$post = new Discussion($db, $_GET['code'], $userLoggedIn);
			$post->loadPostsDiscussion();
			?>
		</div>
	</div>
</div>
</div>
      	<?php 
      		}
      	 ?>
    	<div>
			<?php 
			// $data = pg_query($db, "SELECT * FROM course WHERE code = '".$_REQUEST['code']."'");
			// $row = pg_fetch_array($data);

		
			// echo "<form class= 'post_form' action='course.php?code=$course_code' method='POST'>";
			?>
<!-- 			<textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
			<input type="submit" name="post" id="post_button" value="Post">
			<hr>
			</form> -->
			<?php 
			// $post = new Discussion($db, $_GET['code'], $userLoggedIn);
			// $post->loadPostsDiscussion();
			
			 ?>
		</div>
	</div>


<!-- 		<div class="ratings">
			<p style="text-align:center">Ratings</p>
		</div> -->
		<div class="ratings" id="thisOnly">
			<p style="text-align:center">Ratings</p>
			<?php 
				$review = new Review($db, $_GET['code'],$userLoggedIn);
				$review->loadPostsReview();
			 ?>
		</div>
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="announcementModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Post Announcement</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Announcement will be posted on the course page and will be seen by the students joined the course</p>

					<form class="announcement_post" action="course.php?code=<?php echo $row['code'];?>" method ="POST">
						<div class="form_group">
							<textarea class="form-control" name="post-body"></textarea>
							<input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>" >
							<input type="hidden" name="user_from" >
							<input type="submit" name="announce" value="Announce" class="success" > 
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="ReviewModal" tabindex="-1" role="dialog" aria-labelledby="announcementModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Review</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Each student can review course only once</p>

					<form class="announcement_post" action="course.php?code=<?php echo $row['code'];?>" method ="POST">
						<div class="form_group">
							<textarea class="form-control" name="post-body"></textarea>
							<input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>" >
							<input type="hidden" name="user_from" >
							<input type="submit" name="review" value="Add Review" class="success" > 
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="announcementModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Post Announcement</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Edit</p>
					<?php 
						
					 ?>
					<form class="announcement_post" action="course.php?code=<?php echo $row['code'];?>" method ="POST">
						<div class="form_group">
									<div class="row">
										<div class="col-lg-12">
											Code: <input class="settings_input" type="text" name="ed_code" value="<?php echo $row['code'] ?>"> 
										</div> 
									</div>
									<div class="row">
										<div class="col-lg-12">
											Description: <input class="settings_input" type="text" name="ed_desc" value="<?php echo $row['description'] ?>">
										</div> 
									</div>
									<div class="row">
										<div class="col-lg-12">
											Section: <input class="settings_input" type="text" name="ed_sec" value="<?php echo $row['section'] ?>"> 
										</div> 
									</div>
									<div class="row">
										<div class="col-lg-12">
											Room: <input class="settings_input" type="text" name="ed_room" value="<?php echo $row['roomno'] ?>"> 
										</div> 
									</div>
									<div class="row">
										<div class="col-lg-12">
											Time: <input class="settings_input" type="time" name="ed_time" value="<?php echo $row['starttime'] ?>"> -
											 <input class="settings_input" type="time" name="ed_time2" value="<?php echo $row['endtime'] ?>"> 
										</div> 
									</div>
									<div class="row">
										<div class="col-lg-11">
											<input class="btn settings_btn" type="submit" name="update_details" id="save_details" value="Update Details"> 
										</div> 
									</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					
				</div>
			</div>
		</div>
	</div>
</div>

		</body>
		</html> 