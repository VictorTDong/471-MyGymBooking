<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/db.php';

    $data = json_decode(file_get_contents("php://input"));

    if($data->Username !== '' && $data->FirstName !== '' && $data->LastName !== '' && $data->AccountType !== '' && $data->VaccinationStatus !== '' && $data->BirthDate !== '' && $data->SSN !== '' && $data->password !== '' )
    {
        $createQuery = "INSERT INTO `account` (`Username`, `FirstName`, `LastName`, `Startdate`, `AccountType`, `VaccinationStatus`, `BirthDate`, `Certification`, `SSN`, `Responsibilities`, `Password`) VALUES (? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?);";

        $statement = $connection->prepare($createQuery);

        $Username = $data->Username;
        $FirstName = $data->FirstName;
        $LastName = $data->LastName;
        $Startdate = date("Y-m-d");
        $AccountType = $data->AccountType;
        $VaccinationStatus = $data->VaccinationStatus;
        $BirthDate = $data->BirthDate;
        $Certification = $data->Certification;
        $SSN = $data->SSN;
        $Responsibilities = $data->Responsibilities;
        $password = $data->password;   

        $Username = htmlspecialchars(strip_tags($Username));
        $FirstName = htmlspecialchars(strip_tags($FirstName));
        $LastName = htmlspecialchars(strip_tags($LastName));
        $Startdate = htmlspecialchars(strip_tags($Startdate));
        $AccountType = htmlspecialchars(strip_tags($AccountType));
        $VaccinationStatus = htmlspecialchars(strip_tags($VaccinationStatus));
        $BirthDate = htmlspecialchars(strip_tags($BirthDate));
        $Certification = htmlspecialchars(strip_tags($Certification));
        $SSN = htmlspecialchars(strip_tags($SSN));
        $Responsibilities = htmlspecialchars(strip_tags($Responsibilities));
        $password = htmlspecialchars(strip_tags($password));

        if($statement)
        {	
            $statement->bind_param("sssssssssss",$Username, $FirstName, $LastName, $Startdate, $AccountType, $VaccinationStatus, $BirthDate, $Certification, $SSN, $Responsibilities, $password);
          
            if($statement->execute())
            {
                http_response_code(200);
                $output = array("msg" => "Account created", "status" => true);
            }
            else
            {
                http_response_code(404);
                $output = array("msg" => "Error creating account, account with SSN: ".$SSN, "status" => false);
            }
        }
        else
        {
            http_response_code(404);
            $output = array("msg" => "Request method not accepted","status" => false);
        }
    }
    else
    {
        http_response_code(404);
        $output = array("msg" => "Missing required fields", "status" => false);
    }
    header('Content-type: application/json');
    echo json_encode($output);
?>