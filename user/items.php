<?php
  require_once('../dbc.php');

  $raw_data = file_get_contents('php://input');
  $credentials = json_decode($raw_data, true);
  $page_number = $_GET['page'];
  $items_per_page = 10;
  $offset = ($page_number - 1) * $items_per_page;

  $user_id = mysqli_real_escape_string($dbc, trim($credentials['userId']));
  $user_email = mysqli_real_escape_string($dbc, trim(strtolower($credentials['userEmail'])));

  $query = "SELECT ads.*, sub.name AS subcategory, cat.name AS category
    FROM cls_ads AS ads
    INNER JOIN cls_categories AS sub ON ads.subcategory_id = sub.id
    INNER JOIN cls_categories AS cat ON sub.parent_id = cat.id
    WHERE user_id = '$user_id' AND user_email = '$user_email'
    ORDER BY published DESC
    LIMIT $items_per_page OFFSET $offset";
  $res = mysqli_query($dbc, $query);

  $items = [];
  while ($i = mysqli_fetch_assoc($res)) {
    $items[] = $i;
  }

  $query = "SELECT COUNT(*) AS total
    FROM cls_ads
    WHERE user_id = '$user_id'
    AND user_email = '$user_email'";
  $res = mysqli_query($dbc, $query);
  $total = mysqli_fetch_row($res);

  mysqli_close($dbc);

  header('Access-Control-Allow-Origin: *', false);
  header('Content-type: application/json', false);
  header('HTTP/1.1 200 OK');

  if (empty($user_id) || empty($user_email)) {
    echo json_encode(['error' => 'User must be logged in to acces this page!']);
    return;
  }

  $data = (object)[];
  $data->items = $items;
  $data->page = $page_number;
  $data->total = $total[0];

  echo json_encode($data, JSON_PRETTY_PRINT);
?>
