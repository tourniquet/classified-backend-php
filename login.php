<?php
  require_once('dbc.php');

  $raw_data = file_get_contents('php://input');
  $data = json_decode($raw_data, true);

  $error_msg = '';

  $email = mysqli_real_escape_string($dbc, trim(strtolower($data['email'])));
  $password = mysqli_real_escape_string($dbc, trim($data['password']));

  // if (!isset($_COOKIE['email'])) {
    // $error_msg = 'Sorry, you must enter a valid email and password to log in.';

    // if (isset($_POST['submit'])) {
      if (!empty($email) && !empty($password)) {
        $query = "SELECT email FROM cls_users WHERE email = '$email' AND password = '$password'"; //SHA()
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          $row = mysqli_fetch_array($data);
          // setcookie('email', $row['email'], time() + (86400 * 30), "/");
          // setcookie('token', $row['token'], time() + (86400 * 30), "/");

          // $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/';
          // header('Location: ' . $home_url);
          echo json_encode('Success!');
        } else {
          echo json_encode('Unsuccess!');
        }
      } else {
        echo json_encode('Undefined!');
      }
    // }
  // }
?>
