<?php
  require_once('dbc.php');

  $subcategory = $_GET['subcategory'];
  $page_number = $_GET['page'];
  $items_per_page = 10;
  $offset = ($page_number - 1) * $items_per_page;

  $query = "SELECT ads.*, sub.name AS subcategory, cat.name AS category
    FROM cls_ads AS ads
    INNER JOIN cls_categories AS sub ON ads.subcategory_id = sub.id
    WHERE sub.name = '$subcategory'
    ORDER BY published DESC
    LIMIT $items_per_page OFFSET $offset";
  $res = mysqli_query($dbc, $query) or die('subcategory.php mysql error');

  $items = [];
  while ($i = mysqli_fetch_assoc($res)) {
    $items[] = $i;
  }

  $query = "SELECT COUNT(*) AS total, sub.name AS subcategory
    FROM cls_ads AS ads
    INNER JOIN cls_categories AS sub ON ads.subcategory_id = sub.id
    WHERE sub.name = '$subcategory'";
  $res = mysqli_query($dbc, $query);
  $total = mysqli_fetch_row($res);

  mysqli_close($dbc);

  header('Access-Control-Allow-Origin: *', false);
  header('Content-type: application/json', false);
  header('HTTP/1.1. 200 OK');

  $data = (object)[];
  $data->items = $items;
  $data->page = $page_number;
  $data->total = $total[0];

  echo json_encode($data, JSON_PRETTY_PRINT);
?>
