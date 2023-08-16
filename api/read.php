<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../database.php';
    include_once '../class/employee.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Employee($db);

    $stmt = $items->getEmployees();
    $itemCount = $stmt->rowCount();

    if ( $itemCount > 0 ) 
    {    
        $employeeArr = array();
        $employeeArr["itemCount"] = $itemCount;
        $employeeArr["body"] = array();
       
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) 
        {          
            extract($row);
            $e = array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "age" => $age,
                "designation" => $designation,
                "perfil" => base64_encode($perfil),
                "created" => $created
            );

            array_push($employeeArr["body"], $e);
        }
        
        echo json_encode($employeeArr);
    }
    else
    {
        http_response_code(404);
        echo json_encode(array("message" => "No record found."));
    }