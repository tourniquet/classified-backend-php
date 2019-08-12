<?php
  require_once('../private/initialize.php');
  require_once('../dbc.php');

  include(SHARED_PATH . '/head.php');

  if (!isset($_COOKIE['email'])) {
    if (is_post_request()) {
      $email = db_escape($dbc, trim(strtolower($_POST['email'])));
      $password = db_escape($dbc, trim($_POST['password']));

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

<div class="admin-login-page">
  <div class="admin-login-form-container">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="admin-login-form" method="POST">
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
