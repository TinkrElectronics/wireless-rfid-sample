<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('index.php');
$filename = 'data.json';

$uid = $input->get('uid');
$datetime = date("Y/m/d H:i:s");

if(!empty($uid)){
    $data_new = array(
        'uid' => $uid,
        'datetime' => $datetime
    );
    
    $data_json = file_get_contents($filename);
    $data_array = json_decode($data_json, true);
    
    array_push($data_array,$data_new);
    
    $data_json = json_encode($data_array, JSON_PRETTY_PRINT);
    
    if(file_put_contents($filename, $data_json)) {
        http_response_code(201);
    
        echo json_encode(array(
            'message' => 'Data successfully saved.',
            'data' => $data_new
        ));
    }else{
        http_response_code(503);
     
        echo json_encode(array("message" => "Unable to save data."));
    }
}
?>