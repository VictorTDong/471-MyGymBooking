<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/db.php';

    $BookingID = isset($_GET['BookingID']) ? $_GET['BookingID'] : die();

    $query = "SELECT * FROM schedule WHERE BookingID = $BookingID;";

    if(!$result = mysqli_query($connection, $query))
    {
        http_response_code(404);
        echo json_encode(array("message" => "Error finding BookingID", "status" => false));
    }
    else
    {
        $count = mysqli_num_rows($result);
        $array = array();
        $array["body"] = array();
        $array["itemCount"] = $count;

        $row = mysqli_fetch_assoc($result);

        if($row['BookingID'] != NULL)
        {
            $currElement = array(
                "BookingID" => $row['BookingID'],
                "ClassID" => $row['ClassID'],
                "RoomNum" => $row['RoomNum'],
                "ScheduleUsername" => $row['ScheduleUsername']
            );
            array_push($array["body"], $currElement);
            http_response_code(200);
            echo json_encode($array);
        }
        else
        {
            http_response_code(404);
            echo json_encode(array("message" => "Booking not found.", "status" => false));
        }
    }
?>