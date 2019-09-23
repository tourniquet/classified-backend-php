<?php
  require_once('./private/initialize.php');
  require_once('dbc.php');

  $data = file_get_contents('php://input');
  $keywords = explode(' ', str_replace(', ', ' ', json_decode($data, true)));
  $page_number = db_escape($dbc, $_GET['page']);
  $items_per_page = 10;
  $offset = ($page_number - 1) * $items_per_page;

  $description_query = array();
  foreach ($keywords as $keyword) {
    if (isset($keyword)) $description_query[] = "title LIKE '%$keyword%'";
  }

  $query = 'SELECT * FROM cls_ads ';
  $where_clause = implode(' OR ', $description_query);
  if (isset($where_clause)) {
    $query .= "WHERE $where_clause
      ORDER BY published DESC
      LIMIT $items_per_page OFFSET $offset";
  }

  $res = mysqli_query($dbc, $query) or die(mysqli_error($dbc));

  $items = [];
  while ($i = mysqli_fetch_assoc($res)) {
    $items[] = $i;
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
    WHERE $where_clause";
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
