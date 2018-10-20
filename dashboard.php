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

  
  // $sql = "SELECT * FROM users_finance WHERE users_id = :user_id AND class_id = :class_id AND user_id = :user_id AND semester_id = :semester_id;";
  // $params = array(
  //             ':plan_id' => $plan_id,
  //             ':class_id' => $id,
  //             ':user_id' => get_user_id(),
  //             ':semester_id' => $semester_id
  //           );
  // $results = exec_sql_query($db, $sql, $params)->fetchAll(PDO::FETCH_COLUMN, 0)[0];
?>
</body>
</html>
