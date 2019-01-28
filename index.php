<?php
  require_once('dbc.php');

  $query = "SELECT * FROM cls_ads ORDER BY published DESC";
  $data = mysqli_query($dbc, $query);

  $res = [];
  while ($i = mysqli_fetch_assoc($data)) {
    $res[] = $i;
  }

  // send data as a valid JSON and allow Origin Access
  {/* 
    TODO: I think that there will be a good idea to allow only front end host,
    which can be stored in the database and set up when back-end is installed
  */}
  header('Access-Control-Allow-Origin: *', false);
  header('Content-type: application/json', false);
  header('HTTP/1.1 200 OK');
  echo json_encode($res);

  mysqli_close($dbc);
?>
