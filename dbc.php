<?php
  require_once('config.php');

  $dbc = mysqli_connect(
    DB_HOST,
    DB_USER,
    DB_PASSWORD,
    DB_NAME
  ) or die(mysqli_error($dbc));

  mysqli_set_charset($dbc, 'utf8');
?>
