<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
include('includes/init.php');

session_start();

if ( $_POST['create'] ) {
    $amt = filter_input(INPUT_POST, 'slider');
    create_account($_SESSION['username'], $_SESSION['password'], $_SESSION['email'], $_SESSION['name'], $amt);
    header('Location: dashboard.php');
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/jquery-ui.min.css" media="all" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />
  <script src="scripts/jquery-3.2.1.min.js" type="text/javascript"></script>
  <script src="scripts/jquery-ui.min.js" type="text/javascript"></script>
  <script src="scripts/activity.js" type="text/javascript"></script>
  <script src="scripts/calculatedamt.js" type="text/javascript"></script>
  <link rel="shortcut icon" type="image/png" href="images/favicon.png"/>

  <title>GiveGrow- Bank Account</title>
</head>

<body class="goal">
  <img src = "images/step3.png" alt = "Step 3" class = "step"/>
  <h1 class="step"> 2. Set a Charitable Giving Goal </h1>

  <div class="bar bargoal"></div>
  <div class="information">

  <div class="container">
  <div class="segmented">
    <label for="annual" class = "option checked" id = "annuallabel"><input type="radio" name="segmented" id = "annual"/> Annual</label>
    <label for="weekly" class = "option" id = "weeklylabel"><input type="radio" name="segmented" id = "weekly"/> Weekly</label>
  </div>
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
</div>
  <p> What percentage of your income would you like to set <br/> aside for charitable giving? </p>
  <!-- <form class="slidecontainer" method="post">
    <input type="range" min="1" max="20" value="10" class="slider" name="slider" id="slider">
    <p>Percentage: <div id="sliderAmount"></div></p>

    <p> That's </p>
    <div id = "calculatedamt"> </div>
    <p> each day! </p>
    <input type="submit" name="create" value="signup" id="logout-btn">
  </form> -->
  <form class="slidecontainer" method="post">
    <input type="range" min="1" max="20" value="10" step = .01 class="slider" id="slider">
  <p>Percentage: <div id="sliderAmount"></div></p>

  <p> That's </p>
  <div id = "calculatedamt">$0 </div>
  <p> each day! </p>

  <!-- <a href = "dashboard.php" class = "button buttongoal"> All Set! </a> -->
  <input type="submit" class = "button buttongoal" name="create" value="All Set!">
</form>

  <img src = "images/boi4.png" alt = "succulent" class = "goal"/>
</body>
</html>
