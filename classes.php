<?php
require 'config/db.php';
session_start();

// handle fetching class information
$query = "SELECT ClassID, Name, Time, RoomNum, NumParticipants, MaxOccupancy, FacilityName FROM class NATURAL JOIN facility ORDER BY NumParticipants DESC";

if (!$fetch_class = mysqli_query($connection, $query)) {
  exit("An error occured while fetching classes");
}

//handle class INSERT
if(isset($_POST['ClassID']))
{
  $ClassID = htmlspecialchars($_POST['ClassID']);
  $roomNum = htmlspecialchars($_POST['RoomNum']);
  $username = htmlspecialchars($_POST['Username']);

  
  $createQuery = "INSERT INTO `schedule` (`ClassID`, `RoomNum`, `ScheduleUsername`) VALUES ('$ClassID','$roomNum', '$username');";

  if(empty($ClassID) || empty($username) || empty($roomNum))
  {
    header("Location: classes.php?msg=Missing required fields&type=error&ClassID=".$ClassID."&Username=".$username."&Room Number=".$roomNum);
  }

  if(!$result = mysqli_query($connection, $createQuery))
  {
    header("Location: classes.php?msg=An error has occurred while booking&type=error&ClassID=".$ClassID."&Username=".$username."&Room Number=".$roomNum);
  }
  else
  {
    $addParticipant = "UPDATE `class` Set `NumParticipants` = `NumParticipants` + 1 WHERE classID = $ClassID;";
    $result = mysqli_query($connection, $addParticipant);
    if($result)
    {
      header("Location: classes.php?msg=Shift added&type=success&ClassID=".$ClassID."&Username=".$username."&Room Number=".$roomNum);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <title>Classes</title>
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
            <a class="nav-item nav-link active" href="classes.php">Classes <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="facilities.php">Facilities</a>
            <?php if (isset($_SESSION["Account"])) : ?>
              <a class="nav-item nav-link" href="member-schedule.php">Schedule</a>
              <a class="nav-item nav-link" href="member-info.php">Account</a>
            <?php endif; ?>
          </div>
        </div>
        <?php if (!isset($_SESSION["Account"])) : ?>
          <div class="login">
            <a href="login.php" class="login btn btn-dark" type="button">Sign In</a>
          </div>
        <?php else : ?>
          <div class="login">
            <a href="logout.php" class="login btn btn-dark" type="button">Sign Out</a>
          </div>
        <?php endif; ?>
      </nav>
    </div>
  </section>
  <form action = "#" method="post">
  <section id="about">
    <div class="welcome row">
      <div class="col col-lg-12">
        <h1>View Available Classes</h1>
      </div>
    <div class="display">
      <div class="card-deck">
        <?php while ($thisclass = mysqli_fetch_assoc($fetch_class)) : ?>
          <div class="card" style="width:1000px">
            <div class="card-body">
              <h3 class="card-title"><?php echo $thisclass['Name'] ?></h3>
              <div class="card-text">
                <h5>Time: <?php echo$thisclass['Time'] ?></h5>
                <h5>Room: <?php echo $thisclass['FacilityName'] ?></h5>
                <h5>Capacity <?php echo $thisclass['NumParticipants'] . " / " . $thisclass['MaxOccupancy'] ?></h5>
              </div>
            </div>
            <?php if (isset($_SESSION["Account"])) : ?>
              <div class="card-footer">
                <label for="ClassID">Join Class ID:</label>
                <input type="hidden" id = "RoomNum" name = "RoomNum" value = <?php echo isset($thisclass['RoomNum']) ? ($thisclass['RoomNum']) : ""?> />
                <input type="hidden" id = "Username" name = "Username" value = <?php echo isset($_SESSION["Account"]["Username"]) ? ($_SESSION["Account"]["Username"]) : ""?> />
                <input type="submit" id = "ClassID" name = "ClassID" value = <?php echo isset($thisclass['ClassID']) ? $thisclass['ClassID'] : ""?> />
              </div>
            <?php endif; ?>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </section>
  </form>
</body>

</html>