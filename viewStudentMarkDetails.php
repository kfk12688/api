<?PHP 
    require_once('connection.php');
    $SQL = mysqli_query($conn, "SELECT * FROM mark_details ORDER BY id ASC");

    $result = array();

    while($row = mysqli_fetch_array($SQL)){
        ARRAY_PUSH($result,array(
            'id'=> $row['id'],
            'regno'=> $row['regno'],
            'name'=> $row['name'],
            'class_test1'=> $row['class_test1'],
            'class_test2'=> $row['class_test2'],
            'class_test3'=> $row['class_test3'],
            'iae1' => $row['iae1'],
            'iae2'=> $row['iae2'],
            'iae3' => $row['iae3'],
            'model_exam' => $row['model_exam'],
            'university_exam'=> $row['university_exam']
        ));
    }
    echo json_encode($result);

    mysqli_close($conn);
 ?>