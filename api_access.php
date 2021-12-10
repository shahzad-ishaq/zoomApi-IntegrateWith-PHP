<?php
$db = 'api_db';
$link = mysqli_connect('localhost', 'root', '', $db);
if (!$link) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());
}
mysqli_get_host_info($link);
$query = "SELECT u.id,u.status FROM users u";
$stmt = mysqli_query($link, $query);
$num = mysqli_num_rows($stmt);
 if($num>0){
    $data_arr=array();
    $data_arr["records"]=array();
    while ($row = mysqli_fetch_object($stmt)){
        $single_item=array(
            "id" => $row->id,
            "status" => $row->status
        );
        array_push($data_arr["records"], $single_item);
    }
    // response code - 200 OK
    http_response_code(200);
    
    echo json_encode($data_arr);
}else{
     // response code - 404 Not found
     http_response_code(404);    
     echo json_encode(
         array("message" => "No record found.")
     );
 }
