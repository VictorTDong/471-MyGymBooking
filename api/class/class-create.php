<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/db.php';

    $data = json_decode(file_get_contents("php://input"));

    if($data->Name !== '' && $data->Time !== '' && $data->NumParticipants !== '' && $data->RoomNum !== '')
    {
        $createQuery = "INSERT INTO `class` (`ClassID`, `Name`, `Time`, `NumParticipants`, `RoomNum`) VALUES (Default , ? , ? , ? , ?);";

        $statement = $connection->prepare($createQuery);

        $Name = $data->Name;
        $Time = $data->Time;
        $NumParticipants = $data->NumParticipants;
        $RoomNum = $data->RoomNum;

        $Name = htmlspecialchars(strip_tags($Name));
        $Time = htmlspecialchars(strip_tags($Time));
        $NumParticipants = htmlspecialchars(strip_tags($NumParticipants));
        $RoomNum = htmlspecialchars(strip_tags($RoomNum));


        if($statement)
        {	
            $statement->bind_param("ssss", $Name, $Time, $NumParticipants, $RoomNum);
          
            if($statement->execute())
            {
                http_response_code(200);
                $output = array("msg" => "Class created", "status" => true);
            }
            else
            {
                http_response_code(404);
                $output = array("msg" => "Error creating class for: ".$Name, "status" => false);
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