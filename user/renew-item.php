<?php
  require_once('../private/initialize.php');
  require_once('../dbc.php');

  $raw_data = file_get_contents('php://input');
  $data = json_decode($raw_data, true);

  $user_email = db_escape($dbc, $data['userEmail']);
  $user_id = db_escape($dbc, $data['userId']);
  $item_id = db_escape($dbc, $data['itemId']);

  if (is_post_request()) {
    $query = "UPDATE cls_ads
      SET published = NOW()
      WHERE id = '$item_id' AND user_email = '$user_email' AND user_id = '$user_id'
      LIMIT 1";
    mysqli_query($dbc, $query) or die(mysqli_error($dbc));

    if (mysqli_affected_rows($dbc)) {
      echo json_encode(['message' => 'Success!']);
    }

    mysqli_close($dbc);
  }
?>
