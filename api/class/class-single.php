<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/db.php';

    $ClassID = isset($_GET['ClassID']) ? $_GET['ClassID'] : die();

    $query = "SELECT * FROM class WHERE ClassID = $ClassID;";

    if(!$result = mysqli_query($connection, $query))
    {
        http_response_code(404);
        echo json_encode(array("message" => "Error getting classes", "status" => false));
    }
    else
    {
        $count = mysqli_num_rows($result);
        $array = array();
        $array["body"] = array();
        $array["itemCount"] = $count;

        $row = mysqli_fetch_assoc($result);

        if($row['ClassID'] != NULL)
        {
            $currElement = array(
                "ClassID" => $row['ClassID'],
                "Name" => $row['Name'],
                "Time" => $row['Time'],
                "NumParticipants" => $row['NumParticipants'],
                "RoomNum " => $row['RoomNum']
            );
            array_push($array["body"], $currElement);
            http_response_code(200);
            echo json_encode($array);
        }
        else
        {
            http_response_code(404);
            echo json_encode(array("message" => "No classes found.", "status" => false));
        }
    }
?>