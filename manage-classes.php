<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
  require 'config/db.php';
  session_start();

  //Handle new shift CREATE
  if(isset($_POST['addButton']))
  {
    $ClassID = htmlspecialchars($_POST['ClassID']);
    $SSN = htmlspecialchars($_POST['SSN']);
    $ClassName = htmlspecialchars($_POST['ClassName']);
    $Time = htmlspecialchars($_POST['Time']);
    $RoomNum = htmlspecialchars($_POST['RoomNum']);

    $createQuery = "INSERT INTO `class` (`ClassID`,`SSN`, `Name`, `Time`, `NumParticipants`, `RoomNum`) VALUES ('$ClassID','$SSN','$ClassName','$Time', '0','$RoomNum');";

    if(empty($ClassID) || empty($SSN) || empty($ClassName) || empty($Time) || empty($RoomNum))
    {
      header("Location: manage-classes.php?msg=Missing required fields&type=error&ClassID=".$ClassID."&ClassName=".$ClassName."&Time=".$Time."&RoomNum=".$RoomNum);
    }

    if(!$result = mysqli_query($connection, $createQuery))
    {
      header("Location: manage-classes.php?msg=An error has occurred while adding class&type=error&ClassID=".$ClassID."&ClassName=".$ClassName."&Time=".$Time."&RoomNum=".$RoomNum);
    }
    else
    {
      header("Location: manage-classes.php?msg=Shift added&type=success&ClassID=".$ClassID."&ClassName=".$ClassName."&Time=".$Time."&RoomNum=".$RoomNum);
    }
  }


  //handle fetch shift READ
  $readQuery = "SELECT * FROM `class` as c, `facility` as f WHERE f.RoomNum = c.RoomNum ORDER BY c.ClassID ASC;";
  if (!$fetchedresult = mysqli_query($connection, $readQuery))
  {
    exit("An error occured while fetching the classes");
  }

  //handle shift UPDATE
  if(isset($_POST['updateButton']))
  {
    $ClassName = htmlspecialchars($_POST['ClassName']);
    $SSN = htmlspecialchars($_POST['SSN']);
    $Time = htmlspecialchars($_POST['Time']);
    $RoomNum = htmlspecialchars($_POST['RoomNum']);

    $updateClassID = $_GET['UpdateClassID'];

    $updateQuery = "UPDATE `class` SET SSN = '$SSN', Name = '$ClassName', Time = '$Time', RoomNum = '$RoomNum' WHERE ClassID = '$updateClassID';";

    if(!$result = mysqli_query($connection, $updateQuery))
    {
      header("Location: manage-classes.php?msg=An error has occurred while adding class&type=error&ClassID=".$ClassID."&ClassName=".$ClassName."&Time=".$Time."&RoomNum=".$RoomNum);
    }
    else
    {
      header("Location: manage-classes.php?msg=Class Updated&type=success&ClassID=".$ClassID."&ClassName=".$ClassName."&Time=".$Time."&RoomNum=".$RoomNum);
    }

  }

  //handle shift DELETE
  if( isset($_GET['DeleteClassID']))
  {
    $ClassID = $_GET['DeleteClassID'];

    $deleteQuery = "DELETE FROM class WHERE ClassID = '$ClassID';";
    if(!$result = mysqli_query($connection, $deleteQuery))
    {
      header("Location: manage-classes.php?msg=An error has occurred while deleting class&type=error&ClassID=".$ClassID."&ClassName=".$ClassName."&Time=".$Time."&RoomNum=".$RoomNum);
    }
    else
    {
      header("Location: manage-classes.php?msg=Class deleted&type=success&ClassID=".$ClassID."&ClassName=".$ClassName."&Time=".$Time."&RoomNum=".$RoomNum);
    }
  }
?>

<head>
  <title>Manage Classes</title>
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
        <h1>Manage Classes</h1>
      </div>
    </div>
    <div class="schedule row">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Class ID</th>
            <th scope="col">Name</th>
            <th scope="col">Trainer SSN</th>
            <th scope="col">Time</th>
            <th scope="col">Number of Particpants</th>
            <th scope="col">Room Number</th>
            <th scope="col">Facility Name</th>
          </tr>
        </thead>
        <tbody>
          <?php while($classes = mysqli_fetch_assoc($fetchedresult)): ?>
          <tr>
            <td> <?php echo $classes['ClassID']; ?></td>
            <td> <?php echo $classes['Name']; ?></td>
            <td> <?php echo $classes['SSN']; ?></td>
            <td> <?php echo $classes['Time']; ?></td>
            <td> <?php echo $classes['NumParticipants']; ?></td>
            <td> <?php echo $classes['RoomNum']; ?></td>
            <th> <?php echo $classes['FacilityName']; ?></th>
            <td>
              <a href = "<?php echo "manage-classes.php?UpdateClassID=".$classes['ClassID']."&UpdateName=".$classes['Name']."&UpdateSSN=".$classes['SSN']."&UpdateTime=".$classes['Time']."&UpdateRoomNum=".$classes['RoomNum']; ?>" class="btn btn-primary" name="button"><i class="fa fa-edit"></i></a>
              <a href = "<?php echo "manage-classes.php?DeleteClassID=".$classes['ClassID']."&Name=".$classes['Name']."&SSN=".$classes['SSN']."&Time=".$classes['Time']."&RoomNum=".$classes['RoomNum']; ?>" class="btn btn-danger" name="button"><i class="fa fa-trash"></i></a>
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
            <th scope="col">Class ID</th>
            <th scope="col">SSN</th>
            <th scope="col">Name</th>
            <th scope="col">Time</th>
            <th scope="col">Room Number</th>
            </tr>
          </thead>
          <tbody>
            <form action = "#" method = "post">
              <tr>
                <td>
                    <input id = "ClassID" type="text" name="ClassID" value = <?php echo isset($_GET['UpdateClassID']) ? $_GET['UpdateClassID'] : ""?>>
                </td>
                <td>
                    <input id = "SSN" type="text" name="SSN" value = <?php echo isset($_GET['UpdateSSN']) ? $_GET['UpdateSSN'] : ""?>>
                </td>
                <td> 
                  <input id = "ClassName" type="text" name="ClassName" value = <?php echo isset($_GET['UpdateName']) ? $_GET['UpdateName'] : ""?>>
                </td>
                <td>
                  <input id = "Time" type="time" name="Time" value = <?php echo isset($_GET['UpdateTime']) ? $_GET['UpdateTime'] : ""?> required>
                </td>
                <td>
                  <input id = "RoomNum" type="text" name="RoomNum" value = <?php echo isset($_GET['UpdateRoomNum']) ? $_GET['UpdateRoomNum'] : ""?>>
                </td>
                <td>
                  <?php if (!isset($_GET['UpdateClassID'])): ?>
                    <input type="submit" class="btn btn-success" name="addButton" value = "Add Class"></input>
                  <?php else: ?>
                    <input type="submit" class="btn btn-success" name="updateButton" value = "Update Class"></input>
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