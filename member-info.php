<?php
  require 'config/db.php';
  session_start();

  if(!isset($_SESSION["Account"])){
    echo "You shouldn't be here";
  }
  else
  {
    //handle fetch member READ
    $memberUsername = $username = $_SESSION["Account"]["Username"];
    $readQuery = "SELECT * FROM `account` as s, `membership` as m WHERE m.SSN = s.SSN AND s.Username = '$memberUsername';";

    if (!$fetchedresult = mysqli_query($connection, $readQuery))
    {
      exit("An error occured while fetching the shifts");
    }
  }
  
  //handle member UPDATE
  if(isset($_GET['updateButton']))
  {
    $username = $_SESSION["Account"]["Username"];
    $updatePassword = $_GET['UpdatePassword'];


    $updateQuery = "UPDATE account 
                    SET Password = '$updatePassword'
                    WHERE UserName = '$username';";
    if(!empty($updatePassword) )
    {
      if(!$result = mysqli_query($connection, $updateQuery)){
        echo "error";
      }else{
        header("Location: member-info.php?msg=Shift updated&type=success&Username=".$username);
      }
    }   
  } 

?>


<!DOCTYPE php>
<html lang="en" dir="ltr">

<head>
  <title>Account</title>
  <link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Ubuntu&display=swap" rel="stylesheet">


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
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="classes.php">Classes</a>
            <a class="nav-item nav-link" href="facilities.php">Facilities</a>
            <a class="nav-item nav-link active" href="member-schedule.php">Schedule <span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link active" href="member-info.php">Account <span class="sr-only">(current)</span></a>
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
        <h1>Account information</h1>
      </div>
    </div>
    <div class="schedule row">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">First Name </th>
            <th scope="col">Last Name</th>
            <th scope="col">Birthdate</th>
            <th scope="col">Reoccuring payment date</th>
            <th scope="col">Membership ID</th>
          </tr>
        </thead>
        <tbody>
          <?php while($classesBooked = mysqli_fetch_assoc($fetchedresult)): ?>
            <td> <?php echo $classesBooked['FirstName']; ?></td>
            <td> <?php echo $classesBooked['LastName']; ?></td>
            <td> <?php echo $classesBooked['BirthDate']; ?></td>
            <td> <?php echo $classesBooked['PaymentDate']; ?></td>
            <td> <?php echo $classesBooked['MembershipID']; ?></td>
          <?php endwhile;?>
        </tbody>
      </table>
    <div class="row">
      <div class="login-bars col">
        <form>
          <div class="form-group">
            <label for="insertPassword">Change your password</label>
            <input id = "insertPassword" type="text" name="UpdatePassword" value = <?php echo isset($_GET['UpdatePassword']) ? $_GET['UpdatePassword'] : ""?> >
          </div>
          <input type="submit" class="btn btn-success" name="updateButton" value = "Submit"></input>
        </form>
        </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
