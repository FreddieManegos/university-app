<?php
	session_start();
?>
<html>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="image/msuiit_tab_icon.ico">
  		<link media="all" rel="stylesheet" type="text/css" href="course.css">
  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  		<link href="https://fonts.googleapis.com/css?family=Italiana|Amatic+SC" rel="stylesheet">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	</head>
	<body>
		<nav class="navbar navbar-fixed-top">
			<div class="navbar-header">
				<img id="myiit_logo" src="image/myiit.gif">
				<div class="col-md-12 search"><form>
  					<input class="col-lg-11" id="search" type="search" placeholder="Search">
  					<i class="glyphicon glyphicon-search"></i></form>
				</div>
				<div class="glyph">
					<a href="#" class="_user"><?php echo 'Username '; ?></a>
					<a href="#" class="_user"><i class="icon glyphicon glyphicon-home"></i></a>
					<a href="#" class="_user"><i class="icon glyphicon glyphicon-user"></i></a>
					<a href="#" class="_user"><i class="icon glyphicon glyphicon-envelope"></i></a>
					<a href="#" class="_user"><i class="icon glyphicon glyphicon-cog"></i></a>
					<a href="#" class="_user"><i class="icon glyphicon glyphicon-log-out"></i></a>
				</div>
			</div>
		</nav>
		<div class="content">
		<div class="course_details">
			<p><b>COURSE DETAILS</b><br/>Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course | Details of this course. </p>
		</div>
		<div class="announcements">
			<nav class="navbar" id="navbar_announce">
				<div class="navbar-header"><b>Announcements</b></div>
			</nav>
			<div class="announce">
			<?php
				//if naay announcement, i-new class lang man cguro
			?>
			</div>
		</div>
		<div class="members">
			<nav class="navbar"  id="navbar_mem">
				<div class="navbar-header"><b>Members</b></div>
			</nav>
		</div>
		<div class="discussion">
			<nav class="navbar disc" id="navbar_disc">
				<div class="navbar-header"><b>DISCUSSION</b>
			</nav>
		</div>
		<div class="ratings">
			<nav class="navbar rate" id="navbar_rate">
				<div class="navbar-header"><b>RATING</b>
				<span style="font-size: 14px;">
					<i class="glyphicon glyphicon-star-empty"></i>
					<i class="glyphicon glyphicon-star-empty"></i>
					<i class="glyphicon glyphicon-star-empty"></i>
					<i class="glyphicon glyphicon-star-empty"></i>
					<i class="glyphicon glyphicon-star-empty"></i>
				</span>
			</nav>
		</div>
	</div>
	</body>
</html>