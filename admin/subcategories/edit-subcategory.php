<?php
  require_once('../../private/initialize.php');
  include(SHARED_PATH . '/head.php');
?>

<div class="admin-panel">
  <?php
    include(SHARED_PATH . '/header.php');
    include(SHARED_PATH . '/sidebar.php');

    require_once('../../dbc.php');

    $subcategory_id = $_GET['id'];
    $query = "SELECT name
      FROM cls_categories
      WHERE id = '$subcategory_id'";
    $subcategory = mysqli_fetch_assoc(mysqli_query($dbc, $query));
  ?>

  <main>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
      <input name="id" type="hidden" value="<?= $subcategory_id; ?>">
      <input
        class="subcategory-name"
        name="subcategory"
        placeholder="Subcategory name"
        type="text"
        value="<?= $subcategory['name']; ?>"
      >

      <button>Update</button>
    </form>
  </main>

  <?php
    if (is_post_request()) {
      $subcategory_id = $_POST['id'];
      $subcategory_name = $_POST['subcategory'];
      $query = "UPDATE cls_categories
        SET name = '$subcategory_name'
        WHERE id = '$subcategory_id'";
      mysqli_query($dbc, $query);

      redirect_to('index.php?page=1');
    }
  ?>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
