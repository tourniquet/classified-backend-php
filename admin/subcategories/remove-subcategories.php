<?php
  require_once('../../dbc.php');
  require_once('../../private/initialize.php');

  if (is_post_request()) {
    $items = implode(',', $_POST['items']);

    $remove_subcategories_query = "DELETE
      FROM cls_categories
      WHERE id IN ($items)";
    mysqli_query($dbc, $remove_subcategories_query);
    mysqli_close($dbc);
  }

  redirect_to('index.php?page=1');
?>
