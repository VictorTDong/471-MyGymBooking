<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/db.php';

    $SSN = htmlspecialchars(isset($_GET['SSN']) ? $_GET['SSN'] : die());

    $deleteQuery = "DELETE FROM account WHERE SSN = '$SSN';";   

    if($SSN !== '')
    {
        if(!$result = mysqli_query($connection, $deleteQuery))
        {
            http_response_code(404);
            echo json_encode(array("message" => "Account could not be deleted", "status" => false));
        }
        else
        {
            http_response_code(200);
            echo json_encode(array("message" => "Account with SSN: ".$SSN." deleted", "status" => true ));
        }
    }
    else
    {
        http_response_code(404);
        echo json_encode(array("message" => "Misisng required fields", "status" => false));
    }
?>