<?php 
class Course{
	private $course;
	private $db;

	public function __construct($db,$course){
		$this->db = $db;
		$course_details_query = pg_query("SELECT * FROM course WHERE code = '".$course."'");
		$this->course = pg_fetch_array($course_details_query);
	}

	public function getCourseCode(){
		return $this->course['code'];
	}

	public function getAdviser(){
		return $this->course['adviser'];
	}

	

	public function removeStudent($student_name){
		$course_code = $this->course['code'];
		$course_student_array_query = pg_query($this->db, "SELECT students_array FROM course WHERE code='$course_code'");
		$course_student_array = pg_fetch_array($course_student_array_query);
		$course_array = $course_student_array['students_array'];
		if((strpos($course_array,",".$student_name.",") !== false) || (strpos($course_array,$student_name.",") !== false)){
			$new_course_array = str_replace($student_name.",","",$course_array);
		} else if((strpos($course_array,",".$student_name) !== false)) {
			$new_course_array = str_replace(",".$student_name,"",$course_array);
		} else if((strpos($course_array,"{".$student_name."}") !== false)) {
			$new_course_array = str_replace($student_name,"",$course_array);
		} else {
			$new_course_array = str_replace(",".$student_name,"",$course_array);
		}
		$course_query = pg_query($this->db, "UPDATE course SET students_array= '$new_course_array' WHERE code='$course_code'");
	}	

	public function addStudent($student_to_add){
		$course_code = $this->course['code'];
		$course_student_array_query = pg_query($this->db, "SELECT students_array FROM course WHERE code='$course_code'");
		$course_student_array = pg_fetch_array($course_student_array_query);
		$course_array = $course_student_array['students_array'];
		if((strpos($course_array, "{}") !== false )){
			$new_course_array = str_replace("}",$student_to_add."}", $course_array);
			$course_query = pg_query($this->db, "UPDATE course SET students_array= '$new_course_array' WHERE code='$course_code'");
		} else {
			$new_course_array = str_replace("}",",".$student_to_add."}",$course_array);
			$course_query = pg_query($this->db, "UPDATE course SET students_array= '$new_course_array' WHERE code='$course_code'");	
		}
	}


}



 ?>