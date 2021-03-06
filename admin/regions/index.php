<?php
  require_once('../../private/initialize.php');
  include(SHARED_PATH . '/head.php');

  if (!isset($_COOKIE['email'])) {
    redirect_to(WWW_ROOT . 'admin/login.php');
  }
?>

<div class="admin-panel">
  <?php
    include(SHARED_PATH . '/header.php');
    include(SHARED_PATH . '/sidebar.php');

    require_once('../../dbc.php');
    require_once('../constants.php');
  ?>

  <main>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" class="add-region" method="POST">
      <input class="region-name" name="region" placeholder="Region name" required type="text">
      <button name="submit">Add region</button>
    </form>

    <?php
      if (is_post_request()) {
        $region = $_POST['region'];

        $query = "INSERT INTO cls_regions (name) VALUES ('$region')";
        mysqli_query($dbc, $query) or die(mysqli_error($dbc));

        redirect_to($_SERVER['PHP_SELF']);
      }
    ?>

    <ul class="regions-list-header">
      <li class="check-all">
        <input id="check-all" type="checkbox">
      </li>
      <li class="region-id">ID</li>
      <li class="region-name">Region</li>
      <li>Actions</li>
    </ul>

    <?php
      $page = isset($_GET['page']) ? db_escape($dbc, $_GET['page']) : 1;
      $offset = ($page - 1) * ITEMS_PER_PAGE;

      $query = "SELECT *
        FROM cls_regions
        ORDER BY id DESC
        LIMIT " . ITEMS_PER_PAGE . " OFFSET $offset";
      $regions = mysqli_query($dbc, $query);
    ?>

    <form action="remove-regions.php" method="POST">
      <ul class="regions-list">
        <?php while ($row = mysqli_fetch_assoc($regions)) { ?>
          <li>
            <span class="check-region">
              <input name="items[]" type="checkbox" value="<?= $row['id'] ?>">
            </span>
            <span class="region-id"><?= $row['id'] ?></span>
            <span class="region-title"><?= $row['name'] ?></span>
            <div class="action-icons">
              <a href="edit-region.php?id=<?= $row['id'] ?>" class="edit-region">
                <i class="icon ion-md-create"></i>
              </a>
              <a
                class="remove-region"
                href="remove-region.php?id=<?= $row['id'] ?>"
              >
                <i class="icon ion-md-trash"></i>
              </a>
            </div>
          </li>
        <?php } ?>
      </ul>

      <button onclick="return confirm('Are you sure?')">Delete selected regions</button>
    </form>

    <?php
      $query = "SELECT COUNT(*) AS total FROM cls_regions";
      $res = mysqli_query($dbc, $query);
      $total_items = mysqli_fetch_row($res);
      $total_pages = ceil($total_items[0] / ITEMS_PER_PAGE);

      mysqli_close($dbc);

      $page_name = 'regions';
      $pages = [];
      for ($i = 0; $i < $total_pages; $i++) {
        $pages[] = $i + 1;
      }

      include(SHARED_PATH .'/pagination.php');
    ?>
  </main>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
