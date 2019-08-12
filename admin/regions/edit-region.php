<?php
  require_once('../../private/initialize.php');
  include(SHARED_PATH . '/head.php');
?>

<div class="admin-panel">
  <?php
    include(SHARED_PATH . '/header.php');
    include(SHARED_PATH . '/sidebar.php');

    require_once('../../dbc.php');

    $region_id = $_GET['id'];
    $query = "SELECT name
      FROM cls_regions
      WHERE id = '$region_id'";
    $region = mysqli_fetch_assoc(mysqli_query($dbc, $query));
  ?>

  <main>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
      <input name="id" type="hidden" value="<?= $region_id; ?>">
      <input
        class="region-name"
        name="region"
        placeholder="Region name"
        required
        type="text"
        value="<?= $region['name']; ?>"
      >

      <button>Update</button>
    </form>
  </main>

  <?php
    if (is_post_request()) {
      $region_id = $_POST['id'];
      $region_name = $_POST['region'];
      $query = "UPDATE cls_regions
        SET name = '$region_name'
        WHERE id = '$region_id'";
      mysqli_query($dbc, $query);

      redirect_to('index.php?page=1');
    }
  ?>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
