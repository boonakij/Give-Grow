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

  <h1> ShareEarn </h1>
  <p class = "slogan"> Envision what you can do for a better future for anyone. </p>

  <?php
  if (!$current_user) {
    ?>
    <form action="index.php" method="post">
      <label for = "username" ckass = "title"> Username: </label>
      <input type="text" name="username" placeholder="Username" required>
      <label for = "password" ckass = "title"> Password: </label>
      <input type="password" name="password" placeholder="Password" required>
      <label for = "email" class = "title"> Email: </label>
      <input type="text" name="email" placeholder="Email" required>
      <input type="submit" name="create" value="Get started">
    </form>

    <form action="index.php" method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" name="login" value="Log in">
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
</body>
</html>
