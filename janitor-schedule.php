<!DOCTYPE html>
<html lang="en" dir="ltr">
  
<?php
  require 'config/db.php';
  session_start();
  $janitorSSN = $username = $_SESSION["Account"]["SSN"];
  $readQuery = "SELECT s.SSN, s.Date, s.StartTime, f.FacilityName, f.RoomNum, f.Cleaned FROM `shift` as s, `facility` as f WHERE s.RoomNum = f.RoomNum AND SSN = '$janitorSSN' AND DATE(Date) = CURDATE() ORDER BY StartTime ASC;";

  if (!$fetchedresult = mysqli_query($connection, $readQuery))
  {
    exit("An error occured while fetching the shifts");
  }

  $cleanedRooms = "SELECT `FacilityName`, `RoomNum`, `Cleaned` FROM `facility`";

  if (!$cleanedResult = mysqli_query($connection, $cleanedRooms))
  {
    exit("An error occured while fetching the shifts");
  }

  //handle cleaning UPDATE
  if(isset($_POST['addButton']))
  {
    if(!empty($_POST['updateButton'])) 
    {    
      foreach($_POST['updateButton'] as $value)
      {
        $updateQuery = "UPDATE `facility` SET Cleaned = 1 WHERE RoomNum = '$value';";
        
        if(!$result = mysqli_query($connection, $updateQuery))
        {
          header("Location: janitor-schedule.php?msg=An error has occurred while updating cleaned&type=error");
        }
        else
        {
          header("Location: janitor-schedule.php?msg=Clean updated&type=success&Cleaned room number=".$updateRoomNumber);
        }
      }
    }
  }
?>

<head>
  <title>Cleaning</title>
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
            <a class="nav-item nav-link" href="janitor-home.php">Home</a>
            <a class="nav-item nav-link active" href="#">Cleaning <span class="sr-only">(current)</span></a>
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
        <h1>Today's Cleaning Schedule</h1>
      </div>
      <div class="schedule row">
      <form action = "#" method = "post"> 
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Facility Name</th>
              <th scope="col">Room Number</th>
              <th scope="col">Time</th>
              <th scope="col">Complete</th>
            </tr>
          </thead>
          <tbody>
            <?php while($janitor_shift = mysqli_fetch_assoc($fetchedresult)): ?>
            <?php if (!$janitor_shift["Cleaned"]):?>
            <tr>
              <td> <?php echo $janitor_shift['FacilityName']; ?></td>
              <td> <?php echo $janitor_shift['RoomNum']; ?></td>
              <td> <?php echo $janitor_shift['StartTime']; ?></td>
              <td> <input name = 'updateButton[]' class="form-check-input" type = "checkbox" value = <?php echo isset($janitor_shift['RoomNum']) ? ($janitor_shift['RoomNum']) : ""?> > </td>
              <td> </td>
              <td> </td>
            </tr>
            <?php endif?>
            <?php endwhile;?>
          </tbody>
        </table>
        <tr> <input type="submit" class="btn btn-success" name="addButton" value = "Submit"></input> </tr>
        </form>
      </div>
      <div class="welcome row">
      <div class="col col-lg-12">
      <h1>Room's already cleaned</h1>
      </div>
      <div class="schedule row">
      <form action = "#" method = "post"> 
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Facility Name</th>
              <th scope="col">Room Number</th>
            </tr>
          </thead>
          <tbody>
          <?php while($janitor_shift = mysqli_fetch_assoc($cleanedResult)): ?>
            <?php if ($janitor_shift["Cleaned"]):?>
            <tr>
              <td> <?php echo $janitor_shift['FacilityName']; ?></td>
              <td> <?php echo $janitor_shift['RoomNum']; ?></td>
            </tr>
            <?php endif?>
            <?php endwhile;?>
          </tbody>
        </table>
        </form>
      </div>
  </section>
</body>
</html>