<?php
  require_once('../private/initialize.php');
  require_once('../dbc.php');

  if (is_post_request()) {
    $items = implode(',', $_POST['items']);

    $images_query = "SELECT *
      FROM cls_images
      WHERE ad_id IN ($items)";
    $images = mysqli_query($dbc, $images_query);

    while ($row = mysqli_fetch_assoc($images)) {
      // remove every single image from uploads folder
      @unlink('../' . UPLOADS_PATH . $row['image']);
      @unlink('../' . UPLOADS_PATH . 'thumb_' . $row['image']);
    }

    $remove_ad_query = "DELETE
      FROM cls_ads
      WHERE id IN ($items)";
    mysqli_query($dbc, $remove_ad_query);

    mysqli_close($dbc);
  }

  redirect_to('index.php?page=1');
?>
