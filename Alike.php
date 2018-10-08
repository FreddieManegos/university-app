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
 
		body{
			background-color: #fff;
		}
		form{
			    position: absolute;
    			top: 4px;

		}
	</style>
<?php 
	require 'dbconnect.php';
	include("includes/classess/User.php");
	include("includes/classess/Discussion.php");
	include("includes/classess/Post.php");
	include("includes/classess/Announcement.php");


	if(isset($_SESSION['username'])){
		$userLoggedIn = $_SESSION['username'];
		$user_details_query = pg_query($db, "SELECT * FROM users WHERE username = '$userLoggedIn' ");
		$user = pg_fetch_array($user_details_query);
	} else {
		 header('Location: register.php');
	}

	if(isset($_GET['post_id'])) {
	 		$post_id = $_GET['post_id']; 
 	}

 	$get_likes = pg_query($db, "SELECT announce_like, added_by FROM discussions WHERE id = '$post_id'");
 	$row = pg_fetch_array($get_likes);
 	$total_likes = $row['likes'];
 	$user_liked = $row['added_by'];

 	$user_details_query = pg_query($db, "SELECT * FROM users WHERE username = '$user_liked'");
 	$row = pg_fetch_array($user_details_query);

 	//Kung I like ang $
 	if(isset($_POST['like_button'])){
 		$total_likes++;
 		$query = pg_query($db, "UPDATE announcements SET likes='$total_likes' WHERE id='$post_id'");
 		$insert_user = pg_query($db, "INSERT INTO announce_like(username,post_id) VALUES('$userLoggedIn','$post_id')");
 	}
 	//For the UNlike button
	if(isset($_POST['unlike_button'])){
 		$total_likes--;
 		$query = pg_query($db, "UPDATE announcements SET likes='$total_likes' WHERE id='$post_id'");
 		$insert_user = pg_query($db, "DELETE FROM announce_like WHERE username='$userLoggedIn' AND post_id='$post_id'");
 	}
 	$check_query = pg_query($db,"SELECT * FROM announce_like WHERE username = '$userLoggedIn' AND post_id='$post_id'");
 	$num_rows = pg_num_rows($check_query);

 	if($num_rows > 0){
 		echo '<form action="Alike.php?post_id='. $post_id . '" method="POST">
               <input type = "submit" class="comment_like" name="unlike_button" value="Unlike">
 				<div class = "like_value">
 					'.$total_likes.' Likes
 				</div>
 			</form>
 			';
 	} else {
 		echo '<form action="Alike.php?post_id='. $post_id . '" method="POST">
               <input type = "submit" class="comment_like" name="like_button" value="Like">
 				<div class = "like_value">
 					'.$total_likes.' Likes
 				</div>
 			</form>
 			';
 	}

	 ?>