<?php
require_once('connection.php');

$data = json_decode(file_get_contents("php://input"));

$connect_db = new mysqli(HOST,USER,PASS,PRIMARY_DSB);

if($connect_db->connect_error) {
	$error_code = $connect_db->connect_errno;
	http_response_code($error_code);
	echo json_encode(array( 'type'=>'FAILURE' ));
}
else {
	$SQL = $connect_db -> prepare("INSERT INTO student_details (first_name,last_name, dob,gender,email_id,mobile_number,address,relegion,nationality) VALUES (?,?,?,?,?,?,?,?,?)");
	$SQL -> bind_param("sssssssss",$data->first_name,$data->last_name, $data->dob,$data->gender,$data->email_id,$data->mobile_number,$data->address,$data->relegion,$data->nationality);
	$SQL -> execute(); 
	
	if($SQL) {
		http_response_code(201);
		echo json_encode(array( 'type'=>'SUCCESS' ));
	} else {
		http_response_code(500);
		echo json_encode(array( 'type'=>'FAILED' ));
	}
	
	mysqli_close($connect_db);
}



?>