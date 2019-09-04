<?php
    require_once('../private/initialize.php');
    include(SHARED_PATH . '/head.php');

    if (!isset($_COOKIE['email'])) {
      redirect_to('login.php');
    }
?>

<div class="admin-panel">
  <?php
    include(SHARED_PATH . '/header.php');
    include(SHARED_PATH . '/sidebar.php');

    require_once('../dbc.php');
    require_once('./constants.php');
  ?>

  <main>
    <form action="remove-items.php" method="POST">
      <ul class="items-list-header">
        <li class="check-all"><input id="check-all" type="checkbox"></li>
        <li class="item-id">ID</li>
        <li class="item-name">Item name</li>
        <li class="item-subcategory">Item subcategory</li>
        <li class="item-posted-date">Posted date</li>
        <li class="item-actions">Actions</li>
      </ul>

      <?php
        // when admin panel is accessed, url looks like www.example.com/admin/,
        // without page value, so by default page=1
        $page = isset($_GET['page']) ? db_escape($dbc, $_GET['page']) : 1;
        $offset = ($page - 1) * ITEMS_PER_PAGE;

        $query = "SELECT ads.*, sub.name AS subcategory
          FROM cls_ads AS ads
          INNER JOIN cls_categories AS sub ON ads.subcategory_id = sub.id
          ORDER BY published DESC
          LIMIT " . ITEMS_PER_PAGE . " OFFSET $offset";
        $data = mysqli_query($dbc, $query) or die(mysqli_error($dbc));
      ?>

      <ul class="items-list">
      <?php while ($row = mysqli_fetch_assoc($data)) { ?>
        <li class="<?= $row['enabled'] == 1 ? 'enabled' : 'disabled' ?>">
          <span class="check-item">
            <input name="items[]" type="checkbox" value="<?= $row['id'] ?>">
          </span>

          <span class="item-id"><?= $row['id'] ?></span>

          <a href="<?= FRONT_SIDE . '/item/' . $row['url'] ?>" class="item-title" target="_blank">
            <?= $row['title'] ?>
          </a>

          <a href="#" class="subcategory"><?= $row['subcategory'] ?></a>

          <span class="item-posted-date"><?= date_format(date_create($row['published']), 'd F, Y') ?></span>

          <div class="action-icons">
            <a href="<?= FRONT_SIDE . '/item/' . $row['url'] ?>" class="item-url" target="_blank">
              <i class="icon ion-md-link"></i>
            </a>

            <a href="edit-item.php?id=<?= $row['id'] ?>" class="edit-icon">
              <i class="icon ion-md-create"></i>
            </a>

            <a href="change-item-status.php?id=<?= $row['id'] ?>" class="enable-icon">
              <i class="icon ion-md-trending-up"></i>
            </a>

            <a href="renew-item.php?id=<?= $row['id'] ?>" class="renew-icon">
              <i class="icon ion-md-refresh"></i>
            </a>

            <a href="#" class="disable-icon">
              <i class="icon ion-md-eye-off"></i>
            </a>

            <a href="#" class="spam-icon">
              <i class="icon ion-md-flame"></i>
            </a>

            <a
              class="remove-icon"
              href="remove-item.php?id=<?= $row['id'] ?>"
            >
              <i class="icon ion-md-trash"></i>
            </a>
          </div>
        </li>
      <?php } ?>
      </ul>

      <button name="submit" onclick="return confirm('Are you sure?')">Delete selected items</button>
    </form>

    <?php
      $query = "SELECT COUNT(*) AS total FROM cls_ads";
      $res = mysqli_query($dbc, $query);
      $total_items = mysqli_fetch_row($res);
      $total_pages = ceil($total_items[0] / ITEMS_PER_PAGE);

      mysqli_close($dbc);

      $page_name = 'index';
      $pages = [];
      for ($i = 0; $i < $total_pages; $i++) {
        $pages[] = $i + 1;
      }
  
      include(SHARED_PATH . '/pagination.php');
    ?>
  </main>
  
  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>

