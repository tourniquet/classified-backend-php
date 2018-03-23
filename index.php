<?php
  require_once('config.php');

  require_once('dbc.php');
  $query = "SELECT * FROM cls_ads ORDER BY pub_date DESC";
  $data = mysqli_query($dbc, $query);

  // if (isset($_COOKIE['email'])) {
  //   echo '<a href="logout.php">Logout</a>';
  // } else {
  //   echo '<a href="login.php">Login</a>';
  // }

  $res = [];

  while ($i = mysqli_fetch_array($data)) {
    $res[] = $i;
  }

  echo json_encode($res);

  mysqli_close($dbc);
?>
