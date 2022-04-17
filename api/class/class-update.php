<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/db.php';

    $ClassID = htmlspecialchars(isset($_GET['ClassID']) ? $_GET['ClassID'] : die());
    $Name = htmlspecialchars(isset($_GET['Name']) ? $_GET['Name'] : die());
    $Time = htmlspecialchars(isset($_GET['Time']) ? $_GET['Time'] : die());
    $RoomNum = htmlspecialchars(isset($_GET['RoomNum']) ? $_GET['RoomNum'] : die());

    $updateQuery = "UPDATE class 
                    SET Name = '$Name', Time = '$Time', RoomNum  = '$RoomNum'
                    WHERE ClassID = '$ClassID';";   

    if($ClassID !== '' && $Name !== '' && $Time !== '' && $RoomNum !== '' && $RoomNum !== '')
    {
        if(!$result = mysqli_query($connection, $updateQuery))
        {
            http_response_code(404);
            echo json_encode(array("message" => "Class could not be updated", "status" => false));
        }
        else
        {
            http_response_code(200);
            echo json_encode(array("message" => "Class updated", "status" => True));
        }
    }
?>