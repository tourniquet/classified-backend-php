<?php
  require_once('../../private/initialize.php');
  include(SHARED_PATH . '/head.php');
?>

<div class="admin-panel">
  <?php
    include(SHARED_PATH . '/header.php');
    include(SHARED_PATH . '/sidebar.php');

    require_once('../../dbc.php');

    $category_id = $_GET['id'];
    $query = "SELECT name
      FROM cls_categories
      WHERE id = '$category_id'";
    $category = mysqli_fetch_assoc(mysqli_query($dbc, $query));
  ?>

  <main>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
      <input name="id" type="hidden" value="<?= $category_id; ?>">
      <input
        class="category-name"
        name="category"
        placeholder="Category name"
        required
        type="text"
        value="<?= $category['name']; ?>"
      >

      <button>Update</button>
    </form>
  </main>

  <?php
    if (is_post_request()) {
      $category_id = $_POST['id'];
      $category_name = $_POST['category'];
      $query = "UPDATE cls_categories
        SET name = '$category_name'
        WHERE id = '$category_id'";
      mysqli_query($dbc, $query);

      redirect_to('index.php?page=1');
    }
  ?>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
