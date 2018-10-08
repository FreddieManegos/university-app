<?php 
include("includes/header.php");
include("includes/classess/User.php");
include("includes/handlers/settings_handler.php");

?>
<div class="wrapper">
	<div class="main_column column">
		<h3>Account Settings</h3>
		<?php 
		echo "<img src='".$user['profile_pic']."' id='small_profile_pics'>";
		?>
		<br>
		<a href="upload.php">Upload new profile picture</a> <br><br>

		<h4>Modify the Values and click 'Updates Details'</h4>

		<?php 

		 ?>
		<form action="settings.php" method="POST">
			First Name: <input type="text" name="first_name" value="<?php echo $user['first_name'] ?>"> <br>
			Last Name: <input type="text" name="last_name" value="<?php echo $user['last_name'] ?>"> <br>
			Email: <input type="text" name="email" value="<?php echo $user['email'] ?>"> <br>
			<?php echo $message; ?>
			<input type="submit" name="update_details" id="save_details" value="Updates Details">
		</form>

		<h4>Change Password</h4>
		<form action="settings.php" method="POST">
			Old	Password: <input type="password" name="old_pass"> <br>
			New	Password: <input type="password" name="new_pass"> <br>
			New	Password Again: <input type="password" name="new2_pass"> <br>
			<input type="submit" name="update_pass" id="save_details" value="Updates Password">
		</form>

	</div>
</div>