<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/db.php';

    $ShiftID = htmlspecialchars(isset($_GET['ShiftID']) ? $_GET['ShiftID'] : die());
    $Date = htmlspecialchars(isset($_GET['Date']) ? $_GET['Date'] : die());
    $StartTime = htmlspecialchars(isset($_GET['StartTime']) ? $_GET['StartTime'] : die());
    $EndTime = htmlspecialchars(isset($_GET['EndTime']) ? $_GET['EndTime'] : die());
    $RoomNum = htmlspecialchars(isset($_GET['RoomNum']) ? $_GET['RoomNum'] : die());

    $updateQuery = "UPDATE shift 
                    SET Date = '$Date', StartTime = '$StartTime', EndTime  = '$EndTime', RoomNum  = '$RoomNum'
                    WHERE ShiftID = '$ShiftID';";   

    if($Date !== '' && $StartTime !== '' && $EndTime !== '' && $RoomNum !== '')
    {
        if(!$result = mysqli_query($connection, $updateQuery))
        {
            http_response_code(404);
            echo json_encode(array("message" => "Shift could not be updated", "status" => false));
        }
        else
        {
            http_response_code(200);
            echo json_encode(array("message" => "Shift updated", "status" => True));
        }
    }
?>