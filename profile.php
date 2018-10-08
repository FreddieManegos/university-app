<?php 
include("includes/header.php");
include("includes/classess/User.php");
include("includes/classess/Message.php");

if(isset($_GET['profile_username'])){
	$user_name = $_GET['profile_username'];
	$user_details_query = pg_query($db,"SELECT * FROM users WHERE username ='$user_name'");
	$user_array = pg_fetch_array($user_details_query);

}

if(isset($_POST['remove_friend'])) {
	$user = new User($db, $userLoggedIn);
	$user->removeFriend($user_name);
}

if(isset($_POST['add_friend'])) {
	$user = new User($db, $userLoggedIn); 
	$user->SendRequest($user_name);
}
			
if(isset($_POST['respond_request'])){
	header("Location: requests.php");
}

function postgres_to_php_array($postgresArray){

	$postgresStr = trim($postgresArray,"{}");
	$elmts = explode(",",$postgresStr);
	return $elmts;
}

?>
<div class = "wrapper" >
	<style type="text/css">
		.wrapper {
			margin-left:0px;
			padding-left: 0px;
		}
	</style>
	<div class = "profile_left">
		<img src="<?php echo $user_array['profile_pic']; ?>">
		<div class= "profile_info">
			<p style="text-align:center"><?php echo $user_array['first_name']. " " . $user_array['last_name'];?></p>
		</div>

		<form action="<?php echo "profile.php?profile_username=". $user_name; ?>" method="POST">
			<?php 
			$profile_user_obj = new User($db, $user_name);
			$logged_in_user_obj = new User($db, $userLoggedIn);
			if($userLoggedIn != $user_name) {
				if($logged_in_user_obj->isFriend($user_name)) {
					echo '<input type="submit" name="remove_friend" class="danger" value="Remove Friend"><br>';		
				} else if ($logged_in_user_obj->didReceiveRequest($user_name)) {
					echo '<input type="submit" name="respond_request" class="warning" value="Respond Request"><br>';	
				} else if ($logged_in_user_obj->didSendRequest($user_name)) {
					echo '<input type="submit" name="" class="default" value="Request Sent"><br>';
				} else {
					echo '<input type="submit" name="add_friend" class="success" value="Add Friend"><br>';
				}
			}
			?>
		</form>
		<div class="profile_info">
			<?php 
			echo "<br><p style='text-align:center'><strong>Courses Joined</strong><br></p>";
			$friend_course = $profile_user_obj->getCourseArray();
			echo "<p style='text-align:center'><br>";
			foreach (postgres_to_php_array($friend_course) as $value) {
				echo "<a href='course.php?code=$value'>".$value."</a><br>";
			}
			echo "</p>";
			?>
		</div>
	</div> 

	
<div class="profile_main_column column">

    <ul class="nav nav-tabs" role="tablist" id="profileTabs">
      <li role="presentation" class="active"><a href="#aboutme_div" aria-controls="aboutme_div" role="tab" data-toggle="tab">About Me</a></li>
      <li role="presentation"><a href="#messages_div" aria-controls="messages_div" role="tab" data-toggle="tab">Messages</a></li>
    </ul>

    <div class="tab-content">

      <div role="tabpanel" class="tab-pane fade in active" id="aboutme_div">
        <div class="posts_area"></div>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tertium autem omnibus aut maximis rebus iis, quae secundum naturam sint, fruentem vivere. Fortemne possumus dicere eundem illum Torquatum? Quantum Aristoxeni ingenium consumptum videmus in musicis? Nec vero alia sunt quaerenda contra Carneadeam illam sententiam.</p>
      </div>



      <div role="tabpanel" class="tab-pane fade" id="messages_div">
        <?php  
        	$message_obj = new Message($db, $user_name);

          echo "<h4>You and <a href='" . $user_name ."'>" . $profile_user_obj->getFirstAndLastName() . "</a></h4><hr><br>";

          echo "<div class='loaded_messages' id='scroll_messages'>";
            echo $message_obj->getMessage($user_name);
          echo "</div>";
        ?>
    </div>


        <div class="message_post">
          <form action="" method="POST">
              <textarea name='message_body' id='message_textarea' placeholder='Write your message ...'></textarea>
              <input type='submit' name='post_message' class='info' id='message_submit' value='Send'>
          </form>

        </div>

        <script>
          var div = document.getElementById("scroll_messages");
          div.scrollTop = div.scrollHeight;
        </script>
      </div>


    </div>


	</div>
</div>


</body>
</html>