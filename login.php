<?php
  require_once('dbc.php');

  $raw_data = file_get_contents('php://input');
  $data = json_decode($raw_data, true);

  $error_msg = '';

  $email = mysqli_real_escape_string($dbc, trim(strtolower($data['email'])));
  $password = mysqli_real_escape_string($dbc, trim($data['password']));

  if (!empty($email) && !empty($password)) {
    $query = "SELECT email, password FROM cls_users WHERE email = '$email'";
    $data = mysqli_query($dbc, $query);

    if (mysqli_num_rows($data) == 1) {
      $row = mysqli_fetch_array($data);

      if (password_verify($password, $row['password'])) {
        echo json_encode('Success!');
      } else {
        echo json_encode('Wrong password!');
      }
    } else {
      echo json_encode('Unsuccess!');
    }
  } else {
    echo json_encode('Undefined!');
  }
?>
