<?php
  require_once('dbc.php');

  // index page don't use a parameter to fetch subcategories,
  // but item-new does.
  $query_parameter = isset($_GET['id']) ? "= " . $_GET['id'] : 'IS NOT NULL';
  $query = "SELECT * FROM cls_categories 
    WHERE parent_id " . $query_parameter; // $query_subcategories
  $data = mysqli_query($dbc, $query) or die('mysql_error');

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
