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
    
    if ( isset($_POST['name']) ) // Entrada de datos por formulario
    {
        // sanitize
        $item->name = htmlspecialchars(strip_tags($_POST['name']));
        $item->email = htmlspecialchars(strip_tags($_POST['email']));
        $item->age = htmlspecialchars(strip_tags($_POST['age']));
        $item->designation = htmlspecialchars(strip_tags($_POST['designation']));
        $item->created = date('Y-m-d H:i:s');
        if ( isset($_FILES['perfil']['name']) ) {
            move_uploaded_file($_FILES["perfil"]["tmp_name"], "./".$_FILES['perfil']['name']);
            $item->perfil = $_FILES['perfil']['name'];
        }
        else
            $item->perfil = null;
    }
    else  // Entrada de datos por JSON
    {
        $input = json_decode(file_get_contents("php://input"));     
        
        // sanitize
        $item->name = htmlspecialchars(strip_tags($input->name));
        $item->email = htmlspecialchars(strip_tags($input->email));
        $item->age = htmlspecialchars(strip_tags($input->age));
        $item->designation = htmlspecialchars(strip_tags($input->designation));
        $item->created = date('Y-m-d H:i:s');  
    }
       
    if ( $item->createEmployee() ) {
        $resultado = array("mensaje"=>"Empleado creado satisfactoriamente", "empleado"=>$item);
        echo json_encode($resultado); 
    }    
    else {
        echo json_encode('Employee could not be created.');
    }    