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

  <title>Title Here</title>
</head>

<body>

<?php
if (!$current_user) {
?>
<form action="index.php" method="post">
  <input type="text" name="username" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <input type="text" name="email" placeholder="Email" required>
  <input type="submit" name="create" value="Get started">
</form>

<form action="index.php" method="post">
  <input type="text" name="username" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <input type="submit" name="login" value="Log in">
</form>
<?php
// API stuff not working
// $json = file_get_contents('api.reimaginebanking.com/atms?key=08e6e06dd920cc34e0af881bc558d6a3');
// echo "hi";
// echo $json;
// $obj = json_decode($json);
// echo $obj->access_token;
}
else {
?>
<form action="index.php" method="post" id="logout-form">
  <input type="submit" name="logout" value="Log out" id="logout-btn">
</form>
<?php
}
?>
