<?php
// vvv DO NOT MODIFY/REMOVE vvv

// check current php version to ensure it meets 2300's requirements
function check_php_version()
{
  if (version_compare(phpversion(), '7.0', '<')) {
    define(VERSION_MESSAGE, "PHP version 7.0 or higher is required for 2300. Make sure you have installed PHP 7 on your computer and have set the correct PHP path in VS Code.");
    echo VERSION_MESSAGE;
    throw VERSION_MESSAGE;
  }
}
check_php_version();

function config_php_errors()
{
  ini_set('display_startup_errors', 1);
  ini_set('display_errors', 0);
  error_reporting(E_ALL);
}
config_php_errors();

// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename)
{
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (file_exists($init_sql_filename)) {
      $db_init_sql = file_get_contents($init_sql_filename);
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        // If we had an error, then the DB did not initialize properly,
        // so let's delete it!
        unlink($db_filename);
        throw $exception;
      }
    } else {
      unlink($db_filename);
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return null;
}

function exec_sql_query($db, $sql, $params = array())
{
  $query = $db->prepare($sql);
  if ($query and $query->execute($params)) {
    return $query;
  }
  return null;
}

// ^^^ DO NOT MODIFY/REMOVE ^^^

// You may place any of your code here.
$db = open_or_init_sqlite_db('secure/eboard.sqlite', 'secure/init.sql');


//LECTURE 18, KYLE HARMS FROM zoo.php and animals.php
 //used to print the gallery
 function print_eboard_image($image) {
  echo '<a href="about.php?' . http_build_query( array( 'id' => $image['id'] ) ) . '"><img src="uploads/images/' . $image['id'] . "." .$image["image_ext"] . '" alt = "eboard_member"></a>' . PHP_EOL;
}

//THE CODE BELOW WAS CREATED USING THE REFERENCE LOGIN CODE GIVEN TO US IN LAB 08
//SOURCE INFO 2300 LAB 08 - KYLE HARMS
define('SESSION_COOKIE_DURATION', 60*60*1); // 1 hour = 60 sec * 60 min * 1 hr
$session_messages = array();

function log_in($username, $password) {
  global $db;
  global $current_user;
  global $session_messages;

  if ( isset($username) && isset($password) ) {
    // Does this username even exist in our database?
    $sql = "SELECT * FROM users WHERE username = :username;";
    $params = array(
      ':username' => $username
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($records) {
      // Username is UNIQUE, so there should only be 1 record.
      $account = $records[0];

      // Check password against hash in DB
      if ( password_verify($password, $account['password']) ) {
        // Generate session
        $session = session_create_id(null);

        // Store session ID in database
        $sql = "INSERT INTO sessions (user_id, session) VALUES (:user_id, :session);";
        $params = array(
          ':user_id' => $account['id'],
          ':session' => $session
        );
        $result = exec_sql_query($db, $sql, $params);
        if ($result) {
          // Success, session stored in DB

          // Send this back to the user.
          setcookie("session", $session, time() + SESSION_COOKIE_DURATION);

          $current_user = $account;
          return $current_user;
        } else {
          array_push($session_messages, "Log in failed.");
        }
      } else {
        array_push($session_messages, "Invalid username or password.");
      }
    } else {
      array_push($session_messages, "Invalid username or password.");
    }
  } else {
    array_push($session_messages, "No username or password given.");
  }
  $current_user = NULL;
  return NULL;
}

function find_user($user_id) {
  global $db;

  $sql = "SELECT * FROM users WHERE id = :user_id;";
  $params = array(
    ':user_id' => $user_id
  );
  $records = exec_sql_query($db, $sql, $params)->fetchAll();
  if ($records) {
    // users are unique, there should only be 1 record
    return $records[0];
  }
  return NULL;
}

function find_session($session) {
  global $db;

  if (isset($session)) {
    $sql = "SELECT * FROM sessions WHERE session = :session;";
    $params = array(
      ':session' => $session
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($records) {
      // sessions are unique, so there should only be 1 record
      return $records[0];
    }
  }
  return NULL;
}

function session_login() {
  global $db;
  global $current_user;

  if (isset($_COOKIE["session"])) {
    $session = $_COOKIE["session"];

    $session_record = find_session($session);

    if ( isset($session_record) ) {
      $current_user = find_user($session_record['user_id']);

      // Renew the cookie for 1 more hour
      setcookie("session", $session, time() + SESSION_COOKIE_DURATION);

      return $current_user;
    }
  }
  $current_user = NULL;
  return NULL;
}

function is_user_logged_in() {
  global $current_user;

  // if $current_user is not NULL, then a user is logged in!
  return ($current_user != NULL);
}

function log_out() {
  global $current_user;

  // Remove the session from the cookie and force it to expire (go back in time).
  setcookie('session', '', time() - SESSION_COOKIE_DURATION);
  $current_user = NULL;
}

// ---- Check for login, logout requests. Or check to keep the user logged in. ----

// Check if we should login the user
if ( isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password']) ) {
  $username = trim( $_POST['username'] );
  $password = trim( $_POST['password'] );

  log_in($username, $password);
} else {
  // check if logged in already via cookie
  session_login();
}

// Check if we should logout the user
if ( isset($current_user) && ( isset($_GET['logout']) || isset($_POST['logout']) ) ) {
  log_out();
}

?>
