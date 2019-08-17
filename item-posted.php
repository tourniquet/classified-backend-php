<?php
  require_once('./private/initialize.php');
  require_once('dbc.php');

  {/* 
    TODO: I think that there will be a good idea to allow only front end host,
    which can be stored in the database and set up when back-end is installed
  */}
  header('Access-Control-Allow-Origin: *', false);

  define('THUMBNAIL_SIZE', 375);

  $data = $_POST;
  $url = $data['url'];
  $user_id = (!empty($data['userId'])) ? $data['userId'] : "NULL";
  $user_email = (isset($data['email'])) ? $data['email'] : "NULL";
  $ad_title = db_escape($dbc, $data['title']);
  $ad_description = db_escape($dbc, $data['description']);
  $phone = db_escape($dbc, $data['phone']);
  $visitor_name = db_escape($dbc, $data['visitor-name']);
  $ad_price = db_escape($dbc, $data['price']);
  $subcategory_id = db_escape($dbc, $data['subcategoryId']);
  $currency_id = db_escape($dbc, $data['currencyId']);
  $region_id = db_escape($dbc, $data['regionId']);


  if ($url && $ad_title && $ad_description && $visitor_name) {
    $query = "INSERT INTO cls_ads (
        url,
        user_id,
        user_email,
        visitor_name,
        title,
        description,
        phone,
        price,
        currency_id,
        subcategory_id,
        region_id
      )
      VALUES (
        '$url',
        $user_id,
        '$user_email',
        '$visitor_name',
        '$ad_title',
        '$ad_description',
        '$phone',
        '$ad_price',
        '$currency_id',
        '$subcategory_id',
        '$region_id'
      )";
    mysqli_query($dbc, $query) or die(mysqli_error($dbc));

    // to be used in 'insert image name into table' query
    $ad_id = mysqli_insert_id($dbc);

    // move each image in uploads/ folder
    foreach ($_FILES['images']['tmp_name'] as $key => $name) {
      if (!empty($_FILES['images']['tmp_name'][$key])) {
        $temp_name = $_FILES['images']['tmp_name'][$key];
        $image_extension = pathinfo($_FILES['images']['name'][$key]);
        $image_name = $url . '_' . $key . '.' . $image_extension['extension'];
        $image_path = UPLOADS_PATH . $image_name;
        $thumbnail_name = 'thumb_' . $image_name;
        $thumbnail_path = UPLOADS_PATH . $thumbnail_name;

        $src_image_width = getimagesize($temp_name)[0];
        $src_image_height = getimagesize($temp_name)[1];
        $src_image_type = getimagesize($temp_name)[2];

        // aspect ratio formula
        // if width > height -> (original height / original width) * new width = new height
        if ($src_image_width > $src_image_height) {
          $new_image_width = 800;
          $new_image_height = ($src_image_height / $src_image_width) * $new_image_width;
          $thumbnail_width = THUMBNAIL_SIZE;
          $thumbnail_height = ($src_image_height / $src_image_width) * $thumbnail_width;
        } elseif ($src_image_height >= $src_image_width) {
          $new_image_height = 800;
          $new_image_width = ($src_image_width / $src_image_height) * $new_image_height;
          $thumbnail_height = THUMBNAIL_SIZE;
          $thumbnail_width = ($src_image_width / $src_image_height) * $thumbnail_height;
        }

        if ($src_image_type == IMAGETYPE_JPEG) {
          $create_new_image = imagecreatefromjpeg($temp_name);
          $target_layer = imagecreatetruecolor($new_image_width, $new_image_height);
          imagecopyresampled($target_layer, $create_new_image, 0, 0, 0, 0, $new_image_width, $new_image_height, $src_image_width, $src_image_height);
          $resized_image = imagejpeg($target_layer, $image_path);

          $target_layer = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
          imagecopyresampled($target_layer, $create_new_image, 0, 0, 0, 0, $thumbnail_width, $thumbnail_height, $src_image_width, $src_image_height);
          $thumbnail = imagejpeg($target_layer, $thumbnail_path);
        }
    
        move_uploaded_file($resized_image, $image_path);
        move_uploaded_file($thumbnail, $thumbnail_path);
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
      // mail('mail@example.com', '$subject', '$msg', 'mail@example.com');
      echo json_encode(['url' => $url]);
    }

    mysqli_close($dbc);
  } else {
    // TODO: To find what header should be send to front end if something is wrong
  }
?>
