<?php 

class Post {
	private $user_obj;
	private $db;

	public function __construct($db, $user){
		$this->db = $db;
		$this->user_obj = new User($this->db, $user);
	}

	public function submitPost($body, $user_to){
		$body = strip_tags($body); //removes the html tags
		$body = pg_escape_string($body);
		$check_empty = preg_replace('/\s+/','',$body); // Delete all spaces
		if($check_empty != "") {
			$date_added = date("Y-m-d H:i:s");
			$added_by = $this->user_obj->getUsername();
			if($user_to == $added_by) {
					$user_to = "none";
			}
			$query = pg_query($this->db, "INSERT INTO posts(body,added_by,user_to, date_added, user_closed, deleted, likes) VALUES ('$body','$added_by','$user_to','$date_added','no','no',0)");
		}

	}
	public function loadPostsFriends() {
		$str = ""; //String to return 
		$data = pg_query($this->db, "SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC");

	while($row = pg_fetch_array($data)) {
			$id = $row['id'];
			$body = $row['body'];
			$added_by= $row['added_by'];
			$date_time = $row['date_added'];

			if($row['user_to'] == "none"){
				$user_to = "";
			}
			else {
				$user_to_obj = new User($db, $row['user_to']);
				$user_to_name = $user_to_obj->getFirstAndLastName();
				$user_to = "<a href='".$row['user_to']."'>" . $user_to_name. "</a>";
			}
			//check if usre who posted, has their 
			$user_details_query = pg_query($this->db, "SELECT first_name , last_name, profile_pic FROM users WHERE username = '$added_by'");
			$user_row = pg_fetch_array($user_details_query);
			$first_name = $user_row['first_name'];
			$last_name = $user_row['last_name'];
			$profile_pic = $user_row['profile_pic'];

			?> 
			<script>
				function toggle<?php echo $id; ?>(){
					var element = document.getElementById("toggleComment<?php echo $id; ?>");

					if(element.style.display == "block")
						element.style.display = "none";
					else
						element.style.display ="block";
				}
			</script>

			<?php 
			//Timeframe
			$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($date_time); //Time of post
					$end_date = new DateTime($date_time_now); //Current time
					$interval = $start_date->diff($end_date); //Difference between dates 
					if($interval->y >= 1) {
						if($interval == 1)
							$time_message = $interval->y . " year ago"; //1 year ago
						else 
							$time_message = $interval->y . " years ago"; //1+ year ago
					}
					else if ($interval->m >= 1) {
						if($interval->d == 0) {
							$days = " ago";
						}
						else if($interval->d == 1) {
							$days = $interval->d . " day ago";
						}
						else {
							$days = $interval->d . " days ago";
						}


						if($interval->m == 1) {
							$time_message = $interval->m . " month". $days;
						}
						else {
							$time_message = $interval->m . " months". $days;
						}

					}
					else if($interval->d >= 1) {
						if($interval->d == 1) {
							$time_message = "Yesterday";
						}
						else {
							$time_message = $interval->d . " days ago";
						}
					}
					else if($interval->h >= 1) {
						if($interval->h == 1) {
							$time_message = $interval->h . " hour ago";
						}
						else {
							$time_message = $interval->h . " hours ago";
						}
					}
					else if($interval->i >= 1) {
						if($interval->i == 1) {
							$time_message = $interval->i . " minute ago";
						}
						else {
							$time_message = $interval->i . " minutes ago";
						}
					}
					else {
						if($interval->s < 30) {
							$time_message = "Just now";
						}
						else {
							$time_message = $interval->s . " seconds ago";
						}
					}

					$str .= "<div class='status_post_discussion' onClick='javascript:toggle$id()' >
					<div class='post_profile_pic'>
					<img src='$profile_pic' width='50'>
					</div>

					<div class='posted_by' style='color:#ACACAC;'>
					<a href='$added_by'> $first_name $last_name </a> ($user_to) &nbsp;&nbsp;&nbsp;&nbsp;$time_message
					</div>
					<div id='post_body'>
					$body
					<br>
					<br>
					<br>
					</div>
					</div>
					<div class='post_comment' id='toggleComment$id' style='display:none;'>
								<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
							</div>
					<hr>";
					}
					echo $str;
				}
			}
		?>