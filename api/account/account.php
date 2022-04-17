<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../../config/db.php';

    $query = "SELECT * FROM account;";

    if(!$result = mysqli_query($connection, $query))
    {
        http_response_code(404);
        echo json_encode(array("message" => "Error getting accounts", "status" => false));
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
                    "username" => $row['Username'],
                    "firstname" => $row['FirstName'],
                    "lastname" => $row['LastName'],
                    "startdate" => $row['Startdate'],
                    "accounttype" => $row['AccountType'],
                    "vaccination" => $row['VaccinationStatus'],
                    "birthdate" => $row['BirthDate'],
                    "certification" => $row['Certification'],
                    "ssn" => $row['SSN'],
                    "password" => $row['Password']
                );
                array_push($array["body"], $currElement);
            }
            http_response_code(200);
            echo json_encode($array);
        }
        else
        {
            http_response_code(404);
            echo json_encode(array("message" => "No accounts found.", "status" => false));
        }
    }
?>