<?php 
include("includes/header.php");
include("includes/classess/User.php");
?>
<div class="wrapper">
	<div class="main_column column " id="main_column"> 
		<h4>Friend Requests</h4>

		<?php 

		$query = pg_query($db, "SELECT * FROM friend_requests WHERE user_to='$userLoggedIn'");
		if(pg_num_rows($query) == 0) {
			echo "You have no friend requests at this time!";
		} else{
			while($row = pg_fetch_array($query)){
				$user_from = $row['user_from'];
				$user_from_obj = new User($db, $user_from);
				$user = new User($db, $userLoggedIn);

				echo $user_from_obj->getFirstAndLastName()." sent you a friend request!";

				$user_from_friend_array = $user_from_obj->getFriendArray();

				if(isset($_POST['accept_request' . $user_from])) {
					if(strpos($user->getFriendArray(), "{}") !== false){
						$new_friend_array = str_replace("}",$user_from."}", $user->getFriendArray());
						$add_friend_query = pg_query($db, "UPDATE users SET friends_array='$new_friend_array' WHERE username='$userLoggedIn'");
					} else {
						$new_friend_array = str_replace("}",",".$user_from."}", $user->getFriendArray());
						$add_friend_query = pg_query($db, "UPDATE users SET friends_array='$new_friend_array' WHERE username='$userLoggedIn'");
					}
					if(strpos($user_from_friend_array, "{}") !== false){
						$new_friend_array_obj =  str_replace("}",$userLoggedIn."}", $user_from_friend_array);
						$add_friend_query = pg_query($db, "UPDATE users SET friends_array='$new_friend_array_obj' WHERE username='$user_from'");
					} else {
						$new_friend_array_obj =  str_replace("}",",".$userLoggedIn."}", $user_from_friend_array);
						$add_friend_query = pg_query($db, "UPDATE users SET friends_array='$new_friend_array_obj' WHERE username='$user_from'");
					}
					$delete_query = pg_query($db, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from = '$user_from'");
					echo "You are now friends!";
					header("Location: requests.php");
				}


				if(isset($_POST['ignore_request'. $user_from])) {
					$delete_query = pg_query($db, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from = '$user_from'");
					echo "Request Ignored!";
					header("Location: requests.php");
				}
				?>
				<form action="requests.php" method="POST">
					<input type="submit" name="accept_request<?php echo $user_from; ?>" class="success" value="Accept">
					<input type="submit" name="ignore_request<?php echo $user_from; ?>" class="danger" value="Ignore">
				</form>
				<?php 
			}
		}
		?>




	</div>
</div>