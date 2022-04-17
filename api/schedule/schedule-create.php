<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/db.php';

    $data = json_decode(file_get_contents("php://input"));

    if($data->ClassID !== '' && $data->RoomNum !== '' && $data->ScheduleUsername !== '')
    {
        $createQuery = "INSERT INTO `schedule` (`BookingID`, `ClassID`, `RoomNum`, `ScheduleUsername`) VALUES (Default , ? , ?, ?);";

        $statement = $connection->prepare($createQuery);

        $ClassID = $data->ClassID;
        $RoomNum = $data->RoomNum;
        $ScheduleUsername = $data->ScheduleUsername;

        $ClassID = htmlspecialchars(strip_tags($ClassID));
        $RoomNum = htmlspecialchars(strip_tags($RoomNum));
        $ScheduleUsername = htmlspecialchars(strip_tags($ScheduleUsername));

        if($statement)
        {	
            $statement->bind_param("sss", $ClassID, $RoomNum, $ScheduleUsername);
          
            if($statement->execute())
            {
                http_response_code(200);
                $output = array("msg" => "Booking created", "status" => true);
            }
            else
            {
                http_response_code(404);
                $output = array("msg" => "Error creating booking for username: ".$ScheduleUsername,  "status" => false);
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