<?php
  require_once('./private/initialize.php');

  if (!isset($_COOKIE['email'])) {
    $login_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php';
    redirect_to($login_url);
  } else {
    $email = $_COOKIE['email'];

    require_once('dbc.php');
    $query = 'SELECT email FROM cls_users WHERE email = ' . $email;

    mysqli_close($dbc);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <?php
    echo "<p>Your email address is $email</p>"
  ?>
</body>
</html>
