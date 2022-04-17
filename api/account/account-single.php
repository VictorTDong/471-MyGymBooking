<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/db.php';

    $SSN = isset($_GET['SSN']) ? $_GET['SSN'] : die();

    $query = "SELECT * FROM account WHERE SSN = $SSN;";

    if(!$result = mysqli_query($connection, $query))
    {
        http_response_code(404);    
        echo json_encode(array("message" => "Error getting account", "status" => false));
    }
    else
    {
        $count = mysqli_num_rows($result);
        $accountArray = array();
        $accountArray["body"] = array();
        $accountArray["itemCount"] = $count;

        $row = mysqli_fetch_assoc($result);

        if($row['SSN'] != NULL)
        {
            $currElement = array(
                "username" => $row['Username'],
                "firstname" => $row['FirstName'],
                "lastname" => $row['LastName'],
                "startdate" => $row['Startdate'],
                "accounttype" => $row['AccountType'],
                "vaccination" => $row['VaccinationStatus'],
                "birthdate" => $row['BirthDate'],
                "certification" => $row['Certification'],
                "ssn" => $row['SSN'],
                "responsibilities" => $row['Responsibilities'],
                "password" => $row['Password']
            );
            array_push($accountArray["body"], $currElement);
            http_response_code(200);
            echo json_encode($accountArray);
        }
        else
        {
            http_response_code(404);
            echo json_encode(array("message" => "No accounts found.", "status" => false));
        }
    }
?>