<?php
  require_once('config.php');

  $error_msg = '';

  if (!isset($_COOKIE['email'])) {
    if (isset($_POST['submit'])) {
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('Error connecting to database');

      $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
      $password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($email) && !empty($password)) {
        $query = "SELECT email FROM cls_users WHERE email = '$email' AND password = SHA('$password')";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          $row = mysqli_fetch_array($data);
          setcookie('email', $row['email'], time() + (86400 * 30), "/");

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
</head>
<body>
  <?php
    if (empty($_COOKIE['email'])) {
      echo "<p>Error: $error_msg</p>";
  ?>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?php if (!empty($email)) echo $email ?>">
    <br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password">

    <input type="submit" name="submit" value="Submit">
  </form>

  <?php
    } else {
      echo '<p>You are logged in as' . $_COOKIE['email'] . '</p>';
    }
  ?>
</body>
</html>
