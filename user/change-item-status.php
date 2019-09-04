<?php
  require_once('../private/initialize.php');
  require_once('../dbc.php');

  $raw_data = file_get_contents('php://input');
  $data = json_decode($raw_data, true);

  $user_email = db_escape($dbc, $data['userEmail']);
  $user_id = db_escape($dbc, $data['userId']);
  $item_id = db_escape($dbc, $data['itemId']);

  if (is_post_request()) {
    $check_status_query = "SELECT enabled
      FROM cls_ads
      WHERE id = '$item_id'
      LIMIT 1";
    $result = mysqli_fetch_assoc(mysqli_query($dbc, $check_status_query));

    // if item is enabled before update, the new status is disabled
    $new_item_status = $result['enabled'] ? 0 : 1;

    $change_status_query = "UPDATE cls_ads
      SET enabled = '$new_item_status'
      WHERE id = '$item_id' AND user_email = '$user_email' AND user_id = '$user_id'
      LIMIT 1";
    $result = mysqli_query($dbc, $change_status_query) or die(mysqli_error($dbc));

    header('Access-Control-Allow-Origin: *', false);
    header('Content-type: application/json', false);
    header('HTTP/1.1 200 OK');

    if (mysqli_affected_rows($dbc)) {
      echo json_encode(['message' => 'Success!']);
    }

    mysqli_close($dbc);
  }
?>
