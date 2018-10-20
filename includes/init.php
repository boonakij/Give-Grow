<?php
// show database errors during development.
function handle_db_error($exception) {
  echo '<p><strong>' . htmlspecialchars('Exception : ' . $exception->getMessage()) . '</strong></p>';
}
// execute an SQL query and return the results.
function exec_sql_query($db, $sql, $params = array()) {
  try {
    $query = $db->prepare($sql);
    if ($query and $query->execute($params)) {
      return $query;
    }
  } catch (PDOException $exception) {
    handle_db_error($exception);
  }
  return NULL;
}
// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename) {
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_init_sql = file_get_contents($init_sql_filename);
    if ($db_init_sql) {
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        unlink($db_filename);
        throw $exception;
      }
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return NULL;
}
// An array to deliver errors to the user.
$errors = array();
// Record an error to display to the user.
function store_error($error) {
  global $errors;
  array_push($errors, $error);
}
// open connection to database
$db = open_or_init_sqlite_db("db.sqlite", "init/init.sql");
function check_login() {
  global $db;
  if (isset($_COOKIE["session"])) {
    $session = $_COOKIE["session"];
    $sql = "SELECT * FROM users WHERE session = :session";
    $params = array(
      ':session' => $session
    );
    $accounts = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($accounts) {
      $account = $accounts[0];
      return $account['username'];
    }
  }
  else if (isset($_COOKIE["guest"])) {
    return "guest";
  }
  return NULL;
}
// log in the user
function log_in($username, $password) {
  global $db;
  global $current_user;
  if ($username && $password) {
    $sql = "SELECT * FROM users WHERE username = :username;";
    $params = array(
      ':username' => $username
    );
    $accounts = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($accounts) {
      $account = $accounts[0];
      if (password_verify($password, $account['password'])) {
        $session = uniqid();
        $sql = "UPDATE users SET session = :session WHERE id = :user_id;";
        $params = array(
          ':user_id' => $account['id'],
          ':session' => $session
        );
        $result = exec_sql_query($db, $sql, $params);
        if ($result) {
          setcookie("session", $session, time()+7200);
          $current_user = $account['username'];
        } else {
          store_error("Failed to log in");
        }
      } else {
        store_error("Incorrect username or password");
      }
    } else {
      store_error("Incorrect username or password");
    }
  } else {
    store_error("Incorrect username or password");
  }
}
function create_account($username, $password, $email) {
  global $current_user;
  global $db;
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $sql = "SELECT * FROM users WHERE username = :username;";
  $params = array(
              ':username' => $username
            );
  $results = exec_sql_query($db, $sql, $params)->fetchAll();
  if (count($results) == 0) {
    $sql = "INSERT INTO users (username, password, email, session) VALUES (:username, :password, :email, NULL)";
    $params = array(
                ':username' => $username,
                ':password' => $hashed_password,
                ':email' => $email
              );
    $results = exec_sql_query($db, $sql, $params);
    log_in($username, $password);
  }
}
// log out the user
function log_out() {
  global $current_user;
  global $db;
  if ($current_user) {
    $sql = "UPDATE users SET session = :session WHERE username = :username;";
    $params = array(
      ':username' => $current_user,
      ':session' => NULL
    );
    if (!exec_sql_query($db, $sql, $params)) {
      store_error("Failed to log out");
    }
  }
  setcookie("session", "", time()-3600);
  $current_user = NULL;
}
// return user id of current user
function get_user_id() {
  global $current_user;
  global $db;
  $sql = "SELECT id FROM users WHERE username = :username;";
  $params = array(
              ':username' => $current_user,
            );
  $id = exec_sql_query($db, $sql, $params)->fetchAll(PDO::FETCH_COLUMN, 0)[0];
  return $id;
}
// check if logged in
$current_user = check_login();
// Check if we should login the user
if (isset($_POST['login'])) {
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $username = trim($username);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  log_in($username, $password);
}

if (isset($_POST['logout'])) {
  log_out();
}

if (isset($_POST['create'])) {
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $username = trim($username);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
  create_account($username, $password, $email);
}
?>
