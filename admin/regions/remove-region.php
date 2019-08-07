<?php
  require_once('../../private/initialize.php');
  include(SHARED_PATH . '/head.php');
?>

<div class="admin-panel">
  <?php
    include(SHARED_PATH . '/header.php');
    include(SHARED_PATH . '/sidebar.php');

    require_once('../../private/initialize.php');
    require_once('../../dbc.php');

    $region_id = $_GET['id'];
    $region = return_field_name('cls_regions', $region_id);

    if (is_post_request()) {
      delete_item('cls_regions', $region_id);
    }
  ?>

  <main>
    <a href="index.php?page=1"><<< Back</a>
    <br>

    <form action="remove-region.php?id=<?php echo $region_id; ?>" method="POST">
      <span>Are you sure you want to remove <?php echo $region['title']; ?>?</span>
      <button>Remove region</button>
    </form>
  </main>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
