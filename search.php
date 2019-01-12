<?php
  require_once('dbc.php');

  $data = file_get_contents('php://input');
  $keywords = explode(' ', str_replace(', ', ' ', json_decode($data, true)));

  $description_query = array();
  foreach ($keywords as $keyword) {
    if (!empty($keyword)) $description_query[] = "description LIKE '%$keyword%'";
  }

  $query = 'SELECT * FROM cls_ads ';
  $where_clause = implode(' OR ', $description_query);
  if (!empty($where_clause)) {
    $query .= "WHERE $where_clause";
  }

  $sql_data = mysqli_query($dbc, $query) or die('Some error here');

  $results = [];
  while ($i = mysqli_fetch_assoc($sql_data)) {
    $results[] = $i;
  }

  header('Access-Control-Allow-Origin: *', false);
  header('Content-type: application/json', false);
  header('HTTP/1.1 200 OK');

  echo json_encode($results);

  mysqli_close($dbc);
?>
