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

    $subcategory_id = $_GET['id'];
    $parent_id = $_GET['parent_id'];
    $subcategory = return_field_name('cls_categories', $subcategory_id);

    if (is_post_request()) {
      $query = "DELETE
        FROM cls_categories
        WHERE id = $subcategory_id AND parent_id = $parent_id
        LIMIT 1";
      mysqli_query($dbc, $query) or die('Error deleting subcategory');
      mysqli_close($dbc);

      redirect_to('index.php?page=1');
    }
  ?>

  <main>
    <a href="index.php?page=1"><<< Back</a>
    <br>

    <form action='remove-subcategory.php?id=<?php echo "$subcategory_id&parent_id=$parent_id" ?>' method="POST">
      <span>Are you sure you want to remove <?php echo $subcategory['title']; ?>?</span>
      <button>Remove subcategory</button>
    </form>
  </main>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
