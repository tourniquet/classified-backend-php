<?php
  require_once('../private/initialize.php');
  require_once('../dbc.php');

  $raw_data = file_get_contents('php://input');
  $data = json_decode($raw_data, true);
  $page_number = isset($_GET['page']) ? db_escape($dbc, $_GET['page']) : 1;
  $items_per_page = 10;
  $offset = ($page_number - 1) * $items_per_page;

  $id = db_escape($dbc, $data['id']);
  $query = "SELECT ads.*, sub.name AS subcategory, cat.name AS category
    FROM cls_ads AS ads
    INNER JOIN cls_categories AS sub ON ads.subcategory_id = sub.id
    INNER JOIN cls_categories AS cat ON sub.parent_id = cat.id
    WHERE user_id = '$id' AND enabled = 1
    ORDER BY published DESC
    LIMIT $items_per_page OFFSET $offset";
  $user_items = mysqli_query($dbc, $query);

  $items = [];
  while ($item = mysqli_fetch_assoc($user_items)) {
    $items[] = $item;
  }

    // If an item have at least one image, JSON returned will contain images: value
  // images query
  $query = "SELECT *
    FROM cls_images";
  $result = mysqli_query($dbc, $query);
  $images = [];
  while ($i = mysqli_fetch_assoc($result)) {
    $images[] = $i;
  }

  $images_length = sizeof($images);
  $items_length = sizeof($items);
  for ($i = 0; $i < $images_length; $i++) {
    for ($j = 0; $j < $items_length; $j++) {
      if ($items[$j]['id'] === $images[$i]['ad_id']) {
        $items[$j]['images'] = $images[$i]['image'];
      }
    }
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
