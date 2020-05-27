<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

define('HOST','localhost');
define('USER','root');
define('PASS','');
define('PRIMARY_DB','status_book');

class StudentDetails {

  public $connection;

  function __construct(){
    $this->connection = new mysqli(HOST,USER,PASS,PRIMARY_DB);
    
    if($this->connection->connect_error){
      http_response_code($this->connection->connect_errno);
      echo json_encode(array( 'type'=>'FAILURE TO CONNECT DB' ));
      exit();
    }
    
  }

  function getStudentDetails($department){   
    if($department){
      $query = $this->connection->prepare("SELECT * FROM student_details WHERE department='$department' ORDER BY id ASC");
    }
    else {
      $query = $this->connection->prepare("SELECT * FROM student_details WHERE batch='2017_2021' ORDER BY id ASC");
    }
    
    $query->execute();
    $result = $query->get_result();
    $query->close();
    
    if($result->num_rows === 0) {
      http_response_code(500);
      echo  json_encode(array( 'type'=>'FAILED' ));
      exit();
    }
    
    if($result) {
      $value = array();
      while($row = $result->fetch_assoc()){
        ARRAY_PUSH($value, array(
          'id'=> $row['id'],
          'regno'=> $row['regno'],
          'department'=> $row['department'],
          'batch'=> $row['batch'],
          'first_name'=> $row['first_name'],
          'last_name'=> $row['last_name'],
          'dob'=> $row['dob'],
          'gender'=> $row['gender'],
          'email_id' => $row['email_id'],
          'mobile_number'=> $row['mobile_number'],
          'address' => $row['address'],
          'relegion'=> $row['relegion'],
          'nationality'=> $row['nationality'],
        ));
      }
      http_response_code(200);
      echo json_encode(array("type"=>"SUCCESS","value"=>$value));
    } else {
      http_response_code(500);
      echo  json_encode(array( 'type'=>'FAILED' ));
    }
    
  }

  function addStudentDetails($data){
    
    $query = $this->connection->prepare("INSERT INTO student_details (first_name,last_name, dob,gender,email_id,mobile_number,address,relegion,nationality) VALUES (?,?,?,?,?,?,?,?,?)");
    $query->bind_param("sssssssss", $data->first_name, $data->last_name, $data->dob, $data->gender, $data->email_id, $data->mobile_number, $data->address, $data->relegion, $data->nationality);
    $insertData = $query->execute();
    $newId = $query->insert_id;
    $query->close();

    if($insertData && $newId) {
      http_response_code(201);
      echo  json_encode(array( 'type'=>'SUCCESS',"value"=>$newId ));
    } else {
      http_response_code(500);
      echo  json_encode(array( 'type'=>'FAILED' ));
    }    

  }
  
  function updateStudentDetails($id, $data){

    $query = $this->connection->prepare("UPDATE student_details SET regno=?, first_name=?, last_name=?, dob=?, gender=?, email_id=?, mobile_number=?, address=?, relegion=?, nationality=? WHERE id = ?");
    $query->bind_param('isssssssssi', $data->regno, $data->first_name, $data->last_name, $data->dob, $data->gender, $data->email_id, $data->mobile_number, $data->address, $data->relegion, $data->nationality, $id);
    $updateData = $query->execute();
    $query->close();

    if($updateData) {
      http_response_code(200);
      echo  json_encode(array( 'type'=>'SUCCESS' ));
    } else {
      http_response_code(500);
      echo  json_encode(array( 'type'=>'FAILED' ));
    }
    
  }

  function deleteStudentDetails($id){

    $query = $this->connection->prepare("DELETE FROM student_details WHERE id = ?");
    $query->bind_param('i', $id);
    $deleteData = $query->execute();
    $query->close();

    if($deleteData) {
      http_response_code(200);
      echo  json_encode(array( 'type'=>'SUCCESS' ));
    } else {
      http_response_code(500);
      echo  json_encode(array( 'type'=>'FAILED' ));
    }
    
  }

}
?>