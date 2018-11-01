  <!-- // $error_msg = '';

  // if (!isset($_COOKIE['email'])) {
    // $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/classified/backend/login.php';
    // header('Location: ' . $home_url);

    // if (isset($_POST['submit'])) {
      // require_once('../dbc.php');

      // $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
      // $password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      // if (!empty($email) && !empty($password)) {
        // $query = "SELECT email FROM cls_users WHERE email = '$email' AND password = SHA('$password')";
        // $data = mysqli_query($dbc, $query);

        // if (mysqli_num_rows($data) == 1) {
          // $row = mysqli_fetch_array($data);
          // setcookie('email', $row['email']);

          // $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/';
          // header('Location: ' . $home_url);
        // }
        // else {
        //   $error_msg = 'Sorry, you must enter a valid email and password to log in.';
        // }
      // }
      // else {
      //   $error_msg = 'Sorry, you must enter your email and password to log in.';
      // }
    // }
  // } -->

<?php
  include './header.php';

  require_once('../dbc.php');

  $query = "SELECT * FROM cls_ads ORDER BY published DESC";
  $data = mysqli_query($dbc, $query);

  // if (!$data) {
  //   echo json_encode(mysqli_connect_error());
  // }

  // echo json_encode($data);

  // if (isset($_COOKIE['email'])) {
  //   echo '<a href="../logout.php" style="color: red;">Logout</a>';
  // } else {
  //   echo '<a href="../login.php" style="color: red;">Login</a>';
  // }

  echo '<ul class="items-list">';
  while ($row = mysqli_fetch_array($data)) {
    // TODO: sprintf()

    $item_state = $row['enabled'] == 1
      ? array(
        'class_name' => 'enabled',
        'href' => 'enable.php?id=' . $row['id'],
        'title' => 'Enable'
      )
      : array(
        'class_name' => 'disabled',
        'href' => 'disable.php?id=' . $row['id'],
        'title' => 'Disable'
      );


    echo '<li class="' . $item_state['class_name']  . '">' . $row['title'] .
            '<a href="remove.php?id=' . $row['id'] . '"> Remove</a>&nbsp;
            <a href="' . $item_state['href'] . '">' . $item_state['title'] .'</a>
            <a href="renew.php?id=' . $row['id'] . '">Renew</a>
          </li>';
  }
  echo '</ul>';

  mysqli_close($dbc);

  include './footer.php';
?>
