<?php
  require_once('dbc.php');

  $raw_data = file_get_contents('php://input');
  $data = json_decode($raw_data, true);

  $error_msg = '';

  $email = mysqli_real_escape_string($dbc, trim(strtolower($data['email'])));
  $password = mysqli_real_escape_string($dbc, trim($data['password']));

  if (!empty($email) && !empty($password)) {
    $query = "SELECT id, email FROM cls_users WHERE email = '$email' AND password = '$password'";
    $data = mysqli_query($dbc, $query);
    $res = mysqli_fetch_assoc($data);

    header('Access-Control-Allow-Origin: *', false);
    header('Content-type: application/json', false);
    header('HTTP/1.1 200 OK');

    if (mysqli_num_rows($data) == 1) {
      echo json_encode($res);
    } else {
      echo json_encode('Unsuccess!');
    }
  } else {
    echo json_encode('Undefined!');
  }

  mysqli_close($dbc);
?>
