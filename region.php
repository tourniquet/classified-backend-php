<?php
  require_once('dbc.php');

  $region = $_GET['region'];

  $query = "SELECT ads.*, region.title AS region
    FROM cls_ads AS ads
    INNER JOIN cls_regions AS region ON ads.region_id = region.id
    WHERE region.title = '$region'
  ";
  $data = mysqli_query($dbc, $query) or die('region.php mysql error');

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
