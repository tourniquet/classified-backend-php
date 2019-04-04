<?php
  require_once('dbc.php');

  $query = "SELECT ads.*, sub.title AS subcategory, cat.title AS category
    FROM cls_ads AS ads
    INNER JOIN cls_categories AS sub ON ads.subcategory_id = sub.id
    INNER JOIN cls_categories AS cat ON sub.parent_id = cat.id
    WHERE cat.title = '" . $_GET['url'] . "'";
  $data = mysqli_query($dbc, $query) or die('category.php mysql error');

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
