<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php

require 'config/db.php';
  session_start();


  //handle fetch client READ
  $readQuery = "SELECT * FROM account WHERE AccountType = 0;";

  if (!$fetchedresult = mysqli_query($connection, $readQuery))
  {
    exit("An error occured while fetching the shifts");
  }

  //handle client UPDATE
  if(isset($_GET['updateButton']))
  {
    $username = $_GET['Username'];
    $updateFirstname = $_GET['UpdateFirstName'];
    $updateLastname  = $_GET['UpdateLastName'];
    $updatePassword = $_GET['UpdatePassword'];
    $updateVaccinationStatus = $_GET['UpdateVaccinationStatus'];


    $updateQuery = "UPDATE account 
                    SET FirstName = '$updateFirstname', LastName = '$updateLastname',
                        VaccinationStatus= '$updateVaccinationStatus', Password = '$updatePassword'
                    WHERE UserName = '$username';";
    if(!empty($username) ||!empty($updateFirstname) ||!empty($updateLastname) 
        ||!empty($updatePassword) ||!empty($updateVaccinationStatus) )
    {
      if(!$result = mysqli_query($connection, $updateQuery)){
        echo "error";
      }else{
        header("Location: manage-clients.php?msg=Shift updated&type=success&Username=".$username."&Firstname=".$updateFirstname."&Lastname=".$updateLastname);
      }
    }   
  }
?>

<head>
  <title>Manage Clients</title>
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
            <a class="nav-item nav-link" href="manager-home.php">Home</a>
          </div>
        </div>
        <div class="login">
            <a href="login.php" class="login btn btn-dark" type="button">Sign Out</a>
        </div>
      </nav>
  </section>
  <section id="about">
    <div class="welcome row">
      <div class="col">
        <h1>Manage Clients</h1>
      </div>
    </div>
    <div class="schedule row">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Username</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Password</th>
            <th scope="col">Vaccination Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while($user = mysqli_fetch_assoc($fetchedresult)): ?>
          <tr>
            <td> <?php echo $user['Username']; ?></td>
            <td><?php echo $user['FirstName']; ?></td>
            <td><?php echo $user['LastName']; ?></td>
            <td> <?php echo $user['Password']; ?></td>
            <td> <?php echo $user['VaccinationStatus']?></td>
            <td> <a href = "<?php echo "manage-clients.php?Username=".$user['Username']."&FirstName=".$user['FirstName']."&LastName=".$user['LastName']."&Password=".$user['Password']."&VaccinationStatus=".$user['VaccinationStatus']; ?>" class="btn btn-primary" name="button"><i class="fa fa-edit"></i></a> </td>
          </tr>
          <?php endwhile;?>
        </tbody>
      </table>
    </div>
    <div class="schedule row">
      <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">User Name</th>
              <th scope="col">First Name</th>
              <th scope="col">Last Name</th>
              <th scope="col">Password</th>
              <th scope="col">Vaccination Status</th>              
            </tr>
          </thead>
          <tbody>
            <form>
              <tr>
                <td>
                    <input id = "insertUserName" type="text" name="Username" value = <?php echo isset($_GET['Username']) ? $_GET['Username'] : ""?>>
                </td>
              
                <td> 
                  <input id = "insertFirstName" type="text" name="UpdateFirstName" value = <?php echo isset($_GET['FirstName']) ? $_GET['FirstName'] : ""?> >
                </td>
                <td>
                  <input id = "insertLastName" type="text" name="UpdateLastName" value = <?php echo isset($_GET['LastName']) ? $_GET['LastName'] : ""?> >
                </td>
                <td>
                  <input id = "insertPassword" type="text" name="UpdatePassword" value = <?php echo isset($_GET['Password']) ? $_GET['Password'] : ""?> >
                </td>
                <td>
                  <input id = "insertVaccinationStatus" type="int" name="UpdateVaccinationStatus" value = <?php echo isset($_GET['VaccinationStatus']) ? $_GET['VaccinationStatus'] : ""?>>
                </td>
                <td>
                  <input type="submit" class="btn btn-success" name="updateButton" value = "Update"></input>
                </td>
              </tr>
            </form>
          </tbody>
        </table>
    </div>
    <div class="schedule row">
    </div>
  </section>
</body>
</html>