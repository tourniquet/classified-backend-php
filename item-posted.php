<?php
  require_once('dbc.php');

  {/* 
    TODO: I think that there will be a good idea to allow only front end host,
    which can be stored in the database and set up when back-end is installed
  */}
  header('Access-Control-Allow-Origin: *', false);

  $data = $_POST; // file_get_contents('php://input');
  // $data = json_decode($raw_data, true);

  $url = $data['url'];
  $ad_title = mysqli_real_escape_string($dbc, $data['title']);
  $ad_description = mysqli_real_escape_string($dbc, $data['description']);
  $phone = $data['phone'];
  $visitor_name = $data['name'];
  $ad_price = $data['price'];

  $first_image = $_FILES['image']['name'][0];
  $first_file_target = UPLOADS_PATH . $first_image;
  move_uploaded_file($_FILES['image']['tmp_name'][0], $first_file_target);

  $second_image = $_FILES['image']['name'][1];
  $second_file_target = UPLOADS_PATH . $second_image;
  move_uploaded_file($_FILES['image']['tmp_name'][1], $second_file_target);

  if ($url) { //  && $ad_title && $ad_description && $visitor_name
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
