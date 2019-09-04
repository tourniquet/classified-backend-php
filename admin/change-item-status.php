<?php
  require_once('../private/initialize.php');
  require_once('../dbc.php');

  $item_id = db_escape($dbc, $_GET['id']);
  $query = "SELECT * FROM cls_ads WHERE id = '$item_id'";
  $result = mysqli_fetch_assoc(mysqli_query($dbc, $query));

  if (sizeof($result)) {
    $check_status_query = "SELECT enabled
      FROM cls_ads
      WHERE id = '$item_id'
      LIMIT 1";
    $result = mysqli_fetch_assoc(mysqli_query($dbc, $check_status_query));

    // if item is enabled before update, the new status is disabled
    $new_item_status = $result['enabled'] ? 0 : 1;

    $change_status_query = "UPDATE cls_ads
      SET enabled = '$new_item_status'
      WHERE id = '$item_id'
      LIMIT 1";
    mysqli_query($dbc, $change_status_query) or die(mysqli_error($dbc));
  }

  mysqli_close($dbc);

  redirect_to('index.php?page=1');
?>
