<?php
  require_once('./private/initialize.php');
  require_once('dbc.php');

  $page_number = isset($_GET['page']) ? db_escape($dbc, $_GET['page']) : 1;
  $items_per_page = 10;
  $offset = ($page_number - 1) * $items_per_page;

  $id = db_escape($dbc, $_GET['id']);
  $query = "SELECT *
    FROM cls_ads
    WHERE user_id = '$id' AND enabled = 1
    ORDER BY published DESC
    LIMIT $items_per_page OFFSET $offset";
  $user_items = mysqli_query($dbc, $query);

  $items = [];
  while ($item = mysqli_fetch_assoc($user_items)) {
    $items[] = $item;
  }

  $query = "SELECT COUNT(*) AS total
    FROM cls_ads
    WHERE user_id = '$id'";
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
