<?php 
	class Message {
		private $user_obj;
		private $db;
		
		public function __construct($db,$user){
			$this->db= $db;
			$this->user_obj = new User($db, $user);
		}

		public function getMostRecentUser(){
			$userLoggedIn = $this->user_obj->getUsername();

			$query = pg_query($this->db, "SELECT user_to,user_from FROM messages WHERE user_to = '$userLoggedIn' OR user_from = '$userLoggedIn' ORDER BY id DESC LIMIT 1");
			if(pg_num_rows($query) == 0)
				return false;

			$row = pg_fetch_array($query);
			$user_to = $row['user_to'];
			$user_from = $row['user_from'];

			if($user_to != $userLoggedIn)
				return $user_to;
			else 
				return $user_from;
		}

		public function sendMessage($user_to, $body, $date) {
			if($body != ""){
				$userLoggedIn = $this->user_obj->getUsername();
				$query = pg_query($this->db, "INSERT INTO messages(user_to, user_from, body, date, opened, viewed, deleted) VALUES ('$user_to','$userLoggedIn','$body', '$date', 'no','no','no')");
			}
		}

		public function getMessage($other_user){
			$userLoggedIn = $this->user_obj->getUsername();
			$date  = "";
			$data = "";
			$query = pg_query($this->db, "UPDATE messages SET opened='yes' WHERE user_to = '$userLoggedIn' and user_from = '$other_user'");

			$get_message_query = pg_query($this->db, "SELECT * FROM messages WHERE (user_to = '$userLoggedIn' and user_from = '$other_user') OR (user_from = '$userLoggedIn' AND user_to='$other_user') ORDER BY date ASC");

			while ($row = pg_fetch_array($get_message_query)) {
				 $user_to = $row['user_to'];
				 $user_from = $row['user_from'];
				 $body  = $row['body'];

				 $div_top = ($user_to == $userLoggedIn) ? "<div class='message' id='green'>" : "<div class='message' id='blue'>";
				 $data = $data . $div_top . $body. "</div><br><br>";
			}
			return $data;
		}
	}
 ?>