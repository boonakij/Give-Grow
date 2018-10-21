<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
// ini_set("allow_url_fopen", 1);
include('includes/init.php');
// echo phpInfo();
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

  <title>GiveGrow- Welcome</title>
</head>

<body class = "welcome">

  <h1> Welcome to GiveGrow </h1>

  <div class = "bar"></div>

  <div class = "information">
    <?php
    if (!$current_user) {
      ?>
      <form action="dashboard.php" method="post">
        <label for = "username" class = "title"> Username </label>
        <input type="text" name="username" placeholder="Username" required>
        <label for = "password" ckass = "title"> Password </label>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="login" value="Log in" class = "button">
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
  <p> Don't have an account yet? Click <a href="getstarted.php"> here </a> to register! </p>

  <img src = "images/boi2.png" alt = "succulent" class = "welcome"/>

</body>
</html>
