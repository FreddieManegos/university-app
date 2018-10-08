<html>
<head>
  <link rel="shortcut icon" type="image/x-icon" href="img/msuiit_tab_icon.ico">
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
       <div class="modal-body"><form action="login.php" method="POST">
        <div class="row">
         <p class="_in usein"><input class="col-lg-11" name="log_in_studentID" type="text" placeholder="Student ID" id="stdid" value=""><i class="glyphicon glyphicon-user"></i></p>
       </div>
       <div class="row">
         <p class="_in pwdin"><input class="col-lg-11" name="log_in_password" type="password" placeholder="Password" id="pwd" value=""><i class="glyphicon glyphicon-lock"></i></p>
       </div>
       <!-- <input type="submit" value= "Login" name="log_in_button" class="btn"> -->
       <input type="Submit" name="log_in_button" value="Login" class="btn">
     </form>
     <a href="#" style="position: fixed; left: 40%; top: 76%;">Forgot Password?</a>
     <p id="signup"><a data-target="#upModal" data-toggle="modal" data-dismiss="modal"><span style="text-decoration:none;">Sign up</a> if not yet registered.</p>
     </div>
   </div>
 </div>
</div>
</div>
<?php 
include("dbconnect.php");
if(isset($_POST["log_in_button"])){

  $studentID = pg_escape_string($_POST['log_in_studentID']);
  $_SESSION['log_in_studendID'] = $studentID;

  $password = md5($_POST['log_in_password']);

  $check_db_query = pg_query($db,"SELECT * FROM users WHERE username = '$studentID' and password = '$password'");

  $check_login_query = pg_num_rows($check_db_query);

  if($check_login_query == 1) {
    $row = pg_fetch_array($check_db_query);
    $username = $row['username'] ;

    $_SESSION['username'] = $username;
    if($row['user'] == 'student'){
      header("Location: index.php");
    } else if($row['user'] == 'admin'){
      header("Location: adminindex.php");
    }
    exit();
    
  } 
}

?> 
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
            <p class="_up col-lg-5"><input class="col-lg-12" name="first_name" type="text" placeholder="First Name" value=""></p>
            <p class="_up col-lg-5"><input class="col-lg-12" name="last_name" type="text" placeholder="Last Name" value=""></p>
          </div>
          <div class="row">
            <p class="_up col-lg-5"><input class="col-lg-12" name="email" type="text" placeholder="Email" value=""></p>
            <p class="_up col-lg-5"><input class="col-lg-12" name="email2" type="text" placeholder="Confirm Email" value="" autocomplete="off"></p>
          </div>
          <div class="row">
            <p class="_up col-lg-5"><input name="password" type="password" placeholder="Password" value="" class="col-lg-12"></p>
            <p class="_up col-lg-5"><input  name="password2" type="password" placeholder="Confirm Password" value="" class="col-lg-12"></p>
          </div>
          <div class="row">
            <p class="_up col-lg-5"><input name="username" type="text" placeholder="Username" value="" class="col-lg-12"></p>
          </div>
          <div class="row">
            <p class="btnup"><input type="submit" data-toggle="#upModal" name="signup_btn" class="btn col-lg-11" value="Sign up"></p>
            <?php 
            if(isset($_POST['signup_btn'])){
              if(empty($_POST['first_name'])|| empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['email2']) || empty($_POST['password']) || empty($_POST['password2'])){
                $msg = "Do not leave a text field empty.";
                echo "<p style='color: White; background-color: Black; filter: opacity(80%); text-align: center;'>" .$msg. "</p>";
                exit();
              }
              elseif(isset($_POST['email']) && isset($_POST['email2'])){
                $emails = $_POST['email'] != $_POST['email2'];
                $passwords = $_POST['password'] != $_POST['password'];
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
              } else {
                $email = pg_escape_string($_POST['email']);
                $fname = pg_escape_string($_POST['first_name']);
                $lname = pg_escape_string($_POST['last_name']);
                $password = pg_escape_string($_POST['password']);
                $username = pg_escape_string($_POST['username']);
                $friends_array = ","; $course_array = ",";

                $password = md5($password);

                $rand = rand(1,2);
                if($rand == 1)
                  $profile_pic = "assets/Images/profile_pics/defaults/head_belize_hole.png";
                else
                  $profile_pic = "assets/Images/profile_pics/defaults/head_red.png";
                $date = date('Y-m-d');
                $query = pg_query($db, "INSERT INTO users(username, first_name,last_name, email, password, sigup_date, profile_pic, college, course, year, user_closed) VALUES ('$username','$fname','$lname','$email','$password','$date','$profile_pic',',',',',4,'no')");
                echo "<p>".$insert."</p>";
                if(pg_query($db,$insert)){
                  echo "<p>"."Successfully Inserted"."</p>";
                              //header("Location:circle.php");
                }else {
                  echo "<p>"."Not inserted"."</p>";
                }
              }
            }
            ?> 
          </div>
          <p class="other"><a data-toggle="modal" data-target="#inModal" data-dismiss="modal">Already have an account?</a></p>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
</body>
</html>
