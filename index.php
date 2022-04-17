<?php 
  require 'config/db.php';
  session_start();

  if(isset($_SESSION["Account"]["AccountType"])){
    $accountType = $_SESSION["Account"]["AccountType"];
  }
  else{
    $accountType = -1;
  }

?>

<!DOCTYPE php>
<html lang="en" dir="ltr">

<head>
  <title>Gym Booking System</title>
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
            <a class="nav-item nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="classes.php">Classes</a>
            <a class="nav-item nav-link" href="facilities.php">Facilities</a>
            <?php if($accountType == 0): ?> 
              <a class="nav-item nav-link" href="member-schedule.php">Schedule</a>
              <a class="nav-item nav-link" href="member-info.php">Account</a>
            <?php endif;?>
          </div>
        </div>
        <?php if(!isset($_SESSION["Account"])): ?> 
          <div class="login">
            <a href="login.php" class="login btn btn-dark" type="button">Sign In</a>
          </div>
        <?php else:?>
          <div class="login">
            <a href="logout.php" class="login btn btn-dark" type="button">Sign Out</a>
          </div>
        <?php endif;?>
      </nav>
  </section>
  <section id="about">
    <div class="welcome row">
      <div class="col">
      <?php if(!isset($_SESSION["Account"])): ?> 
        <h1><span style="color: black">Welcome</span> to the MyGym Booking System</h1>
      <?php else:?>
        <h1><span style="color: black">Welcome</span> <?php echo $_SESSION["Account"]['FirstName']?>!</h1>
        <?php endif;?>
      </div>
      <div class="card-deck">
        <div class="card">
          <img class="card-img-top" src="images/facilities.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Facilities</h5>
            <p class="card-text">See the list of facilities we have to offer</p>
          </div>
          <div class="card-footer">
            <a href="facilities.php" class="btn btn-lg btn-dark" type="button">View Facilities</a>
          </div>
        </div>
        <div class="card">
          <img class="card-img-top" src="images/classes.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Classes</h5>
            <p class="card-text">See the classes we are currently offering</p>
          </div>
          <div class="card-footer">
            <a href="classes.php" class="btn btn-lg btn-dark" type="button">View Classes</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>