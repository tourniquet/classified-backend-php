<?php
  require_once('../dbc.php');

  if (!isset($_COOKIE['email'])) {
    if (isset($_POST['submit'])) {
      $email = mysqli_real_escape_string($dbc, trim(strtolower($_POST['email'])));
      $password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($email) && !empty($password)) {
        $query = "SELECT email FROM cls_users WHERE email = '$email'";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          $row = mysqli_fetch_array($data);

          if (password_verify($row['password'], $password)) {
            setcookie('email', $row['email'], time() + (86400 * 30), "/");  
            header('Location: ' . 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php');
          } else {
            echo '<p>Your password in incorrect</p>';
          }
        } else {
          echo '<p>Your email is incorrect</p>';
        }
      } elseif (empty($email) && empty($password)) {
        echo '<p>You must enter your email and password</p>';
      } elseif (empty($email)) {
        echo '<p>You must enter your email</p>';
      } elseif (empty($password)) {
        echo '<p>You must enter your password</p>';
      }
    }
  }
?>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <input name="email" type="email" value="<?php if (isset($email)) echo $email ?>" required>
    <br>
    <input name="password" type="password" value="<?php if (isset($password)) echo $password ?>" required>
    <br>
    <button name="submit" type="submit">Log in</button>
  </form>
