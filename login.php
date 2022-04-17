<?php 

  require 'config/db.php';
  session_start();

  if(isset($_GET['Submit'])){
    $username = htmlentities($_GET['Username']);
    $password = htmlentities($_GET['Password']);

    $query = "SELECT * 
              FROM account
              WHERE Username = '$username' AND Password = '$password';";

    if(!$result = mysqli_query($connection,$query)){
      exit ("error");
    }else{
      $count = mysqli_num_rows($result);
      if($count > 0){
        $row = $result->fetch_assoc();
        echo "".$row["UserName"];

        if($row["AccountType"] == 0){
          $_SESSION["Account"] = $row;
          echo "".$_SESSION["Account"]["FirstName"];
          header("location: index.php");
        }
        if($row["AccountType"] == 1){
          $_SESSION["Account"] = $row;
          header("location: trainer-home.php");
        }
        if($row["AccountType"] == 2){
          $_SESSION["Account"] = $row;
          header("location: janitor-home.php");
        }
        if($row["AccountType"] == 3){
          $_SESSION["Account"] = $row;
          header("location: manager-home.php");
        }
      }
    }



  }




  // 

?>


<!DOCTYPE php>
<html lang="en" dir="ltr">

<head>
  <title>Gym Booking System</title>
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
            <a class="nav-item nav-link" href="facilities.php">Facilities</a>
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
        <?php endif; ?>
      </nav>
    </div>
  </section>
  <section id="about">
    <div class="welcome row">
      <div class="col">
        <h1>Log in</h1>
        <p>
          Please enter your login information.
        </p>
      </div>
    </div>
    <div class="row">
      <div class="login-bars col">
        <form>
          <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" name = "Username" class="form-control" aria-describedby="emailHelp" placeholder="Enter Username">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name = "Password" class="form-control" placeholder="Enter Password">
          </div>
          <button type="submit" name = "Submit" class="btn btn-dark">Submit</button>
        </form>
      </div>
    </div>
  </section>
  </body>
  </html> 
