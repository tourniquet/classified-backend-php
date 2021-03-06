<?php
  require_once('./private/initialize.php');
  require_once('dbc.php');

  $data = $_POST;

  $email = db_escape($dbc, trim(strtolower($data['email'])));
  $password = db_escape($dbc, trim($data['password']));

  if (isset($email) && isset($password)) {
    $query = "
      SELECT id, email, password
      FROM cls_users
      WHERE email = '$email'";
    $data = mysqli_query($dbc, $query);
    $res = mysqli_fetch_assoc($data);

    header('Access-Control-Allow-Origin: *', false);
    header('Content-type: application/json', false);
    header('HTTP/1.1 200 OK');

    if (mysqli_num_rows($data) == 1) {
      if (password_verify($password, $res['password'])) {
        echo json_encode(['email' => $res['email'], 'id' => $res['id']], JSON_PRETTY_PRINT);
      } else {
        // wrong password
        echo json_encode(['message' => 'Password!']);
      }
    } else {
      echo json_encode(['message' => 'Unsuccess!']);
    }
  } else {
    echo json_encode(['message' => 'Undefined!']);
  }

  mysqli_close($dbc);
?>
