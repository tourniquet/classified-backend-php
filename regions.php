<?php
  require_once('dbc.php');

  $query = "SELECT * FROM cls_regions";
  $data = mysqli_query($dbc, $query) or die('Error querying regions');

  $res = [];
  while ($i = mysqli_fetch_assoc($data)) {
    $res[] = $i;
  }

  header('Access-Control-Allow-Origin: *', false);
  header('Content-type: application/json', false);
  header('HTTP/1.1 200 OK');

  echo json_encode($res);

  mysqli_close($dbc);
?>
