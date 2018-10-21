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
  <link rel="stylesheet" type="text/css" href="styles/dashboard.css" media="all" />
  <link rel="stylesheet" type="text/css" href="styles/jquery-ui.min.css" media="all" />
  <script src="scripts/jquery-3.2.1.min.js" type="text/javascript"></script>
  <script src="scripts/jquery-ui.min.js" type="text/javascript"></script>
  <script src="scripts/d3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.11.0/d3.min.js"></script>
  <script src="scripts/activity.js" type="text/javascript"></script>
  <script src="scripts/dashboard.js" type="text/javascript"></script>
  <link rel="shortcut icon" type="image/png" href="images/favicon.png"/>

  <title>Share Here-Dashboard</title>
</head>

<body>

<?php
  // Increment donation fund
  $sql = "SELECT * FROM users_finance WHERE user_id = :user_id;";
  $params = array(
              ':user_id' => get_user_id()
            );
  $user_finance = exec_sql_query($db, $sql, $params)->fetchAll()[0];
  $day_last_incremented = new DateTime($user_finance['date_last_incremented']);
  $day_current = new DateTime();
  $day_current->format('Y-m-d');
  $interval = $day_last_incremented->diff($day_current);
  $day_difference = (int)$interval->format('%a');
  $money_difference = $day_difference * $user_finance['daily_donation_increment'];
  $new_donation_fund = $user_finance['donation_fund'] + $money_difference;
  $sql = "UPDATE users_finance SET donation_fund = :donation_fund, date_last_incremented = :date_last_incremented WHERE id = :id;";
  $params = array(
              ':donation_fund' => $new_donation_fund,
              ':date_last_incremented' => $day_current->format('Y-m-d'),
              ':id' => $user_finance['id']
            );
  $results = exec_sql_query($db, $sql, $params);
?>
<!-- With $<?php echo $new_donation_fund ?>, you could: -->
<?php
  $sql = "SELECT * FROM offerings;";
  $params = array(
              // ':user_id' => get_user_id()
            );
  $offering = exec_sql_query($db, $sql, $params)->fetchAll()[0];
  $offering_desc = str_replace("_count", round($new_donation_fund/$offering['cost'], 1), $offering['desc']);
?>

<div id="header">
  <div id="header-logo"></div>
  <div id="header-title">GIVE GROW</div>
  <div id="header-dashboard">
     <a href="dashboard.php">DASHBOARD</a>
  </div>
  <div id="header-logout">
    <a href="welcome.php">LOGOUT</a>
  </div>
</div>

<div id="offerings-container">
  <div id="category-title-container">
    Aid
  </div>
  <div id="offerings-header">
    Donate $<input id="offerings-money-input" type="number" min="0.00" max="10000.00" step="0.01" /> to:
  </div>
  <div id="offerings-update-btn">Update</div>
  <div id="offerings-collection"></div>
</div>

<div id=dashboard-container>
  <div id="welcome-container">
    <span class="vertically-centered">Hi <?php echo $current_user?>, welcome back!</span>
  </div>

  <div id="overview-container">
    <div id="budget-container">
      <div id="budget-desc">Current Budget</div>
      <div id="budget-amt"><span class="centered">$<?php echo $new_donation_fund?></span></div>
      <div id="added-amt">+ $<?php echo $money_difference?> since last visit</div>
  </div>
    <div id="data-container">
      <div id="chart">
      </div>
    </div>
    <div id="history-container">
      <div id="history-desc">Recent Donations</div>
      <div id="history-feed">
      <?php
      $sql = "SELECT * FROM users_donations INNER JOIN offerings ON users_donations.offerings_id = offerings.id WHERE user_id = :user_id ORDER BY date(date) DESC limit 2;";
      $params = array(
                  ':user_id' => get_user_id()
                );
      $user_donations = exec_sql_query($db, $sql, $params)->fetchAll();
      foreach ($user_donations as $user_donation) {
      ?>
          <p class="history-item"><?php echo date('m/d/y',strtotime($user_donation['date']));?>: <?php echo formatDescriptionString($user_donation['desc'], $user_donation['donation_amt']/$user_donation['cost']);?></p>
      <?php
      }
      ?>
      </div>
    </div>
  </div>
  <div id="succ1" class="succ"></div>
  <div id="succ2" class="succ"></div>
  <div id="succ3" class="succ"></div>
  <div id="succ4" class="succ"></div>
  <div id="give-container">
    <div id="aid-btn" data-money="<?php echo $new_donation_fund?>" class="category-container">
      <div id="aid-btn-title">Aid</div>
    </div>
    <div id="education-btn" data-money="<?php echo $new_donation_fund?>" class="category-container">
      <div id="education-btn-title">Education</div>
    </div>
    <div id="environment-btn" data-money="<?php echo $new_donation_fund?>" class="category-container">
      <div id="environment-btn-title">Environment</div>
    </div>
    <div id="health-btn" data-money="<?php echo $new_donation_fund?>" class="category-container">
      <div id="health-btn-title">Health</div>
    </div>
  </div>
</div>

<script>makeGraph(58, 30, 50, 38);</script>

</body>
</html>
