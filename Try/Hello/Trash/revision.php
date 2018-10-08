<html>
  <head>
    <link rel="shortcut icon" type="image/x-icon" href="/UniversityApp/image/msuiit_tab_icon.ico">
    <link rel="stylesheet" type="text/css" href="\UniversityApp\revisioncss.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-fixed-top">
      <div class="navbar-header">
        <img id="logo" src="/UniversityApp/image/logo.png">
        <a href="#" class ="navbar-brand"><img href="https://x4150idp.msuiit.edu.ph/sso/module.php/core/loginuserpass.php?AuthState=_ba78f897932b45a0a3b164610e73964618204a42a9%3Ahttp%3A%2F%2Fx4150idp.msuiit.edu.ph%2Fsso%2Fsaml2%2Fidp%2FSSOService.php%3Fspentityid%3Dhttps%253A%252F%252Fx4150my.msuiit.edu.ph%252Fsso%252Fmodule.php%252Fsaml%252Fsp%252Fmetadata.php%252Fdefault-sp%26RelayState%3Dhttps%253A%252F%252Fx4150my.msuiit.edu.ph%252Fmy%252Findex.php" src="UniversityApp/image/myiit.gif"></a>
        <a id="tosignin"data-toggle="modal" data-target="#inModal">Sign In</a>
        <p id="line">|</p>
        <a id="tosignup"data-toggle="modal" data-target="#upModal">Sign Up</a>
    </div>
    </nav>
    <div id="intro" style="display: inline-block; position: absolute; top:40%; left:16%; color:White"><h1 style="font-family:'Denk One'; text-shadow:1px 3px 3px Black">MY.IIT CONNECT</h1><p style="font-family:Calibri">Get along with your friends and classmates to discuss your favorite subject matters.<br>Receive real-time updates from the University, Department, and Faculty.<br>Join courses to participate in the discussions.</p><div>
    <div id="seal"><img src="/UniversityApp/image/msuiit_seal.png"</div>
    <div id="inModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" style="color:White">&times;</button>
                <h4 class="modal-title">Sign in to MY.IIT CONNECT</h4>
              </div>
            <div class="modal-body">
             <form action = "log_in.php" method = "POST">
              <div class="row">
                <p class="_input col-md-5"><input name="stdid" type="text" placeholder="Student ID" id="stdid" value=""><i class="glyphicon glyphicon-user"></i></p>
                <p class="_input col-md-5"><input name="pwd" type="password" placeholder="Password" id="pwd" value=""><i class="glyphicon glyphicon-lock"></i></p>
                <a href="#" id="forgot" class="col-md-12">Forgot Password?</a> 
                </form>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn" onclick="home()">Sign in</button>
          </div>
        </div>
      </div>
    </div>
        <div id="upModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" style="color:White">&times;</button>
                <h4 class="modal-title">Sign up for a MY.IIT CONNECT Account</h4>
              </div>
            <div class="modal-body">
              <form><div class="row">
                <p class="_input col-md-5"><input name="fname" type="text" placeholder="First Name" value="" id="firstname"></p>
                <p class="_input col-md-5"><input name="lname" type="text" placeholder="Last Name" value="" id="lastname"></p>
                <p class="_input col-md-5"><input name="stdid" type="text" placeholder="Student ID" value="" id="stdid"></p>
                <p class="_input col-md-5"><input name="cor" type="text" placeholder="COR Reference Number" value="" id="cor"></p>
                <p class="_input col-md-5"><input name="email" type="text" placeholder="Email address" value="" class="email"></p>
                <p class="_input col-md-5"><input name="cemail" type="text" placeholder="Confirm Email address" value="" class="email"></p>
                <p class="_input col-md-5"><input name="pwd" type="password" placeholder="Password" value="" class="pwd"></p>
                <p class="_input col-md-5"><input name="cpwd" type="password" placeholder="Confirm Password" value="" class="pwd"></p>
                <p class="upload col-md-12"><input type="file" name="fileToUpload" id="fileToUpload"></p>
              </form></div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn" onclick="signup()">Sign up</button>
          </div>
        </div>
      </div>
    </div>
    <nav class="navbar navbar-fixed-bottom">
      <div class="navbar-brand center-align"><p style="color: Gray">TEAM PURA © 2017</p></div>
    </nav>

<?php 
ob_start();
$host = "host=127.0.0.1"; 
$port = "port=5432";
$dbname = "dbname=UniversityApp";
$credentials = "user=postgres password=09193692079369";
$db = pg_connect( "$host $port $dbname $credentials" ); //Important! Connection for the PHP and Postgresql
if(!$db)
	echo 'error';
?>
    <script>
      function home(){
        window.open("file:///C:/Users/HP/Desktop/-/MSU-IIT Student Social/New_Login/myaccount.html","_self");
      }
      function signup(){
        alert("Hello");
      }
    </script>
  </body>
</html>