<?php
  require_once('config.php');
  require_once('dbc.php');

  {/* 
    TODO: I think that there will be a good idea to allow only front end host,
    which can be stored in the database and set up when back-end is installed
  */}
  header("Access-Control-Allow-Origin: *", false);

  $raw_data = file_get_contents('php://input');
  $data = json_decode($raw_data, true);

  print_r($data);

  $url = $data['url'];
  $visitor_name = $data['name'];
  $ad_title = $data['title'];
  $ad_description = $data['description'];
  $ad_price = $data['price'];
  // $image = $_FILES['image']['name'];
  
  // $file_target = UPLOADS_PATH . $image;
  // move_uploaded_file($_FILES['image']['tmp_name'], $file_target);

  $query = "INSERT INTO cls_ads (url, published, name, title, description, price)
    VALUES ('$url', NOW(), '$visitor_name', '$ad_title', '$ad_description', '$ad_price')";
  $result = mysqli_query($dbc, $query) or die('Error querying database.');

  // get last posted ad id and send it to the client
  // $query = "SELECT ";
  // $result = mysqli_query($dbc, $query) or die('Error querying database.');

  mysqli_close($dbc);

  // try to delete temporary image
  // @unlink($_FILES['image']['tmp_name']);
?>
