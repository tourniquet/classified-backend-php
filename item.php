<?php
  require_once('config.php');
  require_once('dbc.php');

  $query = "SELECT * FROM cls_ads WHERE id = " . $_GET['id'];
  $data = mysqli_query($dbc, $query) or die('mysql_error');
  $res = mysqli_fetch_assoc($data);

  echo json_encode($res);

  mysqli_close($dbc);
?>
