<?php
  require_once('../dbc.php');

  $currency_id = $_GET['id'];
  $query = "DELETE
    FROM cls_currencies
    WHERE id = $currency_id";
  mysqli_query($dbc, $query);
  mysqli_close($dbc);

  header('Location: currencies.php?page=1');
?>
