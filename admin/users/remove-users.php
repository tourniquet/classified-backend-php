<?php
  require_once('../../private/initialize.php');
  include(SHARED_PATH . '/head.php');
?>

<div class="admin-panel">
  <?php
    include(SHARED_PATH . '/header.php');
    require_once('../../dbc.php');

    if (is_post_request()) {
      $items = implode(',', $_POST['items']);

      $remove_users_query = "DELETE
        FROM cls_users
        WHERE id IN ($items)";
      mysqli_query($dbc, $remove_users_query);
      mysqli_close($dbc);
    }
  ?>

  <div>
    <a href="index.php?page=1"><<< Back</a>
  </div>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
