<!-- <?php
	require 'dbconnect.php';
?>
 --><html>
<head>
  <link rel="shortcut icon" type="image/x-icon" href="image/msuiit_tab_icon.ico">
  <link media="all" rel="stylesheet" type="text/css" href="circle.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Italiana|Amatic+SC" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container-fluid front" data-target="#inModal" data-toggle="modal">
    	<p class="msuiit">M S U I I T</p>
    	<hr>
    	<p class="circle">Connect with your My.IIT.Circle</p>
  	</div>
  	<div id="inModal" class="modal fade" role="dialog">
    	<div class="modal-dialog">
     		<div class="modal-content">
       			<div class="modal-header" id="header">
         			<button type="button" class="close" data-dismiss="modal" style="color:White">&times;</button>
         			<h1 class="modal-title">My.IIT.Circle</h1>
         			<h6 class="modal-title">Log in or Register</h6>
       			</div>
       			<div class="modal-body">
       				<form method="POST">
        				<div class="row">
         					<p class="_in usein col-lg-5"><input class="col-lg-11" name="login_stdid" type="text" placeholder="Student ID" value=""><i class="glyphicon glyphicon-user"></i></p>
       					</div>
       					<div class="row">
         					<p class="_in pwdin col-lg-5"><input class="col-lg-11" name="login_pwd" type="password" placeholder="Password" value=""><i class="glyphicon glyphicon-lock"></i></p>
       					</div>
       					<div class="row">
         					<p class="btnin col-lg-6"><input type="submit" value="Login" name="login_btn" class="btn col-lg-11"></p>
       					</div> 
       				</form>
       				<?php 
						if(isset($_POST['login_btn'])){
							if(empty($_POST['login_stdid']) || empty($_POST['login_pwd'])){
								$msg = "Do not leave a text field empty.";
								echo "<p style='color: White; background-color: Black; filter: opacity(80%); text-align: center;'>" .$msg. "</p>";
							} else {
								$stdid = pg_escape_string(stripslashes($_POST['login_stdid']));
  								$pwd = md5(pg_escape_string(stripslashes($_POST['login_pwd'])));
  								$check = pg_query($db, 'SELECT * FROM "Student"');

  								while($row = pg_fetch_assoc($check)){
  									if($row['stdid'] == $stdid && $row['pwd'] == $pwd){
  										$_SESSION['login_name'] = $row['fname'];
  										header("Location: home.php");
  										exit();
  									}
  								}
  								$msg = 'Student ID or Password incorrect.';
								echo "<p style='color: White; background-color: Black; filter: opacity(80%); text-align: center;'>" .$msg. "</p>";
							}
						}

            

					?> 
       				<p class="other"><a href="#">Forgot Password?</a></p>
       				<p class="other"><a data-target="#upModal" data-toggle="modal" data-dismiss="modal">Sign up</a> if not yet registered.</p>
       			</div>
     		</div>
   		</div>
 	</div>
 	<div id="upModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
             	<div class="modal-header">
                	<button type="button" class="close" data-dismiss="modal" style="color:White">&times;</button>
                	<h1 class="modal-title">My.IIT.Circle</h1>
                	<h6 class="modal-title">Sign up for a MY.IIT.CIRCLE Account</h6>
              	</div>
            	<div class="modal-body">
              		<form method="POST">
                		<div class="row">
                			<p class="_up col-lg-5"><input class="col-lg-12" name="fname" type="text" placeholder="First Name" value=""></p>
                			<p class="_up col-lg-5"><input class="col-lg-12" name="lname" type="text" placeholder="Last Name" value=""></p>
                		</div>
                		<div class="row">
                			<p class="_up col-lg-5"><input class="col-lg-12" name="stdid" type="text" placeholder="Student ID" value=""></p>
                			<p class="_up col-lg-5"><input class="col-lg-12" name="cor" type="text" placeholder="COR Reference Number" value=""></p>
                		</div>
                		<div class="row">
                			<p class="_up col-lg-5"><input class="col-lg-12" name="email" type="text" placeholder="Email address" value=""></p>
                			<p class="_up col-lg-5"><input class="col-lg-12" type="text" name="conf_email" placeholder="Confirm Email address" value=""></p>
                		</div>
                		<div class="row">
                			<p class="_up col-lg-5"><input name="pwd" type="password" placeholder="Password" value="" class="col-lg-12"></p>
                			<p class="_up col-lg-5"><input  name="conf_pwd" type="password" placeholder="Confirm Password" value="" class="col-lg-12"></p>
                		</div>
                		<div class="row">
                			<p class="upload" style="margin-left:3em;"><input type="file" name="fileToUpload" id="fileToUpload"></p>
                		</div>
                		<div class="row">
                			<p class="btnup"><input type="submit" data-toggle="#upModal" name="signup_btn" class="btn col-lg-11" value="Sign up"></p>
                			<!-- <?php 
                				if(isset($_POST['signup_btn'])){
                					if(empty($_POST['fname'])|| empty($_POST['lname']) || empty($_POST['email']) || empty($_POST['conf_email']) || empty($_POST['pwd']) || empty($_POST['conf_pwd'])){
                						$msg = "Do not leave a text field empty.";
										echo "<p style='color: White; background-color: Black; filter: opacity(80%); text-align: center;'>" .$msg. "</p>";
										exit();
                					}
                					elseif(isset($_POST['email']) && isset($_POST['conf_email'])){
                						$emails = $_POST['email'] != $_POST['conf_email'];
                						$passwords = $_POST['pwd'] != $_POST['conf_pwd'];
                						if($emails || $passwords){
                							if($emails){
                								$error = "Email addresses";
                							}else{
                								$error = "Passwords";
                							}
                							$msg = "$error do not match!";
											echo "<p style='color: White; background-color: Black; filter: opacity(80%); text-align: center;'>" .$msg. "</p>";
											exit();
                						}
                					}
                						$email = pg_escape_string($_POST['email']);
                						$fname = pg_escape_string($_POST['fname']);
                						$lname = pg_escape_string($_POST['lname']);
                						$pwd = pg_escape_string($_POST['pwd']);
                						$stdid = pg_escape_string($_POST['stdid']);
                						$insert = 'INSERT INTO "Student" VALUES ('.$email.','.$fname.','.$lname.','.$pwd.','.$stdid.')';
                						echo "<p>".$insert."</p>";
                						if(pg_query($db,$insert)){
                							echo "<p>"."Successfully Inserted"."</p>";
                							//header("Location:circle.php");
                						}else {
                							echo "<p>"."Not inserted"."</p>";
                						}
                				}
                			?> -->
                		</div>
                		<p class="other"><a data-toggle="modal" data-target="#inModal" data-dismiss="modal">Already have an account?</a></p>
              		</form>
            	</div>
        	</div>
      	</div>
    </div>
</body>
</html>
