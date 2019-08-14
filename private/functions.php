<?php
  function redirect_to ($location) {
    header('Location: ' . $location);
    exit;
  }

  function is_post_request () {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
  }

  function is_get_request () {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
  }

  function db_escape ($connection, $string) {
    return mysqli_real_escape_string($connection, $string);
  }
?>
