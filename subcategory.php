<?php
  require_once('dbc.php');

  $query = "SELECT ads.*, sub.title AS subcategory
    FROM cls_ads AS ads
    INNER JOIN cls_categories AS sub ON ads.subcategory_id = sub.id
    WHERE sub.title = '" . $_GET['subcategory'] . "'";
  $data = mysqli_query($dbc, $query) or die('subcategory.php mysql error');

  $res = [];
  while ($i = mysqli_fetch_assoc($data)) {
    $res[] = $i;
  }

  header('Access-Control-Allow-Origin: *', false);
  header('Content-type: application/json', false);
  header('HTTP/1.1. 200 OK');

  echo json_encode($res);

  mysqli_close($dbc);
?>
