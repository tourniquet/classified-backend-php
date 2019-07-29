<?php
  include_once './head.php';
?>

<div class="admin-panel">
  <?php
    include_once './header.php';
    require_once('../dbc.php');
    
    $ad_id = $_GET['id'];
    $images_query = "SELECT *
      FROM cls_images
      WHERE ad_id = $ad_id";
    $images = mysqli_query($dbc, $images_query);

    while ($row = mysqli_fetch_array($images)) {
      // remove every single image from uploads folder
      @unlink('../' . UPLOADS_PATH . $row['image']);
      @unlink('../' . UPLOADS_PATH . 'thumb_' . $row['image']);

      // Remove ad item
      $remov_ad_query = 'DELETE
        FROM cls_ads
        WHERE id = ' . $_GET['id'];
      mysqli_query($dbc, $remov_ad_query);

      // Remove ad images from _images table
      $remove_images_query = 'DELETE
        FROM cls_images
        WHERE ad_id = ' . $_GET['id'];
      mysqli_query($dbc, $remove_images_query);

      echo '<h3>Ad was removed!</h3';
    }

    mysqli_close($dbc);
  ?>
    
  <div>
    <a href="/classified/backend/admin"><<< Back</a>
  </div>

  <?php
    include_once './footer.php';
  ?>
</div>
