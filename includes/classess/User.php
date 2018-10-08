<?php 
class User {
	private $user;
	private $db;

	public function __construct($db, $user){
		$this->db = $db;
		$user_details_query = pg_query($db, "SELECT * FROM users WHERE username='$user'");
		$this->user = pg_fetch_array($user_details_query);
	}

	public function getFirstAndLastName(){
		$username = $this->user['username'];
		$query = pg_query($this->db, "SELECT first_name, last_name FROM users WHERE username = '$username'");
		$row = pg_fetch_array($query);
		return $row['first_name'] . " " . $row['last_name'] ;
	}

	public function getProfilePic(){
		$username = $this->user['username'];
		$query = pg_query($this->db, "SELECT profile_pic FROM users WHERE username='$username'");
		$row = pg_fetch_array($query);
		return $row['profile_pic'];
	}

	public function getFriendArray(){
		$username = $this->user['username'];
		$query = pg_query($this->db, "SELECT friends_array FROM users WHERE username='$username'");
		$row = pg_fetch_array($query);
		return $row['friends_array'];
	}

	public function getUsername() {
		return $this->user['username'];
	}


	public function getCourseArray(){
		$array = $this->user['course_array'];
		return $array;
	}

	public function isFriend($username_to_check) {
		//$usernameComma = "," . $username_to_check . ",";

		if((strstr($this->user['friends_array'],$username_to_check) || $username_to_check == $this->user['username'])) {
			return true;
		}
		else {
			return false;
		}
	}

	public function didSendRequest($user_to) {
		$user_from = $this->user['username'];
		$check_request_query = pg_query($this->db, "SELECT * FROM friend_requests WHERE user_to ='$user_to' AND user_from = '$user_from' ");
		if(pg_num_rows($check_request_query) > 0) {
			return true;
		}else{
			return false;
		}
	}

	public function didReceiveRequest($user_from) {
		$user_to = $this->user['username'];
		$check_request_query = pg_query($this->db, "SELECT * FROM friend_requests WHERE user_to ='$user_to' AND user_from = '$user_from' ");
		if(pg_num_rows($check_request_query) > 0) {
			return true;
		}else{
			return false;
		}
	}

	public function sendRequest($user_to){
		$user_from = $this->user['username'];
		$query = pg_query($this->db, "INSERT INTO friend_requests(user_to,user_from) VALUES('$user_to','$user_from')");
	}

	public function removeFriend($user_to_remove){
		$logged_in_user = $this->user['username'];

		$query = pg_query($this->db, "SELECT friends_array FROM users WHERE username='$user_to_remove'");
		$row = pg_fetch_array($query);
		$friends_array_username = $row['friends_array'];
		if((strpos($this->user['friends_array'], ','.$user_to_remove.',') !== false) || (strpos($this->user['friends_array'], $user_to_remove.',') !== false) ){
			$new_friend_array = str_replace($user_to_remove.",","", $this->user['friends_array']);
			$remove_friend = pg_query($this->db, "UPDATE users SET friends_array='$new_friend_array' WHERE username='$logged_in_user'");
		} else if((strpos($this->user['friends_array'], ','.$user_to_remove) !== false)) {
			$new_friend_array = str_replace(",".$user_to_remove,"", $this->user['friends_array']);
			$remove_friend = pg_query($this->db, "UPDATE users SET friends_array='$new_friend_array' WHERE username='$logged_in_user'");
		} else {
			$new_friend_array = str_replace($user_to_remove,"", $this->user['friends_array']);
			$remove_friend = pg_query($this->db, "UPDATE users SET friends_array='$new_friend_array' WHERE username='$logged_in_user'");
		}

		if((strpos($friends_array_username, ','.$logged_in_user.',') !== false) || (strpos($friends_array_username, $logged_in_user.',') !== false) ){
			$new_friend_array = str_replace($this->user['username'].",","",$friends_array_username);
			$remove_friend = pg_query($this->db, "UPDATE users SET friends_array='$new_friend_array' WHERE username='$user_to_remove'"); 
		} else if((strpos($friends_array_username, ','.$logged_in_user) !== false)) {
			$new_friend_array = str_replace(','.$this->user['username'],"",$friends_array_username);
			$remove_friend = pg_query($this->db, "UPDATE users SET friends_array='$new_friend_array' WHERE username='$user_to_remove'"); 
		} else {
			$new_friend_array = str_replace($this->user['username']."","",$friends_array_username);
			$remove_friend = pg_query($this->db, "UPDATE users SET friends_array='$new_friend_array' WHERE username='$user_to_remove'"); 
		}
		
	}

	public function removeCourse($courseToRemove){ 
		$logged_in = $this->user['username'];
		$query = pg_query($this->db, "SELECT course_array FROM users WHERE username='".$logged_in."'");
		$row = pg_fetch_array($query);
		$course_array = $row['course_array'];
		if((strpos($course_array, ",".$courseToRemove.",") !== false) || strpos($course_array, $courseToRemove.",") !== false) {
			$new_course_array = str_replace($courseToRemove.",","",$this->user['course_array']);
		} else if(strpos($course_array, ",".$courseToRemove) !==false ){
			$new_course_array = str_replace(",".$courseToRemove,"",$this->user['course_array']);
		} else if(strpos($course_array, "{".$courseToRemove."}") !==false ){ 
			$new_course_array = str_replace($courseToRemove,"",$this->user['course_array']);
		}else {
			$new_course_array = str_replace(",".$courseToRemove,"",$this->user['course_array']);
		}
		$remove_course = pg_query($this->db,"UPDATE users SET course_array = '$new_course_array' WHERE username='$logged_in'");
	}


	public function isJoined($course){
		$logged_in = $this->user['username'];
		$query = pg_query($this->db, "SELECT * FROM users WHERE username='".$logged_in."'");
		$row = pg_fetch_array($query);
		if((strpos($row['course_array'], $course)) != false){
			return true;
		}else{
			return false;
		}
	}

	public function joinCourse($course){
		$logged_in = $this->user['username'];
		$user_course = pg_query($this->db, "SELECT course_array FROM users WHERE username='$logged_in'");
		$user_course_arr = pg_fetch_array($user_course);
		$user_course_array = $user_course_arr['course_array'];
		if(strpos($user_course_array, "{}") !== false) {
			$new_course_array = str_replace("}",$course."}", $user_course_array);
			$add_course = pg_query($this->db, "UPDATE users SET course_array = '$new_course_array' WHERE username='$logged_in'");
		} else {
			$new_course_array = str_replace("}",",".$course."}", $user_course_array);
			$add_course = pg_query($this->db, "UPDATE users SET course_array = '$new_course_array'  WHERE username='$logged_in'");
		}
	}

	
}


?>