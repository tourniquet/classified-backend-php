<?php
  require_once('../private/initialize.php');
  require_once('../dbc.php');

  $item_id = db_escape($dbc, $_GET['id']);
  $query = "SELECT * FROM cls_ads WHERE id = '$item_id'";
  $result = mysqli_fetch_assoc(mysqli_query($dbc, $query));

  if (sizeof($result)) {
    $disable_ad = "UPDATE cls_ads
      SET enabled = 1
      WHERE id = '$item_id'
      LIMIT 1";
    mysqli_query($dbc, $disable_ad) or die(mysqli_error($dbc));
  }

  mysqli_close($dbc);

  redirect_to('index.php?page=1');
?>
