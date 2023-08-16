<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../database.php';
    include_once '../class/employee.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Employee($db);

    if ( !isset($_GET['id']) ) {
        http_response_code(404);
        echo json_encode("Tag 'id' not received.");
        die();
    }
    
    $item->id = $_GET['id'];
        
    $item->getSingleEmployee();

    if ( $item->name != null ) {
        // create array
        $emp_arr = array(
            "id" =>  $item->id,
            "name" => $item->name,
            "email" => $item->email,
            "age" => $item->age,
            "designation" => $item->designation,
            "perfil" => base64_encode($item->perfil),
            "created" => $item->created
        );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }     
    else {
        http_response_code(404);
        echo json_encode("Employee not found.");
    }