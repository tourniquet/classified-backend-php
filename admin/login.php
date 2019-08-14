<?php
  require_once('../private/initialize.php');
  require_once('../dbc.php');

  include(SHARED_PATH . '/head.php');

  if (!isset($_COOKIE['email'])) {
    if (is_post_request()) {
      $email = db_escape($dbc, trim(strtolower($_POST['email'])));
      $password = db_escape($dbc, trim($_POST['password']));
      $error = '';

      if (isset($email) && isset($password)) {
        $query = "SELECT email, password
          FROM cls_users
          WHERE email = '$email' AND admin = 1";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          $row = mysqli_fetch_assoc($data);

          if (password_verify($password, $row['password'])) {
            setcookie('email', $row['email'], time() + (86400 * 30), "/");  
            redirect_to('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php');
          } else {
            $error = 'Your password in incorrect';
          }
        } else {
          $error = 'Your email is incorrect';
        }
      } elseif (empty($email) && empty($password)) {
        $error = 'You must enter your email and password';
      } elseif (empty($email)) {
        $error = 'You must enter your email';
      } elseif (empty($password)) {
        $error = 'You must enter your password';
      }
    }
  } else {
    redirect_to('index.php?page=1');
  }
?>

<div class="admin-login-page">
  <div class="admin-login-form-container">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="admin-login-form" method="POST">
      <?php
        if (isset($error)) {
          echo '<span class="login-error">' . $error . '</span>';
        }
      ?>

      <label for="admin-email">Email</label>
      <input
        class="admin-email"
        id="admin-email"
        name="email"
        placeholder="Email"
        required
        type="email"
        value="<?php if (isset($email)) echo $email ?>"
      >

      <label for="admin-password">Password</label>
      <input
        class="admin-password"
        name="password"
        placeholder="Password"
        required
        type="password"
      >

      <button class="admin-login-button">Log in</button>
    </form>
  </div>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
