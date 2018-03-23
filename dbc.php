<?php
  $dbc = mysqli_connect(
    DB_HOST,
    DB_USER,
    DB_PASSWORD,
    DB_NAME
  ) or Die('Error connecting to database');
?>
