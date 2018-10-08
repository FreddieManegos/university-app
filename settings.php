<?php 
include("includes/header.php");
include("includes/classess/User.php");
include("includes/handlers/settings_handler.php");

?>
<div id="settings_wrapper">
	<div id="settings_main_column">
		<h3>Account Settings</h3>
		<?php 
		echo "<img src='".$user['profile_pic']."' id='small_profile_pics'>";
		?>
		<div class="row">
			<div class="col-lg-11">
		<a href="upload.php">Upload new profile picture</a></div></div><br/>

		<h4>Modify the Values and click 'Update Details'</h4>

		<?php 
		 ?>
		<form action="settings.php" method="POST">
			<div class="row">
				<div class="col-lg-12">
					First Name: <input class="settings_input" type="text" name="first_name" value="<?php echo $user['first_name'] ?>"> 
				</div> 
			</div>
			<div class="row">
				<div class="col-lg-12">
					Last Name: <input class="settings_input" type="text" name="last_name" value="<?php echo $user['last_name'] ?>">
				</div> 
			</div>
			<div class="row">
				<div class="col-lg-12">
					Email: <input class="settings_input" type="text" name="email" value="<?php echo $user['email'] ?>"> 
				</div> 
			</div>
			<?php echo $message; ?>
			<div class="row">
				<div class="col-lg-11">
					<input class="btn settings_btn" type="submit" name="update_details" id="save_details" value="Update Details"> 
				</div> 
			</div>
		</form>

		<h4>Change Password</h4>
		<form action="settings.php" method="POST">
			<div class="row">
				<div class="col-lg-12">
					Old	Password: <input class="settings_input" type="password" name="old_pass"> 
				</div> 
			</div>
			<div class="row">
				<div class="col-lg-12">
					New	Password: <input class="settings_input" type="password" name="new_pass"> 
				</div> 
			</div>
			<div class="row">
				<div class="col-lg-12">
					Confirm New	Password: <input class="settings_input" type="password" name="new2_pass"> 
				</div> 
			</div>
			<div class="row">
				<div class="col-lg-11">
					<input class="btn settings_btn" type="submit" name="update_pass" id="save_details" value="Update Password"> 
				</div> 
			</div>
		</form>

	</div>
</div>