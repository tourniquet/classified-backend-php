<?php
  require_once('config.php');
  require_once('dbc.php');

  $query = "SELECT * FROM cls_ads WHERE url = " . $_GET['url'];
  $data = mysqli_query($dbc, $query) or die('mysql_error');
  $res = mysqli_fetch_assoc($data);
  // send data as a valid JSON and allow Origin Access
  {/* 
    TODO: I think that there will be a good idea to allow only front end host,
    which can be stored in the database and set up when back-end is installed
  */}
  header('Access-Control-Allow-Origin: *', false);
  header('Content-type: application/json');
  echo json_encode($res);

  // increment views when ad is viewed
  $query = "UPDATE cls_ads SET views = views + 1 WHERE url = " . $_GET['url'];
  $update = mysqli_query($dbc, $query)
    or die('mysql throw an error when tried to update views column');

  mysqli_close($dbc);
?>
