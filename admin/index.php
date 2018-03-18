<?php
  require_once('../config.php');

  $error_msg = '';

  if (!isset($_COOKIE['email'])) {
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/classified/backend/login.php';
    header('Location: ' . $home_url);

    if (isset($_POST['submit'])) {
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('Error connecting to database');

      $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
      $password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($email) && !empty($password)) {
        $query = "SELECT email FROM cls_users WHERE email = '$email' AND password = SHA('$password')";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          $row = mysqli_fetch_array($data);
          setcookie('email', $row['email']);

          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/';
          header('Location: ' . $home_url);
        } else {
          $error_msg = 'Sorry, you must enter a valid email and password to log in.';
        }
      } else {
        $error_msg = 'Sorry, you must enter your email and password to log in.';
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>

  <link rel="stylesheet" href="../styles.css">
</head>
<body>
  <?php
    $dbc = mysqli_connect(
      DB_HOST,
      DB_USER,
      DB_PASSWORD,
      DB_NAME
    ) or Die('Error connecting to database');

    $query = "SELECT * FROM cls_ads ORDER BY pub_date DESC";
    $data = mysqli_query($dbc, $query);

    if (isset($_COOKIE['email'])) {
      echo '<a href="../logout.php" style="color: red;">Logout</a>';
    } else {
      echo '<a href="../login.php" style="color: red;">Login</a>';
    }

    echo '<ul>';

    while ($row = mysqli_fetch_array($data)) {
      if ($row['enabled'] == 1) {
        echo '<li class="enabled">' . $row['title'] .
            '<a href="remove.php?id=' . $row['id'] . '"> Remove</a>&nbsp;
            <a href="enable.php?id=' . $row['id'] . '">Enable</a>&nbsp;
            <a href="disable.php?id=' . $row['id'] . '">Disable</a>
            <a href="renew.php?id=' . $row['id'] . '">Renew</a>
          </li>';
      } else {
        echo '<li class="disabled">' . $row['title'] .
            '<a href="remove.php?id=' . $row['id'] . '"> Remove</a>&nbsp;
            <a href="enable.php?id=' . $row['id'] . '">Enable</a>&nbsp;
            <a href="disable.php?id=' . $row['id'] . '">Disable</a>
            <a href="renew.php?id=' . $row['id'] . '">Renew</a>
          </li>';
      }
    }

    echo '</ul>';

    mysqli_close($dbc);
  ?>
</body>
</html>
