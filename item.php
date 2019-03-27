<?php
  require_once('dbc.php');

  $query = "SELECT ads.*, sub.title AS subcategory, cat.title AS category
    FROM cls_ads as ads
    INNER JOIN cls_categories as sub ON ads.subcategory_id = sub.id
    INNER JOIN cls_categories AS cat ON sub.parent_id = cat.id
    WHERE ads.url = " . $_GET['url'];
  $data = mysqli_query($dbc, $query) or die('mysql_error');
  $res = mysqli_fetch_assoc($data);
  // send data as a valid JSON and allow Origin Access
  {/* 
    TODO: I think that there will be a good idea to allow only front end host,
    which can be stored in the database and set up when back-end is installed
  */}

  $query = "SELECT * FROM cls_images WHERE ad_id = " . $res['id'];
  $data = mysqli_query($dbc, $query) or die('mysql_error');
  $images = [];
  while ($row = $data -> fetch_row()) {
    $images[] = $row[0];
  }
  $res['images'] = $images;

  header('Access-Control-Allow-Origin: *', false);
  header('Content-type: application/json', false);
  header('HTTP/1.1 200 OK');

  echo json_encode($res);

  // increment views when ad is viewed
  $query = "UPDATE cls_ads SET views = views + 1 WHERE url = " . $_GET['url'];
  mysqli_query($dbc, $query)
    or die('mysql throw an error when tried to update views column');

  mysqli_close($dbc);
?>
