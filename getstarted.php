<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
include('includes/init.php');

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $name = filter_input(INPUT_POST, 'name');
    $email = filter_input(INPUT_POST, 'email');
    $_SESSION["name"] = $name;
    $_SESSION['email'] = $email;
    header('Location: signup.php');
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
  <link rel="stylesheet" type="text/css" href="styles/jquery-ui.min.css" media="all" />
  <script src="scripts/jquery-3.2.1.min.js" type="text/javascript"></script>
  <script src="scripts/jquery-ui.min.js" type="text/javascript"></script>
  <script src="scripts/activity.js" type="text/javascript"></script>
  <link rel="shortcut icon" type="image/png" href="images/favicon.png"/>

  <title>GiveGrow- Get Started</title>
</head>

<body class ="getstarted">
  <img src = "images/step1.png" alt = "Step 1" class = "step"/>

  <h1 class = "step"> Let's get started </h1>

  <div class = "bar"></div>
  <div class = "information">
    <?php
    if (!$current_user) {
      ?>
      <form action="getstarted.php" method="post">
        <label for = "name" class = "title"> First Name </label>
        <input type="text" name="name" placeholder="Name" required>
        <label for = "email" class = "title"> Email </label>
        <input type="text" name="email" placeholder="ec1@cornell.edu" required>
        <input type="submit" name="create" value="Next" class = "button";>
      </form>
      <?php
    }
    else {
      ?>
      <form action="index.php" method="post" id="logout-form">
        <input type="submit" name="logout" value="Log out" id="logout-btn">
      </form>
      <?php
    }
    ?>
  </div>

  <img src = "images/boi3.png" alt = "succulent" class = "getstarted"/>

</body>
</html>
