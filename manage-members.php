<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
  require 'config/db.php';
  session_start();

  //Handle new member CREATE
  if(isset($_POST['addButton']))
  {
    $insertSSN = htmlspecialchars($_POST['SSN']);
    $insertFirstName = htmlspecialchars($_POST['FirstName']);
    $insertLastName = htmlspecialchars($_POST['LastName']);
    $insertBirthdate = htmlspecialchars($_POST['Birthdate']);
    $insertUsername = htmlspecialchars($_POST['Username']);
    $insertPassword = htmlspecialchars($_POST['Password']);
    $insertVaccination= htmlspecialchars($_POST['Vaccination']);
    $client= htmlspecialchars('0');
    $date = date("Y-m-d");

    $createClientQuery = "INSERT INTO `account` (`Username`, `FirstName`, `LastName`, `Startdate`, `AccountType`, `VaccinationStatus`, `BirthDate`, `Certification`, `SSN`, `Password`) VALUES ('$insertUsername','$insertFirstName','$insertLastName', '$date', '0','$insertVaccination','$insertBirthdate',NULL,'$insertSSN','$insertPassword');";

    $createMember = "INSERT INTO `membership` (`MembershipID`, `SSN`, `PaymentDate`) VALUES (DEFAULT,'$insertSSN', '$date');";

    if(empty($insertSSN) || empty($insertSSN) || empty($insertFirstName) || empty($insertLastName) || empty($insertBirthdate) || empty($insertUsername) || empty($insertPassword) || empty($insertVaccination))
    {
      header("Location: manage-members.php?msg=Missing required fields&type=error&SSN=".$insertSSN."&FirstName=".$insertFirstName."&LastName=".$insertLastName."&Birthdate=".$insertBirthdate."&Username=".$insertUsername."&Password=".$insertPassword."&Vaccination=".$insertVaccination."&AccountType=".$client);
    }

    if(!$result = mysqli_query($connection, $createClientQuery))
    {
      header("Location: manage-members.php?msg=An error has occurred while adding member&type=error&SSN=".$insertSSN."&FirstName=".$insertFirstName."&LastName=".$insertLastName."&Birthdate=".$insertBirthdate."&Username=".$insertUsername."&Password=".$insertPassword."&Vaccination=".$insertVaccination."&AccountType=".$client);
    }
    else
    {
        if(!$result = mysqli_query($connection, $createMember))
        {
            header("Location: manage-members.php?msg=An error has occurred while adding membership&type=error");
        }
        else
        {
        header("Location: manage-members.php?msg=Member added&type=success&SSN=".$insertSSN."&FirstName=".$insertFirstName."&LastName=".$insertLastName."&Birthdate=".$insertBirthdate."&Username=".$insertUsername."&Password=".$insertPassword."&Vaccination=".$insertVaccination);
        }
    }
  }
?>

<head>
  <title>Register member</title>
  <link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Ubuntu&display=swap"
    rel="stylesheet">


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/18595e908a.js" crossorigin="anonymous"></script>

  <!-- Bootstrap scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <section id="nav">
      <nav class="navbar navbar-expand-md navbar-light">
        <a class="navbar-brand" href="#">
          <i class="fa-solid fa-clipboard-user fa-1x"></i>
          MyGym Booking
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
          aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
          <a class="nav-item nav-link" href="manager-home.php">Home <span class="sr-only"></span></a>
          </div>
        </div>
        <div class="login">
            <a href="login.php" class="login btn btn-dark" type="button">Sign Out</a>
        </div>
      </nav>
  </section>
  <section id="about">
  <form action = "#" method = "post">
    <div class="welcome row">
      <div class="col">
        <h1>Register member</h1>
      </div>
    </div>
    <div class="schedule row">
      <table class="table">
          <thead >
            <tr>
              <th scope="col">SSN</th>
              <th scope="col">First Name</th>
              <th scope="col">Last Name</th>
              <th scope="col">Birthdate</th>            
            </tr>
          </thead> 
              <tr>
                <td>
                    <input id = "SSN" type="text" name="SSN" value = <?php echo isset($_GET['SSN']) ? $_GET['SSN'] : ""?>>
                </td>
                <td> 
                  <input id = "FirstName" type="text" name="FirstName" value = <?php echo isset($_GET['FirstName']) ? $_GET['FirstName'] : ""?> >
                </td>
                <td>
                  <input id = "LastName" type="text" name="LastName" value = <?php echo isset($_GET['LastName']) ? $_GET['LastName'] : ""?> >
                </td>
                <td>
                  <input id = "Birthdate" type="date" name="Birthdate" value = <?php echo isset($_GET['Birthdate']) ? $_GET['Birthdate'] : ""?> >
                </td>
              </tr>
          </tbody>
          <thead >    
            <th scope="col">Username</th>
            <th scope="col">Password</th>
            <th scope="col">Vaccination status</th>  
          </thead>
          <tbody>
            <td>
                <input id = "Username" type="text" name="Username" value = <?php echo isset($_GET['Username']) ? $_GET['Username'] : ""?>>
            </td>
            <td>
                <input id = "Password" type="text" name="Password" value = <?php echo isset($_GET['Password']) ? $_GET['Password'] : ""?>>
            </td>
            <td>
                <input id = "Vaccination" type="text" name="Vaccination" value = <?php echo isset($_GET['Vaccination']) ? $_GET['Vaccination'] : ""?>>
            </td>
          </tbody>
        </table>
        <td>
            <input type="submit" class="btn btn-success" name="addButton" value = "Add Member"></input>
        </td>
    </div>
    </form>
  </section>
</body>
</html>