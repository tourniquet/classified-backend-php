<?php
  require_once('../../private/initialize.php');
  require_once('../../dbc.php');

  if (is_post_request()) {
    $items = implode(',', $_POST['items']);

    $remove_currencies_query = "DELETE
      FROM cls_currencies
      WHERE id IN ($items)";
    mysqli_query($dbc, $remove_currencies_query);
    mysqli_close($dbc);
  }

  redirect_to('index.php?page=1');
?>
