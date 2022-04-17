<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/db.php';

    $data = json_decode(file_get_contents("php://input"));

    if($data->SSN !== '' && $data->Date !== '' && $data->StartTime !== '' && $data->EndTime !== ''&& $data->RoomNum !== '')
    {
        $createQuery = "INSERT INTO `shift` (`ShiftID`, `SSN`, `Date`, `StartTime`, `EndTime`, `RoomNum`) VALUES (Default , ? , ? , ? , ?, ?);";

        $statement = $connection->prepare($createQuery);

        $SSN = $data->SSN;
        $Date = $data->Date;
        $StartTime = $data->StartTime;
        $EndTime = $data->EndTime;
        $RoomNum = $data->RoomNum;

        $SSN = htmlspecialchars(strip_tags($SSN));
        $Date = htmlspecialchars(strip_tags($Date));
        $StartTime = htmlspecialchars(strip_tags($StartTime));
        $EndTime = htmlspecialchars(strip_tags($EndTime));
        $RoomNum = htmlspecialchars(strip_tags($RoomNum));


        if($statement)
        {	
            $statement->bind_param("sssss", $SSN, $Date, $StartTime, $EndTime, $RoomNum);
          
            if($statement->execute())
            {
                $output = array("msg" => "Shift created","status" => true);
            }
            else
            {
                $output = array("msg" => "Error creating shift for SSN: ".$SSN, "status" => false);
            }
        }
        else
        {
            $output = array("msg" => "Request method not accepted","status" => false);
        }
    }
    else
    {
        $output = array("msg" => "Missing required fields", "status" => false);
    }
    header('Content-type: application/json');
    echo json_encode($output);
?>