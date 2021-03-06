<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">     
</head>
<body>

	<style type="text/css">
	*{
		font-size: 12px;
		font-family: Arial, Helvetica, Sans-serif;
	}
	body {
		background-color: #ffd9d9;
	}
 

	</style>


	<?php 
	require 'dbconnect.php';
	include("includes/classess/User.php");
	include("includes/classess/Post.php");
	include("includes/classess/Discussion.php");
	include("includes/classess/Announcement.php");


	if(isset($_SESSION['username'])){
		$userLoggedIn = $_SESSION['username'];
		$user_details_query = pg_query($db, "SELECT * FROM users WHERE username = '$userLoggedIn' ");
		$user = pg_fetch_array($user_details_query);
	} else {
		 header('Location: register.php');
	}

	 ?>

	 <script>
	 	function toggle(){
	 		var element = document.getElementById("comment_section");
	 		if(element.style.display == "block")
	 			element.style.display = "none";
	 		else
	 			element.style.display ="block";
	 	}
	 </script>

	 <?php 
	 	if(isset($_GET['post_id'])) {
	 		$post_id = $_GET['post_id']; 
	 	}

	 	$user_query = pg_query($db, "SELECT added_by, course_to FROM announcements WHERE id='$post_id'");
	 	$row = pg_fetch_array($user_query);
	 	$posted_to = $row['added_by'];	

	 	if(isset($_POST['postComment'.$post_id]) && $_POST['postComment'.$post_id] != "" && $_POST['post_body'] != "") {
	 		$post_body = $_POST['post_body'];
	 		$post_body = pg_escape_string($post_body);
	 		$date_time_now = date("Y-m-d H:i:s");
	 		$insert_post = pg_query($db, "INSERT INTO announce_comment(post_body,  posted_by, posted_to, date_added, removed, post_id) VALUES ('$post_body','$userLoggedIn', '$posted_to','$date_time_now','no','$post_id')");
	 	}


	  ?>
	  <form action="comment_Aframe.php?post_id=<?php echo $post_id;?>" id="comment_form"  name="postComment<?php echo $post_id; ?>" method = "POST">
	  	<textarea name="post_body"></textarea>
	  	<input type="submit" name="postComment<?php echo $post_id;?>" value="Post">
	  	 
	  </form>
	  <!-- Mao ni dri ipa load ang mga comments -->
	  <?php 	
	  	$get_comments = pg_query($db, "SELECT * FROM announce_comment WHERE  post_id='$post_id' ORDER BY id DESC");
	  	$count = pg_num_rows($get_comments);

	  	if($count != 0){
	  		while ($comment = pg_fetch_array($get_comments)) {
	  			$comment_body = $comment['post_body'];
	  			$posted_to = $comment['posted_to'];
	  			$posted_by = $comment['posted_by'];
	  			$date_added = $comment['date_added'];
	  			$removed = $comment['removed'];

				//Timeframe
					$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($date_added); //Time of post
					$end_date = new DateTime($date_time_now); //Current time
					$interval = $start_date->diff($end_date); //Difference between dates 
					if($interval->y >= 1) {
						if($interval == 1)
							$time_message = $interval->y . " year ago"; //1 year ago
						else 
							$time_message = $interval->y . " years ago"; //1+ year ago
					}
					else if ($interval->m >= 1) {
						if($interval->d == 0) {
							$days = " ago";
						}
						else if($interval->d == 1) {
							$days = $interval->d . " day ago";
						}
						else {
							$days = $interval->d . " days ago";
						}


						if($interval->m == 1) {
							$time_message = $interval->m . " month". $days;
						}
						else {
							$time_message = $interval->m . " months". $days;
						}

					}
					else if($interval->d >= 1) {
						if($interval->d == 1) {
							$time_message = "Yesterday";
						}
						else {
							$time_message = $interval->d . " days ago";
						}
					}
					else if($interval->h >= 1) {
						if($interval->h == 1) {
							$time_message = $interval->h . " hour ago";
						}
						else {
							$time_message = $interval->h . " hours ago";
						}
					}
					else if($interval->i >= 1) {
						if($interval->i == 1) {
							$time_message = $interval->i . " minute ago";
						}
						else {
							$time_message = $interval->i . " minutes ago";
						}
					}
					else {
						if($interval->s < 30) {
							$time_message = "Just now";
						}
						else {
							$time_message = $interval->s . " seconds ago";
						}
					}

					$user_obj = new User($db,$posted_by);
	  			?>
	  			<div class="comment_section">
	  				<a href="<?php echo $posted_by?>" target="_parent"><img src="<?php echo $user_obj->getProfilePic();?>" title="<?php echo $posted_by;?>" style="float: left;" height="30"></a>
	  				<a href="<?php echo $posted_by?>" target="_parent"><b><?php echo $user_obj->getFirstAndLastName()?></b></a>
	  				&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $time_message. "<br>". $comment_body; ?>
	  				<hr>
	  			</div>

	  			<?php  
	  		}
	  	}
	  	else {
	  		echo "<center><br><br>No Comments to Show</center>";
	  	}

	   ?>
	   </body>
</html>