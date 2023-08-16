<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../database.php';
    include_once '../class/employee.php';
    
    // Admitir únicamente solicitudes HTTP de tipo DELETE 
    if ( $_SERVER['REQUEST_METHOD'] != 'DELETE' ) {
        echo json_encode("Solicitud HTTP no permitida para esta opción de eliminación.");
        die();
    }
     
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new Employee($db);
    
    if ( !isset($_GET['id']) ) {
        http_response_code(404);
        echo json_encode("Tag 'id' not received.");
        die();
    }
    
    $item->id = $_GET['id'];
    
    if ( $item->deleteEmployee() ) {
        echo json_encode("Employee deleted.");
    }    
    else {
        echo json_encode("Data could not be deleted");
    }    
?>