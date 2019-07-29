<?php
  include_once './head.php';
?>

<div class="admin-panel">
  <?php
    include_once './header.php';

    require_once('../dbc.php');

    if (isset($_POST['submit']) && isset($_POST)) {
      $items = implode(',', $_POST['items']);

      $images_query = "SELECT *
        FROM cls_images
        WHERE ad_id IN ($items)";
      $images = mysqli_query($dbc, $images_query);

      while ($row = mysqli_fetch_array($images)) {
        // remove every single image from uploads folder
        @unlink('../' . UPLOADS_PATH . $row['image']);
        @unlink('../' . UPLOADS_PATH . 'thumb_' . $row['image']);

        // Remove ad images from _images table
        $remove_images_query = "DELETE
          FROM cls_images
          WHERE ad_id IN ($items)";
        mysqli_query($dbc, $remove_images_query);

        $remove_ad_query = "DELETE
          FROM cls_ads
          WHERE id IN ($items)";
        mysqli_query($dbc, $remove_ad_query);
      }
    }
  ?>

  <div>
    <a href="/classified/backend/admin"><<< Back</a>
  </div>

  <?php
    include_once './footer.php';
  ?>
</div>
