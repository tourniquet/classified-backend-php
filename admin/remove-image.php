<?php
  require_once('../private/initialize.php');
  require_once('../dbc.php');
  
  $image = db_escape($dbc, $_GET['image']);
  $item_id = db_escape($dbc, $_GET['item']);

  // remove image from uploads folder
  if (is_file('../' . UPLOADS_PATH . $image)) {
    unlink('../' . UPLOADS_PATH . $image);
    unlink('../' . UPLOADS_PATH . 'thumb_' . $image);

    $remove_images_query = "DELETE
      FROM cls_images
      WHERE image = '$image'";
    mysqli_query($dbc, $remove_images_query);
    mysqli_close($dbc);
  }
?>
