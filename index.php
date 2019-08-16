<?php
  require_once('./private/initialize.php');
  require_once('dbc.php');

  $page_number = isset($_GET['page']) ? db_escape($dbc, $_GET['page']) : 1;
  $items_per_page = 10;
  $offset = ($page_number - 1) * $items_per_page;

  $query = "SELECT ads.*, sub.name AS subcategory, cat.name AS category
    FROM cls_ads AS ads
    INNER JOIN cls_categories AS sub ON ads.subcategory_id = sub.id
    INNER JOIN cls_categories AS cat ON sub.parent_id = cat.id
    ORDER BY published DESC
    LIMIT $items_per_page OFFSET $offset";
  $res = mysqli_query($dbc, $query);

  $items = [];
  while ($i = mysqli_fetch_assoc($res)) {
    $items[] = $i;
  }

  $query = "SELECT COUNT(*) AS total FROM cls_ads";
  $res = mysqli_query($dbc, $query);
  $total = mysqli_fetch_row($res);

  mysqli_close($dbc);

  // send data as a valid JSON and allow Origin Access
  {/* 
    TODO: I think that there will be a good idea to allow only front end host,
    which can be stored in the database and set up when back-end is installed
  */}
  header('Access-Control-Allow-Origin: *', false);
  header('Content-type: application/json', false);
  header('HTTP/1.1 200 OK');

  $data = (object)[];
  $data->items = $items;
  $data->page = $page_number;
  $data->total = $total[0];

  echo json_encode($data, JSON_PRETTY_PRINT);
?>
