<?php 
	include("../../dbconnect.php");
	include("../classess/User.php");
	include("../classess/Discussion.php");

	$limit = 10;

	$disc = new Discussion($con, $_REQUEST['code'], $_REQUEST['userLoggedIn']);



 ?>