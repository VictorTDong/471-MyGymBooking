<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/db.php';

    $SSN = htmlspecialchars(isset($_GET['SSN']) ? $_GET['SSN'] : die());
    $updateFirstname = htmlspecialchars(isset($_GET['Firstname']) ? $_GET['Firstname'] : die());
    $updateLastname = htmlspecialchars(isset($_GET['Lastname']) ? $_GET['Lastname'] : die());
    $updateVaccinationStatus = htmlspecialchars(isset($_GET['VaccinationStatus']) ? $_GET['VaccinationStatus'] : die());
    $updatePassword = htmlspecialchars(isset($_GET['Password']) ? $_GET['Password'] : die());

    $updateQuery = "UPDATE account 
                    SET FirstName = '$updateFirstname', LastName = '$updateLastname',
                        VaccinationStatus= '$updateVaccinationStatus', Password = '$updatePassword'
                    WHERE SSN = '$SSN';";

    $query = "SELECT * FROM account WHERE SSN = '$SSN';";
   

    if(!$result = mysqli_query($connection, $updateQuery))
    {
        http_response_code(404);
        echo json_encode(array("message" => "Account could not be updated", "status" => false));
    }
    else
    {
        $result = mysqli_query($connection, $query);

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
            echo json_encode(array("message" => "Account updated", "status" => True));
        }
        else
        {
            http_response_code(404);
            echo json_encode(array("message" => "No accounts found.", "status" => false));
        }
    }
?>