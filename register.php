<?php
  require_once('config.php');

  require_once('dbc.php');

  if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
    $password_repeat = mysqli_real_escape_string($dbc, trim($_POST['password_repeat']));

    if (!empty($email) && !empty($password) && !empty($password_repeat)) {
      if ($password == $password_repeat) {
        // check if email is already taken
        $query = "SELECT * FROM cls_users WHERE email = '$email'";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 0) {
          // the email is unique, so insert the data into the database
          $query = "INSERT INTO cls_users (email, password, token) VALUES ('$email', SHA('$password'), bin2hex(random_bytes(12)))";
          mysqli_query($dbc, $query);

          // confirm success with the user
          echo 'Your new account has been successfully created.';

          mysqli_close($dbc);
          exit();
        } else {
          echo '<p>An account already exists for this email</p>';
        }
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
  <p>Please enter your email and desired password to sign up to Classified!</p>

  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email">
    <br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password">
    <br>

    <label for="password_repeat">Password repeat:</label>
    <input type="password" name="password_repeat" id="password_repeat">
    <br>

    <input type="submit" value="Sign up" name="submit">
  </form>
</body>
</html>
