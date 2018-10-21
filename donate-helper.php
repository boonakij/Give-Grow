<?php
include('includes/init.php');

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $money = round(filter_input(INPUT_POST, 'money', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION), 2);
    $offering_id = filter_input(INPUT_POST, 'offeringId', FILTER_SANITIZE_NUMBER_INT);

    if ($money && $offering_id) {
      $day_current = new DateTime();
      $day_current->format('Y-m-d');
      $sql = "INSERT INTO users_donations (user_id, offerings_id, donation_amt, date) VALUES (:user_id, :offerings_id, :donation_amt, :date)";
      $params = array(
                  ':user_id' => get_user_id(),
                  ':offerings_id' => $offering_id,
                  ':donation_amt' => $money,
                  ':date' => $day_current->format('Y-m-d')
                );
      $results = exec_sql_query($db, $sql, $params);
      if ($results) {
        $sql = "SELECT donation_fund FROM users_finance WHERE user_id = :user_id;";
        $params = array(
                    ':user_id' => get_user_id()
                  );
        $current_money = exec_sql_query($db, $sql, $params)->fetchAll(PDO::FETCH_COLUMN, 0)[0];
        $new_money = $current_money - $money;
        $sql = "UPDATE users_finance SET donation_fund = :donation_fund WHERE user_id = :user_id;";
        $params = array(
                    ':donation_fund' => $new_money,
                    ':user_id' => get_user_id()
                  );
        $results = exec_sql_query($db, $sql, $params);
      }
    }

}

?>
