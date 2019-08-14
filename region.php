<?php
  require_once('dbc.php');

  $region = $_GET['region'];
  $page_number = $_GET['page'];
  $items_per_page = 10;
  $offset = ($page_number - 1) * $items_per_page;

  $query = "SELECT ads.*, region.title AS region, sub.title AS subcategory
    FROM cls_ads AS ads
    INNER JOIN cls_regions AS region ON ads.region_id = region.id
    INNER JOIN cls_categories AS sub ON ads.subcategory_id = sub.id
    WHERE region.title = '$region'
    ORDER BY published DESC
    LIMIT $items_per_page OFFSET $offset";
  $data = mysqli_query($dbc, $query) or die('region.php mysql error');

  $items = [];
  while ($i = mysqli_fetch_assoc($data)) {
    $items[] = $i;
  }

  $query = "SELECT COUNT(*) AS total, region.title AS region
    FROM cls_ads AS ads
    INNER JOIN cls_regions AS region ON ads.region_id = region.id
    WHERE region.title = '$region'";
  $res = mysqli_query($dbc, $query);
  $total = mysqli_fetch_row($res);

  mysqli_close($dbc);

  header('Access-Control-Allow-Origin: *', false);
  header('Content-type: application/json', false);
  header('HTTP/1.1 200 OK');

  $data = (object)[];
  $data->items = $items;
  $data->page = $page_number;
  $data->total = $total[0];

  echo json_encode($data, JSON_PRETTY_PRINT);
?>
