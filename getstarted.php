<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
include('includes/init.php');
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

<body>

  <h1> Let's get started </h1>

  <?php
  if (!$current_user) {
    ?>
    <form action="index.php" method="post">
      <label for = "name" class = "title"> First Name </label>
      <input type="text" name="name" placeholder="Name" required>
      <label for = "email" class = "title"> Email </label>
      <input type="text" name="email" placeholder="Email" required>
      <input type="submit" name="create" value="Get started">
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
  <a href="signup.php" class = "button"> Next </a>
</body>
</html>
