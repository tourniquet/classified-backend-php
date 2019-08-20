<?php
  require_once('dbc.php');

  $query = "SELECT *
    FROM cls_regions";
  $data = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
  mysqli_close($dbc);

  $regions = [];
  while ($i = mysqli_fetch_assoc($data)) {
    $regions[] = $i;
  }

  header('Access-Control-Allow-Origin: *', false);
  header('Content-type: application/json', false);
  header('HTTP/1.1 200 OK');

  echo json_encode($regions, JSON_PRETTY_PRINT);
?>
