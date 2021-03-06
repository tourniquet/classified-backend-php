<?php
  require_once('./private/initialize.php');
  require_once('dbc.php');

  {/* 
    TODO: I think that there will be a good idea to allow only front end host,
    which can be stored in the database and set up when back-end is installed
  */}
  header('Access-Control-Allow-Origin: *', false);

  define('THUMBNAIL_SIZE', 215);

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
        $image_name = $url . '_' . $key . '.jpg';
        $image_path = UPLOADS_PATH . $image_name;
        $thumbnail_name = 'thumb_' . $image_name;
        $thumbnail_path = UPLOADS_PATH . $thumbnail_name;

        list($src_image_width, $src_image_height) = getimagesize($temp_name);
        $mime = getimagesize($temp_name)['mime'];

        switch ($mime) {
          case 'image/gif':
            $image_create = "imagecreatefromgif";
            $image = "imagegif";
            break;
          case 'image/png':
            $image_create = "imagecreatefrompng";
            $image = "imagepng";
            $quality = 7;
            break;
          case 'image/jpeg':
            $image_create = "imagecreatefromjpeg";
            $image = "imagejpeg";
            $quality = 100;
            break;
          default:
            return false;
            break;
        }

        // aspect ratio formula
        // if width > height -> (original height / original width) * new width = new height
        if ($src_image_width > $src_image_height) {
          $new_image_width = 800;
          $new_image_height = ($src_image_height / $src_image_width) * $new_image_width;
          $thumbnail_height = THUMBNAIL_SIZE;
          $thumbnail_width = ($src_image_width / $src_image_height) * THUMBNAIL_SIZE;
        } elseif ($src_image_height >= $src_image_width) {
          $new_image_height = 800;
          $new_image_width = ($src_image_width / $src_image_height) * $new_image_height;
          $thumbnail_width = THUMBNAIL_SIZE;
          $thumbnail_height = ($src_image_height / $src_image_width) * THUMBNAIL_SIZE; // (922 / 509) * 215 = 389
        }

        $new_image = $image_create($temp_name);
        $target_layer = imagecreatetruecolor($new_image_width, $new_image_height);
        imagecopyresampled($target_layer, $new_image, 0, 0, 0, 0, $new_image_width, $new_image_height, $src_image_width, $src_image_height);
        $resized_image = imagejpeg($target_layer, $image_path);

        // create thumbnail
        if ($src_image_width > $src_image_height) {
          $x_axis = round(($src_image_width - $src_image_height) / 2);
          $cropped = imagecrop(imagecreatetruecolor($thumbnail_width, $thumbnail_height), ['x' => 0, 'y' => 0, 'width' => THUMBNAIL_SIZE, 'height' => THUMBNAIL_SIZE]);
          imagecopyresampled($cropped, $new_image, 0, 0, $x_axis, 0, $thumbnail_width, $thumbnail_height, $src_image_width, $src_image_height);
        } elseif ($src_image_height >= $src_image_width) {
          $y_axis = round(($src_image_height - $src_image_width) / 2);
          $cropped = imagecrop(imagecreatetruecolor($thumbnail_width, $thumbnail_height), ['x' => 0, 'y' => 0, 'width' => THUMBNAIL_SIZE, 'height' => THUMBNAIL_SIZE]);
          imagecopyresampled($cropped,$new_image, 0, 0, 0, $y_axis, $thumbnail_width, $thumbnail_height, $src_image_width, $src_image_height);
        }

        $thumbnail = imagejpeg($cropped, $thumbnail_path);

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
