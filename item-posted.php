<?php
  require_once('dbc.php');

  {/* 
    TODO: I think that there will be a good idea to allow only front end host,
    which can be stored in the database and set up when back-end is installed
  */}
  header('Access-Control-Allow-Origin: *', false);

  $data = $_POST; // file_get_contents('php://input');

  $url = $data['url'];
  $ad_title = mysqli_real_escape_string($dbc, $data['title']);
  $ad_description = mysqli_real_escape_string($dbc, $data['description']);
  $phone = $data['phone'];
  $visitor_name = $data['name'];
  $ad_price = $data['price'];

  // move each image in uploads/ folder
  foreach ($_FILES['images']['tmp_name'] as $key => $name) {
    $image = $_FILES['images']['name'][$key];
    $temp_name = $_FILES['images']['tmp_name'][$key];

    move_uploaded_file($temp_name, UPLOADS_PATH . $image);
  }

  if ($url && $ad_title && $ad_description && $visitor_name) {
    header('HTTP/1.1 200 OK');

    $query = "INSERT INTO cls_ads (url, published, name, title, description, phone, price)
      VALUES ('$url', NOW(), '$visitor_name', '$ad_title', '$ad_description', '$phone', '$ad_price')";
    mysqli_query($dbc, $query) or die('Error querying database.');

    // TODO: if !error, send an email to site admin
    // if (mysqli_affected_rows($query)) {
      // mail('admyn3d@gmail.com', '$subject', '$msg', 'admyn3d@gmail.com');
      // echo json_encode('$res');
    // }

    mysqli_close($dbc);
  } else {
    // TODO: To find what header should be send to front end if something is wrong
  }

  // get last posted ad id and send it to the client
  // $query = "SELECT ";
  // $result = mysqli_query($dbc, $query) or die('Error querying database.');

  // try to delete temporary image
  // @unlink($_FILES['image']['tmp_name']);
?>
