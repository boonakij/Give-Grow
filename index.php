<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
// ini_set("allow_url_fopen", 1);
include('includes/init.php');
// echo phpInfo();
?>
<!DOCTYPE html>
<html class="uk-height-1-1">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
  <link rel="stylesheet" type="text/css" href="styles/jquery-ui.min.css" media="all" />
  <script src="scripts/jquery-3.2.1.min.js" type="text/javascript"></script>
  <script src="scripts/jquery-ui.min.js" type="text/javascript"></script>
  <script src="scripts/activity.js" type="text/javascript"></script>
  <link rel="shortcut icon" type="image/png" href="images/favicon.png"/>
  <!-- UIkit CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.19/css/uikit.min.css" />

  <!-- UIkit JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.19/js/uikit.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.19/js/uikit-icons.min.js"></script>
  <title>Share Here- Sign In</title>
</head>


<body class="uk-height-1-1">
  <div class="content-wrapper uk-container uk-background-cover">
    <div class="">
      <h class="uk-heading-primary"; id="title-text">Our title goes here</h>
      <p>Some bullshit quote</p>
    </div>
    <div class="circle"></div>
    <div class="">
      <button class="uk-button uk-button-default">Button 1</button>
      <button class="uk-button uk-button-default">Button 2</button>
    </div>


  <!-- <?php
  if (!$current_user) {
    ?>
    <form action="index.php" method="post">
      <label for = "username" class = "title"> Username: </label>
      <input type="text" name="username" placeholder="Username" required>
      <label for = "password" ckass = "title"> Password: </label>
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
<p> Don't have an account? Click <a href="signup.php"> here </a> to sign up now! </p> -->
<div class="footer uk-flex">
  <img class="succ" data-src="images/boi1-01.png" uk-img></img>
  <img class="succ" data-src="images/boi2-02.png" uk-img></img>
  <img class="succ" data-src="images/boi3-03.jpg" uk-img></img>
  <img class="succ" data-src="images/brhacks4-04.png" uk-img></img>
</div>
</div>
</body>
</html>
