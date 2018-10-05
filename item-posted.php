<?php
  require_once('dbc.php');

  {/* 
    TODO: I think that there will be a good idea to allow only front end host,
    which can be stored in the database and set up when back-end is installed
  */}
  header('Access-Control-Allow-Origin: *', false);

  $data = $_POST;

  $url = $data['url'];
  $ad_title = mysqli_real_escape_string($dbc, $data['title']);
  $ad_description = mysqli_real_escape_string($dbc, $data['description']);
  $phone = $data['phone'];
  $visitor_name = $data['name'];
  $ad_price = $data['price'];

  if ($url && $ad_title && $ad_description && $visitor_name) {
    $query = "INSERT INTO cls_ads (url, published, name, title, description, phone, price)
      VALUES ('$url', NOW(), '$visitor_name', '$ad_title', '$ad_description', '$phone', '$ad_price')";
    mysqli_query($dbc, $query) or die('Error querying database.');

    // to be used in 'insert image name into table' query
    $ad_id = mysqli_insert_id($dbc);

    function resize_image ($image) {
      // write something smart here
      // https://www.minddevelopmentanddesign.com/blog/image-resize-crop-thumbnail-watermark-php-script/
      // https://www.sitepoint.com/image-resizing-php/
      // https://itsolutionstuff.com/post/how-to-upload-and-resize-image-in-php-example.html

      // aspect ratio formula
      // if width > height -> (original height / original width) * new width = new height
      // if height > width (original width / original height) * new height = new width
      // (600 / 800) * 500 = 375
    }

    // move each image in uploads/ folder
    foreach ($_FILES['images']['tmp_name'] as $key => $name) {
      if (!empty($_FILES['images']['tmp_name'][$key])) {
        $temp_name = $_FILES['images']['tmp_name'][$key];
        $image_extension = pathinfo($_FILES['images']['name'][$key]);
        $image_name = $url . '_' . $key . '.' . $image_extension['extension'];
        $image_path = UPLOADS_PATH . $image_name;
    
        move_uploaded_file($temp_name, $image_path);
        // remove temporary image
        unlink($temp_name);

        $query = "INSERT INTO cls_images (image, ad_id)
          VALUES ('$image_name', '$ad_id')";
        mysqli_query($dbc, $query);
      }
    }

    
    // TODO: if !error, send an email to site admin
    if (mysqli_affected_rows($dbc)) {
      header('HTTP/1.1 200 OK');
      // mail('admyn3d@gmail.com', '$subject', '$msg', 'admyn3d@gmail.com');
      // echo json_encode('$res');
    }

    mysqli_close($dbc);
  } else {
    // TODO: To find what header should be send to front end if something is wrong
  }
?>
