<?php
  require_once('../private/initialize.php');
  include(SHARED_PATH . '/head.php');
?>

<div class="admin-panel">
  <?php
    include(SHARED_PATH . '/header.php');
    include(SHARED_PATH . '/sidebar.php');

    require_once('../private/initialize.php');
    require_once('../dbc.php');
    
    $item_id = db_escape($dbc, $_GET['id']);
    $images_query = "SELECT *
      FROM cls_images
      WHERE ad_id = $item_id";
    $images = mysqli_query($dbc, $images_query);

    while ($row = mysqli_fetch_assoc($images)) {
      // remove every single image related to removed ad from uploads folder
      @unlink('../' . UPLOADS_PATH . $row['image']);
      @unlink('../' . UPLOADS_PATH . 'thumb_' . $row['image']);

      // Remove ad images from _images table
      $remove_images_query = "DELETE
        FROM cls_images
        WHERE ad_id = '$item_id'";
      mysqli_query($dbc, $remove_images_query);
    }

    $item = return_field_name('cls_ads', $item_id);

    if (is_post_request()) {
      delete_item('cls_ads', $item_id);
    }

    mysqli_close($dbc);
  ?>

  <main>
    <a href="/classified/backend/admin"><<< Back</a>
    <br>

    <form action="remove-item.php?id=<?php echo $item_id; ?>" method="POST">
      <span>Are you sure you want to remove <?php echo $item['title']; ?>?</span>
      <button>Remove item</button>
    </form>
  </main>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
