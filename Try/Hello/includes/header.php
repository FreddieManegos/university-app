<?php  	
require 'dbconnect.php';
if(isset($_SESSION['username'])){
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = pg_query($db, "SELECT * FROM users WHERE username = '$userLoggedIn' ");
	$user = pg_fetch_array($user_details_query);
} else {
	header('Location: register.php');
}
?>
<!DOCTYPE html>
<html>
<head> 
	<title>Welcome to Student Portal 2.0</title>

	<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src = "assets/js/bootstrap.js"></script>
	<script src="assets/js/demo.js"></script>
	<script src="assets/js/jquery.jcrop.js"></script>
	<script src="assets/js/jcrop_bits.js"></script>

	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">	
	<link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />
</head>
<body>
	<div class = "top_bar">
		<div class = "logo">
			<a href="index.php" ><img src="\UniversityApp\assets\Images\MyIITCircle.png"></a>
		</div>	
		<div class="search">
			<form action="search.php" method="GET" name="search_form">
				<input type="text" onkeyup="getLiveSearchUsers(this.value,'<?php echo $userLoggedIn; ?>')" name="q" placeholder ="Search..." autocomplete="off" id="search_text_input">
				<div id= "button_holder">
					<img src="assets/Images/icon/magnifying_glass.png">
				</div>
			</form>
			<div class="search_results">
				
			</div>
			<div class="search_results_footer_empty">
				
			</div>
		</div> 
		<nav>
			<a href="<?php echo $userLoggedIn; ?>">
				<?php  echo $user['first_name']?>
			</a>
			<a href="index.php"><i class="fa fa-home fa-lg" aria-hidden="true"></i> </a>
			<a href="#"><i class="fa fa-envelope-o fa-lg" aria-hidden="true"></i></a>
			<a href="#"><i class="fa fa-bell-o fa-lg" aria-hidden="true"></i></a>
			<a href="requests.php"><i class="fa fa-users" aria-hidden="true"></i></a>
			<a href="settings.php"><i class="fa fa-cog fa-lg" aria-hidden="true"></i>
				<a href="includes/handlers/logout.php">LogOut</a>
			</a>
		</nav>
	</div>
	
</body>
</html>