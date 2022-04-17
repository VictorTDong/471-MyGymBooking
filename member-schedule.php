<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
  require 'config/db.php';
  session_start();  
  //handle fetch schedule READ
  $memberUsername = $_SESSION["Account"]["Username"];
  $readQuery = "SELECT c.Name, `BookingID`, s.ClassID, c.Time, c.RoomNum FROM `schedule` as s, `Class` as c WHERE c.ClassID = s.ClassID AND ScheduleUsername = '$memberUsername';";

  if (!$fetchedresult = mysqli_query($connection, $readQuery))
  {
    exit("An error occured while fetching the shifts");
  }

  //handle schedule DELETE
  if(isset($_GET['deleteBookingID']))
  {
    $deleteClassID = $_GET['deleteClassID'];
    $deleteBookingID= $_GET['deleteBookingID'];

    $deleteQuery = "DELETE FROM schedule WHERE BookingID = '$deleteBookingID';";
    if(!$result = mysqli_query($connection, $deleteQuery))
    {
      header("Location: member-schedule.php?msg=An error has occurred while deleting&type=error");
    }
    else
    {
      $subtractParticipant = "UPDATE `class` Set `NumParticipants` = `NumParticipants` - 1 WHERE classID = $deleteClassID;";
      $result = mysqli_query($connection, $subtractParticipant);
      if($result)
      {
        header("Location: member-schedule.php?msg=Booking deleted&type=success");
      }     
    }
  }

?>
<head>
  <title>Schedule</title>
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
            <a class="nav-item nav-link" href="classes.php">Classes</a>
            <a class="nav-item nav-link" href="facilities.php">Facilities</a>
            <a class="nav-item nav-link active" href="member-schedule.php">Schedule <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="member-info.php">Account</a>
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
        <h1>Your Bookings</h1>
      </div>
    </div>
    <div class="schedule row">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Class ID</th>
            <th scope="col">Booking ID</th>
            <th scope="col">Class Name</th>
            <th scope="col">Time</th>
            <th scope="col">Room Number</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while($classesBooked = mysqli_fetch_assoc($fetchedresult)): ?>
          <tr>
            <td> <?php echo $classesBooked['ClassID']; ?></td>
            <td> <?php echo $classesBooked['BookingID']; ?></td>
            <td> <?php echo $classesBooked['Name']; ?></td>
            <td> <?php echo $classesBooked['Time']; ?></td>
            <td> <?php echo $classesBooked['RoomNum']; ?></td>
            <td>
              <a href = "<?php echo "member-schedule.php?deleteClassID=".$classesBooked['ClassID']."&deleteBookingID=".$classesBooked['BookingID']; ?>" class="btn btn-danger" name="button"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          <?php endwhile;?>
        </tbody>
      </table>
    </div>
  </section>
</body>
</html>
