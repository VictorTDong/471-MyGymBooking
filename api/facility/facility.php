<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../../config/db.php';
    $query = "SELECT * FROM facility;";

    if(!$result = mysqli_query($connection, $query))
    {
        http_response_code(404);
        echo json_encode(array("message" => "Error getting facilitiess", "status" => false));
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
                    "RoomNum" => $row['RoomNum'],
                    "MaxOccupancy" => $row['MaxOccupancy'],
                    "Cleaned" => $row['Cleaned'],
                    "FacilityName" => $row['FacilityName']
                );
                array_push($array["body"], $currElement);
            }
            http_response_code(200);
            echo json_encode($array);
        }
        else
        {
            http_response_code(404);
            echo json_encode(array("message" => "No facilities found.", "status" => false));
        }
    }
?>