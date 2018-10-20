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
  <script src="scripts/calculatedamt.js" type="text/javascript"></script>
  <link rel="shortcut icon" type="image/png" href="images/favicon.png"/>

  <title>Share Here- Bank Account</title>
</head>

<body>

  <h1> 2. Set a Charitable Giving Goal </h1>

<div class = "selectbar">
<label for="annual" class = "option" id = "annuallabel">Annual</label>
<input type="radio" id="annual" name="annual">
<label for="weekly" class = "option" id = "weeklylabel">Weekly</label>
<input type="radio" id="weekly" name="weekly">
</div>

  <?php
  if (!$current_user) {
    ?>
    <form action="index.php" method="post">
      <label for = "income" class = "title"> What's your estimated income?</label>
      <input type="number" name="income" placeholder="Income" required id = "income">
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
  <div class="slidecontainer">
  <input type="range" min="1" max="20" value="10" class="slider" id="slider">
  <p>Percentage: <div id="sliderAmount"></div></p>
  </div>

<p> That's </p>
<div id = "calculatedamt"> </div>
<p> each day! </p>
  <p> 1 - <strong> 2 </strong></p>
</body>
</html>
