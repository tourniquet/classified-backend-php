<?php
  ob_start(); // output buffering is turned on

  define('PRIVATE_PATH', dirname(__FILE__)); // C:\xampp5\htdocs\classified\backend\private
  define('PROJECT_PATH', dirname(PRIVATE_PATH)); // C:\xampp5\htdocs\classified\backend
  define('PUBLIC_PATH', PROJECT_PATH . '/'); // C:\xampp5\htdocs\classified\backend/
  define('SHARED_PATH', PRIVATE_PATH . '/shared'); // C:\xampp5\htdocs\classified\backend\private/shared

  // Assign the root URL to a PHP constant
  // * Do not need to include the domain
  // * Use same document root as webserver
  // * Can set a hardcoded value:
  // define("WWW_ROOT", '/classified/backend/');
  // define("WWW_ROOT", '');
  // * Can dynamically find everything in URL up to "/"
  $public_end = strpos($_SERVER['SCRIPT_NAME'], '/') + 20;
  $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
  define("WWW_ROOT", $doc_root);

  require_once('functions.php');
  require_once('query_functions.php');
?>
