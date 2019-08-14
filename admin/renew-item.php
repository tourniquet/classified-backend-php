<?php
  require_once('../private/initialize.php');
  require_once('../dbc.php');

  $item_id = db_escape($dbc, $_GET['id']);
  $query = "UPDATE cls_ads
    SET published = NOW()
    WHERE id = '$item_id'
    LIMIT 1";
  mysqli_query($dbc, $query) or die(mysqli_error());
  mysqli_close($dbc);

  redirect_to('index.php?page=1');
?>
