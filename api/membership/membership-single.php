<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/db.php';

    $MembershipID = isset($_GET['MembershipID']) ? $_GET['MembershipID'] : die();

    $query = "SELECT * FROM membership WHERE MembershipID = $MembershipID;";

    if(!$result = mysqli_query($connection, $query))
    {
        http_response_code(404);
        echo json_encode(array("message" => "Error finding membership", "status" => false));
    }
    else
    {
        $count = mysqli_num_rows($result);
        $array = array();
        $array["body"] = array();
        $array["itemCount"] = $count;

        $row = mysqli_fetch_assoc($result);

        if($row['MembershipID'] != NULL)
        {
            $currElement = array(
                "MembershipID" => $row['MembershipID'],
                "SSN" => $row['SSN'],
                "PaymentDate" => $row['PaymentDate']
            );
            array_push($array["body"], $currElement);
            http_response_code(200);
            echo json_encode($array);
        }
        else
        {
            http_response_code(404);
            echo json_encode(array("message" => "Membership not found.", "status" => false));
        }
    }
?>