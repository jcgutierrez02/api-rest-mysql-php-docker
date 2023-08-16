<?php


    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $input = json_decode(file_get_contents("php://input"));
   /* 
    $file = $_FILES['avatar'];
    $temp = $file['tmp_name'];
    $target_file = './targetfilename.jpg';
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
  */     
   
    echo json_encode("OK " + htmlspecialchars(strip_tags($input->username)));