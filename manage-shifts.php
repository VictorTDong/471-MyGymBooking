<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
  require 'config/db.php';
  session_start();

  //Handle new shift CREATE
  if(isset($_POST['addButton']))
  {
    $insertSSN = htmlspecialchars($_POST['insertSSN']);
    $insertDate = htmlspecialchars($_POST['insertDate']);
    $insertStart_time = htmlspecialchars($_POST['insertStart_time']);
    $insertEnd_time = htmlspecialchars($_POST['insertEnd_time']);
    $insertFacility = htmlspecialchars($_POST['insertFacility']);

    $createQuery = "INSERT INTO `shift` (`SSN`, `Date`, `StartTime`, `EndTime` , `RoomNum`) VALUES ('$insertSSN','$insertDate','$insertStart_time','$insertEnd_time','$insertFacility');";

    if(empty($insertSSN) || empty($insertDate) || empty($insertStart_time) || empty($insertEnd_time))
    {
      header("Location: manage-shifts.php?msg=Missing required fields&type=error&SSN=".$insertSSN."&Date=".$insertDate."&Start_time=".$insertStart_time."&End_time=".$insertEnd_time);
    }

    if(!$result = mysqli_query($connection, $createQuery))
    {
      header("Location: manage-shifts.php?msg=An error has occurred while adding shift&type=error");
    }
    else
    {
      header("Location: manage-shifts.php?msg=Shift added&type=success&SSN=".$insertSSN."&Date=".$insertDate."&Start_time=".$insertStart_time."&End_time=".$insertEnd_time);
    }
  }

  //handle fetch shift READ
  $readQuery = "SELECT a.FirstName, a.LastName, a.SSN, `Date`, `StartTime`, `EndTime`, f.FacilityName, f.RoomNum FROM `shift` as s, `facility` as f, `account` as a  WHERE s.SSN = a.SSN AND s.RoomNum = f.RoomNum ORDER BY Date ASC;";
  if (!$fetchedresult = mysqli_query($connection, $readQuery))
  {
    exit("An error occured while fetching the shifts");
  }

  //handle shift UPDATE
  if(isset($_POST['updateButton']))
  {
    $insertDate = htmlspecialchars($_POST['insertDate']);
    $insertStart_time = htmlspecialchars($_POST['insertStart_time']);
    $insertEnd_time = htmlspecialchars($_POST['insertEnd_time']);
    $insertFacility = htmlspecialchars($_POST['insertFacility']);

    $updateSSN = $_GET['UpdateSSN'];
    $updateDate = $_GET['UpdateDate'];
    $updateStart_time  = $_GET['UpdateStart_time'];
    $updateEnd_time = $_GET['UpdateEnd_time'];

    $updateQuery = "UPDATE `shift` SET Date = '$insertDate', StartTime = '$insertStart_time', EndTime = '$insertEnd_time', RoomNum = '$insertFacility' WHERE SSN = '$updateSSN' AND Date = '$updateDate' AND StartTime = '$updateStart_time' AND EndTime = '$updateEnd_time';";

    

    if(!$result = mysqli_query($connection, $updateQuery))
    {
      header("Location: manage-shifts.php?msg=An error has occurred while updating shift&type=error");
    }
    else
    {
      header("Location: manage-shifts.php?msg=Shift updated&type=success&SSN=".$insertSSN."&Date=".$insertDate."&Start_time=".$insertStart_time."&End_time=".$insertEnd_time);
    }
  }

  //handle shift DELETE
  if(isset($_GET['deleteSSN']))
  {
    $delete_SSN = $_GET['deleteSSN'];
    $date= $_GET['deleteDate'];
    $start_time = $_GET['deleteStart_time'];
    $end_time = $_GET['deleteEnd_time'];

    $deleteQuery = "DELETE FROM shift WHERE SSN = '$delete_SSN' AND Date = '$date' AND StartTime = '$start_time' AND EndTime = '$end_time';";
    if(!$result = mysqli_query($connection, $deleteQuery))
    {
      header("Location: manage-shifts.php?msg=An error has occurred while deleting&type=error&SSN=".$delete_SSN."&Date=".$date."&Start_time=".$start_time."&End_time=".$end_time);
    }
    else
    {
      header("Location: manage-shifts.php?msg=Shift deleted&type=success&SSN=".$delete_SSN."&Date=".$date."&Start_time=".$start_time."&End_time=".$end_time);
    }
  }
?>

<head>
  <title>Manage Shifts</title>
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
    <div class="welcome row">
      <div class="col">
        <h1>Manage Shifts</h1>
      </div>
    </div>
    <div class="schedule row">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">SSN</th>
            <th scope="col">Employee First Name</th>
            <th scope="col">Employee Last Name</th>
            <th scope="col">Date</th>
            <th scope="col">Time</th>
            <th scope="col">Facility</th>
            <th scope="col">Room Number</th>
          </tr>
        </thead>
        <tbody>
          <?php while($employee_shift = mysqli_fetch_assoc($fetchedresult)): ?>
          <tr>
            <td> <?php echo $employee_shift['SSN']; ?></td>
            <td> <?php echo $employee_shift['FirstName']; ?></td>
            <td> <?php echo $employee_shift['LastName']; ?></td>
            <td> <?php echo $employee_shift['Date']; ?></td>
            <td> <?php echo $employee_shift['StartTime']."-".$employee_shift['EndTime']; ?></td>
            <th> <?php echo $employee_shift['FacilityName']; ?></th>
            <th> <?php echo $employee_shift['RoomNum']; ?></th>
            <td>
              <a href = "<?php echo "manage-shifts.php?UpdateSSN=".$employee_shift['SSN']."&UpdateDate=".$employee_shift['Date']."&UpdateStart_time=".$employee_shift['StartTime']."&UpdateEnd_time=".$employee_shift['EndTime']."&updateRoom=".$employee_shift['RoomNum']; ?>" class="btn btn-primary" name="button"><i class="fa fa-edit"></i></a>
              <a href = "<?php echo "manage-shifts.php?deleteSSN=".$employee_shift['SSN']."&deleteDate=".$employee_shift['Date']."&deleteStart_time=".$employee_shift['StartTime']."&deleteEnd_time=".$employee_shift['EndTime']."&deleteRoom=".$employee_shift['RoomNum']; ?>" class="btn btn-danger" name="button"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          <?php endwhile;?>
        </tbody>
      </table>
    </div>
    <div class="schedule row">
      <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">SSN</th>
              <th scope="col">Date</th>
              <th scope="col">Start Time</th>
              <th scope="col">End Time</th>
              <th scope="col">Room Number</th>
            </tr>
          </thead>
          <tbody>
            <form action = "#" method = "post">
              <tr>
                <td>
                    <input id = "insertSSN" type="text" name="insertSSN" class="form-control" value = <?php echo isset($_GET['UpdateSSN']) ? $_GET['UpdateSSN'] : ""?>>
                </td>
                
                <td> 
                  <input id = "insertDate" type="date" name="insertDate" min="2022-04-01" value = <?php echo isset($_GET['UpdateDate']) ? $_GET['UpdateDate'] : ""?> required>
                </td>

                <td>
                  <input id = "insertStart_time" type="time" name="insertStart_time" value = <?php echo isset($_GET['UpdateStart_time']) ? $_GET['UpdateStart_time'] : ""?> required>
                </td>

                <td>
                  <input id = "insertEnd_time" type="time" name="insertEnd_time" value = <?php echo isset($_GET['UpdateEnd_time']) ? $_GET['UpdateEnd_time'] : ""?> required>
                </td>

                <td>
                  <input id = "insertFacility" type="text" name="insertFacility" class="form-control" value = <?php echo isset($_GET['updateRoom']) ? $_GET['updateRoom'] : ""?>>
                </td>

                <td>
                  <?php if (!isset($_GET['UpdateSSN'])): ?>
                    <input type="submit" class="btn btn-success" name="addButton" value = "Add Shift"></input>
                  <?php else: ?>
                    <input type="submit" class="btn btn-success" name="updateButton" value = "Update Shift"></input>
                  <?php endif; ?>
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