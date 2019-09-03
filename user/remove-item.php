<?php
  require_once('../private/initialize.php');
  require_once('../dbc.php');

  $raw_data = file_get_contents('php://input');
  $data = json_decode($raw_data, true);

  $item_id = db_escape($dbc, $data['itemId']);
  $user_email = db_escape($dbc, $data['userEmail']);
  $user_id = db_escape($dbc, $data['userId']);

  if (is_post_request()) {
    $remove_ad_query = "DELETE
      FROM cls_ads
      WHERE id = '$item_id' AND user_email = '$user_email' AND user_id = '$user_id'";
    $result = mysqli_query($dbc, $remove_ad_query) or die($dbc);

    header('Access-Control-Allow-Origin: *', false);
    header('Content-type: application/json', false);
    header('HTTP/1.1 200 OK');

    if (mysqli_affected_rows($dbc)) {
      echo json_encode(['message' => 'Success!']);
    }

    mysqli_close($dbc);
  }
?>
