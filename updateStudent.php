<?PHP 
  require_once('connection.php');
  
  if(isset($_REQUEST['id'])){
    $id = $_REQUEST['id'];
    $SQL = mysqli_query($primary_db, "SELECT * FROM student_details WHERE id = $id ORDER BY id ASC");
  } else {
    $SQL = mysqli_query($primary_db, "SELECT * FROM student_details ORDER BY id ASC");
  }

  $result = array();
  
  if($SQL){
    while($row = mysqli_fetch_array($SQL)){
      ARRAY_PUSH($result,array(
        'id'=> $row['id'],
        'regno'=> $row['regno'],
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
    echo json_encode(array("type"=>"SUCCESS","value"=>$result));
  }
  else {
    http_response_code(404);
    echo json_encode(array("type"=>"FAILURE"));
  }

  mysqli_close($primary_db);
 ?>