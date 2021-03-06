<?php
require 'config/db.php';
session_start();
// handle fetching Facilities information
$query = "SELECT RoomNum, MaxOccupancy, FacilityName FROM facility ORDER BY RoomNum ASC";

if (!$fetch_facility = mysqli_query($connection, $query)) {
  exit("An error occured while fetching classes");
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <title>Facilities</title>
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
    <div class="container-fluid">
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
            <a class="nav-item nav-link" href="index.php">Home</a>
            <a class="nav-item nav-link" href="classes.php">Classes</a>
            <a class="nav-item nav-link active" href="facilities.php">Facilities <span class="sr-only">(current)</span></a>
            <?php if(isset($_SESSION["Account"])): ?> 
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
        <?php endif;?>
        </div>
      </nav>
    </div>
  </section>
  <section id="about">
    <div class="welcome row">
      <div class="col col-lg-12">
        <h1>View Facilities</h1>
      </div>
    </div>
    <div class="display">
      <div class="card-deck">
        <?php while ($thisfacil = mysqli_fetch_assoc($fetch_facility)) : ?>
          <div class="card">
            <img class="card-img-top dog-img" src="images/facilities.jpg" alt="Card image cap">
            <div class="card-body">
              <h3 class="card-title">Facility Name: <?php echo $thisfacil['FacilityName'] ?></h3>
              <div class="card-text">
                <h5>Room Number: <?php echo $thisfacil['RoomNum'] ?></h5>
                <h5>Max Capacity: <?php echo $thisfacil['MaxOccupancy']?></h5>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </section>
</body>
</html>