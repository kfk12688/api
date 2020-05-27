<?php

require_once('studentDetails.php');
$student_details = new StudentDetails();

$id = null;
$request_method = $_SERVER['REQUEST_METHOD'];
$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if (array_key_exists(3, $uriSegments)) {
  $id = $uriSegments[3];
}

if($request_method === 'GET') {
  
  $department = isset($_GET['department']) ? $_GET['department']: 0; 
  // echo $department;
  $student_details->getStudentDetails($department);
  
} else if($request_method === 'POST' ) {

  $input_data = json_decode(file_get_contents("php://input"));
  $student_details->addStudentDetails($input_data);

} else if($request_method === 'PUT' ) {

  $input_data = json_decode(file_get_contents("php://input"));
  $student_details->updateStudentDetails($id, $input_data);

} else if($request_method === 'DELETE' ) {
  
  $student_details->deleteStudentDetails($id);

} else {
  http_response_code(500);
  echo  json_encode(array( 'type'=>'FAILED' ));
  exit();
}

?>