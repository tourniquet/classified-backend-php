<?php
  require_once('config.php');

  $raw_data = file_get_contents('php://input');
  $data = json_decode($raw_data, true);

  $visitor_name = $data['name'];
  $ad_title = $data['title'];
  $ad_description = $data['description'];
  $ad_price = $data['price'];
  // $image = $_FILES['image']['name'];
  
  // $file_target = UPLOADS_PATH . $image;
  // move_uploaded_file($_FILES['image']['tmp_name'], $file_target);

  // echo "<h2>Your ad \"$ad_title\" was posted!</h2>";
  // echo '<img src="' . UPLOADS_PATH . $image . '" alt="some alt">';

  require_once('dbc.php');
  $query = "INSERT INTO cls_ads (pub_date, name, title, description, price) VALUES (NOW(), '$visitor_name', '$ad_title', '$ad_description', '$ad_price')";
  $result = mysqli_query($dbc, $query) or die('Error querying database.');
  mysqli_close($dbc);

  // try to delete temporary image
  // @unlink($_FILES['image']['tmp_name']);
?>
