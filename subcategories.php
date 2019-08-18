<?php
  require_once('./private/initialize.php');
  require_once('dbc.php');

  // index page don't use a parameter to fetch subcategories,
  // but item-new does.
  $query_parameter = isset($_GET['parent_id']) ? ' = ' . db_escape($dbc, $_GET['parent_id']) : 'IS NOT NULL';
  $query = "SELECT *
    FROM cls_categories 
    WHERE parent_id $query_parameter";
  $data = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
  mysqli_close($dbc);

  $subcategories = [];
  while ($i = mysqli_fetch_assoc($data)) {
    $subcategories[] = $i;
  }

  header('Access-Control-Allow-Origin: *', false);
  header('Content-type: application/json', false);
  header('HTTP/1.1 200 OK');

  echo json_encode($subcategories, JSON_PRETTY_PRINT);
?>
