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

    $category_id = $_GET['id'];
    $category = return_field_name('cls_categories', $category_id);

    if (is_post_request()) {
      delete_item('cls_categories', $category_id);
    }
  ?>

  <main>
    <a href="index.php?page=1"><<< Back</a>
    <br>

    <form action="remove-category.php?id=<?php echo $category_id; ?>" method="POST">
      <span>Are you sure you want to remove <?php echo $category['title']; ?>?</span>
      <button>Remove category</button>
    </form>
  </main>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
