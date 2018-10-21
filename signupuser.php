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

  <title>Share Here- Sign Up</title>
</head>

<body>

  <h1> Set Your Login Details </h1>

  <?php
  if (!$current_user) {
    ?>
    <form action="index.php" method="post">>
      <label for = "username" class = "title"> Choose a username. </label>
      <input type="text" name="username" placeholder="Username" required>
      <label for = "password" class = "title"> Choose a password. </label>
      <input type="password" name="password" placeholder="Password" required>
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
  <a href="goal.php"> Next </a>
  <p> <strong> 1 </strong> - 2 </p>
</body>
</html>