<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../../config/db.php';
    $query = "SELECT * FROM shift;";

    if(!$result = mysqli_query($connection, $query))
    {
        http_response_code(404);
        echo json_encode(array("message" => "Error getting shifts", "status" => false));
    }
    else
    {
        $count = mysqli_num_rows($result);
        $array = array();
        $array["body"] = array();
        $array["itemCount"] = $count;

        if($count > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $currElement = array(
                    "ShiftID " => $row['ShiftID'],
                    "SSN" => $row['SSN'],
                    "Date" => $row['Date'],
                    "StartTime" => $row['StartTime'],
                    "EndTime" => $row['EndTime'],
                    "RoomNum " => $row['RoomNum']
                );
                array_push($array["body"], $currElement);
            }
            http_response_code(200);
            echo json_encode($array);
        }
        else
        {
            http_response_code(404);
            echo json_encode(array("message" => "No shifts found.", "status" => false));
        }
    }
?>