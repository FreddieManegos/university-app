<?php 
include("includes/header.php");
include("includes/classess/User.php");
include("includes/classess/Post.php");
include("includes/classess/Course.php");
include("includes/classess/Announcement.php");

function postgres_to_php_array($postgresArray){

	$postgresStr = trim($postgresArray,"{}");
	$elmts = explode(",",$postgresStr);
	return $elmts;
}

if(isset($_POST['post'])){
	$post = new Post($db, $userLoggedIn);
	$post->submitPost($_POST['post_text'],'none');
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
	<div class="index_announcement">
			<div class="index_nav_header">ANNOUNCEMENT</div>
			<?php 
			$datas = pg_query($db, "SELECT course_array FROM users WHERE username='$userLoggedIn'");
			$rows = pg_fetch_array($datas);
			$courses = $rows['course_array'];
			foreach (postgres_to_php_array($courses) as $value) {
				$posts = new Announcement($db, $value, $userLoggedIn);
				$posts->loadPostsAnnouncementIndex();
			}
			 ?>
	</div>

	<!-- 	<form class="post_form" action="index.php" method="POST">
			<textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
			<input type="submit" name="post" id="post_button" value="Post">
			<hr> -->

		</form>
		<?php 
		// $post = new Post($db,$userLoggedIn);
		// $post->loadPostsFriends();

		 ?>
		<div class="posts_area"></div>
		<img id="loading" src="assets/images/icons/loading.gif">

	</div>

	
</div>
</body>
</hmtl> 