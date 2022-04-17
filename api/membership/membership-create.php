<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/db.php';

    $data = json_decode(file_get_contents("php://input"));

    if($data->SSN !== '')
    {
        $createQuery = "INSERT INTO `membership` (`MembershipID`, `SSN`, `PaymentDate`) VALUES (Default , ? , ?);";

        $statement = $connection->prepare($createQuery);

        $SSN = $data->SSN;
        $PaymentDate = date("Y-m-d");

        $SSN = htmlspecialchars(strip_tags($SSN));
        $PaymentDate = htmlspecialchars(strip_tags($PaymentDate));


        if($statement)
        {	
            $statement->bind_param("ss", $SSN, $PaymentDate);
          
            if($statement->execute())
            {
                http_response_code(200);
                $output = array("msg" => "Membership created", "status" => true);
            }
            else
            {
                http_response_code(404);
                $output = array("msg" => "Error creating membership for SSN: ".$SSN, "status" => false);
            }
        }
        else
        {
            http_response_code(404);
            $output = array("msg" => "Request method not accepted","status" => false);
        }
    }
    else
    {
        http_response_code(404);
        $output = array("msg" => "Missing required fields", "status" => false);
    }
    header('Content-type: application/json');
    echo json_encode($output);
?>