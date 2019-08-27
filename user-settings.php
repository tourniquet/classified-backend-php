<?php
  require_once('./private/initialize.php');
  require_once('dbc.php');

  $email = db_escape($dbc, trim(strtolower($_POST['email'])));
  $old_password = db_escape($dbc, $_POST['old-password']);
  $new_password = db_escape($dbc, password_hash($_POST['new-password'], PASSWORD_DEFAULT));
  $new_password_confirmation = db_escape($dbc, $_POST['new-password-confirmation']);

  if (isset($email) && isset($old_password) && isset($new_password) && isset($new_password_confirmation)) {
    $query = "SELECT *
      FROM cls_users
      WHERE email = '$email'";
    $user = mysqli_fetch_assoc(mysqli_query($dbc, $query));

    header('Access-Control-Allow-Origin: *', false);
    header('Content-type: application/json', false);
    header('HTTP/1.1 200 OK');

    if (($user['email'] === $email)) {
      if (password_verify($old_password, $user['password'])) {
        if (password_verify($new_password_confirmation, $new_password)) {
          // update password query
          $query = "UPDATE cls_users
            SET password = '$new_password'
            WHERE email = '$email'
            LIMIT 1";
          $result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));

          if ($result) echo json_encode(['message' => 'Success!']);
        } else {
          // if password confirmation doesn't match new password
          echo json_encode(['message' => 'Unmatch!']);
        }
      } else {
        // if old password sent to backend did not match
        echo json_encode(['message' => 'Wrong password!']);
      }
    }
  }
?>
