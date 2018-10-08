<?php 
class LoadCourse {
	private $course;
	private $db;

	public function __construct($db,$course){
		$this->db = $db;
		$this->course = new Course($db,$course);
	}

	public function loadCourseCode() {
		$str = "";
		$data = pg_query($this->db, "SELECT * FROM course");

		while($row = pg_fetch_array($data)) {
			$id = $row['id'];
			$code = $row['code'];

			$load_course = new Course($db, $code);

			$course_details_query = pg_query($this->query, "SELECT code FROM course WHERE code='$code'");
			$course_row = pg_fetch_array($course_details_query);
			$code = $course_row['code'];

		 	$str .= " <a href ='$code'> $code </a> <br>";
		}

		echo $str;
	}

}
	

 ?>