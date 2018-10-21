<?php
include('includes/init.php');

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $money = round(filter_input(INPUT_POST, 'money', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION), 2);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    if ($category_id) {
      $sql = "SELECT * FROM offerings INNER JOIN categories ON offerings.category_id = categories.id WHERE categories.id = :categories_id;";
      $params = array(
                  ':categories_id' => $category_id
                );
      $offerings = exec_sql_query($db, $sql, $params)->fetchAll();
    }
    if(!$money) {
      $sql = "SELECT donation_fund FROM users_finance WHERE user_id = :user_id;";
      $params = array(
                  ':user_id' => get_user_id()
                );
      $money = exec_sql_query($db, $sql, $params)->fetchAll(PDO::FETCH_COLUMN, 0)[0];
    }
    echo $money;
    foreach($offerings as $offering) {
      echo  formatDescriptionString($offering['desc'], $money/$offering['cost']);
  }
}
?>
