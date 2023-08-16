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
    $input = array();
    
    if ( isset($_POST['name']) ) 
    {
        $item->id = $_GET['id'];
        
        // sanitize
        $item->name = htmlspecialchars(strip_tags($_POST['name']));
        $item->email = htmlspecialchars(strip_tags($_POST['email']));
        $item->age = htmlspecialchars(strip_tags($_POST['age']));
        $item->designation = htmlspecialchars(strip_tags($_POST['designation']));
        if ( isset($_FILES['perfil']['name']) ) {
            move_uploaded_file($_FILES["perfil"]["tmp_name"], "./".$_FILES['perfil']['name']);
            $item->perfil = $_FILES['perfil']['name'];
        }
        else
            $item->perfil = null;

        $item->created = date('Y-m-d H:i:s');
    }
    // Admitir únicamente solicitudes HTTP de tipo PUT si no vienen desde FORM HTML
    else if ( $_SERVER['REQUEST_METHOD'] == 'PUT' )
    {    
        $input = json_decode(file_get_contents("php://input"));
    
        $item->id = $_GET['id'];

        $item->getSingleEmployee();
        
         // sanitize
        if ( isset($input->name) ) 
            $item->name = htmlspecialchars(strip_tags($input->name));
        if ( isset($input->email) )     
            $item->email = htmlspecialchars(strip_tags($input->email));
        if ( isset($input->age) )     
            $item->age = htmlspecialchars(strip_tags($input->age));
        if ( isset($input->designation) )     
            $item->designation = htmlspecialchars(strip_tags($input->designation));
        $item->created = date('Y-m-d H:i:s');
        
    }
    else {
        echo json_encode("Solicitud HTTP no permitida para esta opción de modificación.");
        die();
    }
          
    if ( $item->updateEmployee() ) {
        $resultado = array("mensaje"=>"Empleado modificado satisfactoriamente", "empleado"=>$item);
        echo json_encode($resultado); 
    }    
    else {
        echo json_encode("Data could not be updated");
    }    