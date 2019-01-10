<?php
  require_once('dbc.php');

  $data = file_get_contents('php://input');
  $raw_query = 'some, description, here'; // json_decode($data, true);
  $query = explode(' ', str_replace(', ', ' ', $raw_query));

  $keywords = array();
  foreach ($query as $keyword) {
    if (!empty($keyword)) $keywords[] = "description LIKE '%$keyword%'";
  }

  $search_query = 'SELECT * FROM cls_ads ';
  $where_clause = implode(' OR ', $keywords);
  if (!empty($where_clause)) {
    $search_query .= "WHERE $where_clause";
  }

  $sql_data = mysqli_query($dbc, $search_query) or die('Some error here');

  $res = [];
  while ($i = mysqli_fetch_assoc($sql_data)) {
    $res[] = $i;
  }

  header('Access-Control-Allow-Origin: *', false);
  header('Content-type: application/json', false);
  header('HTTP/1.1 200 OK');

  echo json_encode($res);

  mysqli_close($dbc);
?>
