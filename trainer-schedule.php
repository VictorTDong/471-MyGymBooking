<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
  require 'config/db.php';
  session_start();  
  //handle fetch trainer shifts READ
  $trainerSSN = $username = $_SESSION["Account"]["SSN"];
  $readQuery = "SELECT s.SSN, s.Date, s.StartTime, s.EndTime, f.RoomNum, f.FacilityName FROM `shift` as s, `facility` as f WHERE s.RoomNum = f.RoomNum AND SSN = '$trainerSSN' ORDER BY Date ASC;";

  if (!$fetchedresult = mysqli_query($connection, $readQuery))
  {
    exit("An error occured while fetching the shifts");
  }
?>

<head>
  <title>Schedule</title>
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
          <a class="nav-item nav-link" href="trainer-home.php">Home</a>
          <a class="nav-item nav-link active" href="#">View Schedule <span class="sr-only">(current)</span></a>
        </div>
      </div>
      <div class="login">
        <a href="login.php" class="login btn btn-dark" type="button">Sign Out</a>
      </div>
    </nav>
  </section>
  <section id="about">
    <div class="welcome row">
      <div class="col col-lg-12">
        <h1>My work Schedule</h1>
      </div>
      <div class="schedule row">
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Facility Name</th>
              <th scope="col">Date</th>
              <th scope="col">Start Time</th>
              <th scope="col">End Time</th>
            </tr>
          </thead>
          <tbody>
            <?php while($employee_shift = mysqli_fetch_assoc($fetchedresult)): ?>
            <tr>
              <td> <?php echo $employee_shift['FacilityName']; ?></td>
              <td> <?php echo $employee_shift['Date']; ?></td>
              <td> <?php echo $employee_shift['StartTime']; ?></td>
              <td> <?php echo $employee_shift['EndTime']; ?></td>
            </tr>
            <?php endwhile;?>
          </tbody>
        </table>
      </div>
  </section>
</body>
</html>
