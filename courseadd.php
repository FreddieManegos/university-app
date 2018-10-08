	<?php 
include("includes/header.php");
include("includes/classess/User.php");
include("includes/classess/Course.php");
include("includes/form-handlers/courseadd_handler.php");

?>
<div class="wrapper">
	<div class="main_column column">
		<h3>Add Course</h3>
		<form action="courseadd.php" method="POST">
			Course Code:<input type="text" name="add_code"><br>
			Description: <input type="text" name="add_desc"><br>
			Section: <input type="text" name="add_sec"><br>
			Time: <input type="time" name="add_start"> - <input type="time" name="add_end"> <br>
			Days: <input type="text" name="add_day" placeholder="e.g. MTh"> <br>
			RoomNo: <input type="text" name="add_roomNumber"> <br>	
			<input type="submit" name="add_submit" value="Add">
		</form>
	</div>
</div>