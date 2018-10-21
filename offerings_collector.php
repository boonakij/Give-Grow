<?php
include('includes/init.php');

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $money = round(filter_input(INPUT_POST, 'money', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION), 2);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    if ($category_id) {
      $sql = "SELECT offerings.id as id, desc_long, cost, companies.name as company_name, companies.url as company_url, image_path FROM offerings INNER JOIN categories ON offerings.category_id = categories.id INNER JOIN companies ON offerings.company_id = companies.id WHERE categories.id = :categories_id;";
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
    foreach($offerings as $offering) {
?>
    <div class="offering-card" data-id="<?php echo $offering['id']?>">
      <?php
      $offeringStr = formatDescriptionString($offering['desc_long'], $money/$offering['cost']);
      if(strpos($offeringStr, '[')) {
        $headerStr = substr($offeringStr, 0, strpos($offeringStr, '['))."<b>".substr($offeringStr, strpos($offeringStr, '[') + 1, strpos($offeringStr, ']') - strpos($offeringStr, '[') - 1)."</b>";
        $subStr =  substr($offeringStr, strpos($offeringStr, ']') + 1);
      }
      else {
        $headerStr = $offeringStr;
        $subStr = "";
      }
      ?>
      <div class="offering-card-header"><?php echo $headerStr?></div>
      <div class="offering-card-subheader"><?php echo $subStr?></div>
      <div class="offering-card-icon-container">
        <?php
        $itemCount = $money/$offering['cost'];
        $leftoverCount = 0;
        if ($itemCount > 10) {
          $leftoverCount = $itemCount - 10;
          $itemCount = 10;
        }
        for ($i=0; $i<$itemCount; $i++) {
        ?>
        <img class="offering-card-icon" src="images/<?php echo $offering['image_path']?>" alt="education" height="30" width="30">
        <?php
        }
        if ($leftoverCount > 0) {
          echo "+".round($leftoverCount,1);
        }
        ?>
      </div>
      <div class="offering-card-link-desc">Provided by <a target="_blank" href="<?php echo $offering['company_url']?>"><?php echo $offering['company_name'] ?></a></div>
    </div>

<?php
  }
?>
    <div class="modal" id="confirm-donation-modal" data-offering-id="" data-money="">
      <div id="confirm-donation-modal-content">
        <span class="close">&times;</span>
        <h2 id="confirm-donation-modal-message">Would you like to donate $<span id="confirm-donation-money">0</span> to this cause?</h2>
        <div id="modal-donate-btn">Donate</div>
      </div>
    </div>

<?php
}
?>
