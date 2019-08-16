<?php
  require_once('dbc.php');

  /**
   * TODO: When a solution will be found how to JOIN currencies if there is a price set for the item,
   * remove INSERT query to cls_currencies from install.php
   */
  $url = db_escape($dbc, $_GET['url']);
  $query = "SELECT ads.*, sub.name AS subcategory, cat.name AS category, currency.name AS currency, region.name AS region
    FROM cls_ads AS ads
    INNER JOIN cls_categories AS sub ON ads.subcategory_id = sub.id
    INNER JOIN cls_categories AS cat ON sub.parent_id = cat.id
    INNER JOIN cls_currencies AS currency ON ads.currency_id = currency.id
    INNER JOIN cls_regions AS region ON ads.region_id = region.id
    WHERE ads.url = " . $_GET['url'];
  $data = mysqli_query($dbc, $query) or die('mysql_error');
  $res = mysqli_fetch_assoc($data);
  // send data as a valid JSON and allow Origin Access
  {/* 
    TODO: I think that there will be a good idea to allow only front end host,
    which can be stored in the database and set up when back-end is installed
  */}

  $query = "SELECT * FROM cls_images WHERE ad_id = " . $res['id'];
  $data = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
  $images = [];
  while ($row = $data -> fetch_row()) {
    $images[] = $row[0];
  }
  $res['images'] = $images;

  header('Access-Control-Allow-Origin: *', false);
  header('Content-type: application/json', false);
  header('HTTP/1.1 200 OK');

  echo json_encode($result, JSON_PRETTY_PRINT);

  // increment views when ad is viewed
  $query = "UPDATE cls_ads SET views = views + 1 WHERE url = " . $_GET['url'];
  mysqli_query($dbc, $query) or die(mysqli_error($dbc));
  mysqli_close($dbc);
?>
