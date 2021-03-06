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
    <ul class="users-list-header">
      <li class="check-all"><input id="check-all" type="checkbox"></li>
      <li class="user-id">ID</li>
      <li class="user-email">Email</li>
      <li class="registration-date">Date</li>
      <li>Actions</li>
    </ul>

    <?php
      $page = isset($_GET['page']) ? db_escape($dbc, $_GET['page']) : 1;
      $offset = ($page - 1) * ITEMS_PER_PAGE;

      $query = "SELECT *
        FROM cls_users
        ORDER BY id DESC
        LIMIT " . ITEMS_PER_PAGE . " OFFSET $offset";
      $users = mysqli_query($dbc, $query);
    ?>

    <form action="remove-users.php" method="POST">
      <ul class="users-list">
        <?php while ($row = mysqli_fetch_assoc($users)) { ?>
          <li>
            <span class="check-user">
              <input type="checkbox" name="items[]" value="<?= $row['id'] ?>">
            </span>
            <span class="user-id"><?= $row['id'] ?></span>
            <span class="user-email"><?= $row['email'] ?></span>
            <span class="registration-date">08 July, 2019</span>
            <div class="action-icons">
              <a href="#" class="user-profile">
                <i class="icon ion-md-person"></i>
              </a>
              <a href="#" class="edit-user">
                <i class="icon ion-md-create"></i>
              </a>
              <a href="#" class="block-user">
                <i class="icon ion-md-alert"></i>
              </a>
              <a
                class="remove-user"
                href="remove-user.php?id=<?= $row['id'] ?>"
              >
                <i class="icon ion-md-trash"></i>
              </a>
            </div>
          </li>
        <?php } ?>
      </ul>

      <button onclick="return confirm('Are you sure?')">Delete selected users</button>
    </form>

    <?php
      $query = "SELECT COUNT(*) AS total FROM cls_users";
      $res = mysqli_query($dbc, $query);
      $total_users = mysqli_fetch_row($res);
      $total_pages = ceil($total_users[0] / ITEMS_PER_PAGE);

      mysqli_close($dbc);

      $page_name = 'users';
      $pages = [];
      for ($i = 0; $i < $total_pages; $i++) {
        $pages[] = $i + 1;
      }

      include(SHARED_PATH .'/pagination.php');
    ?>
  </main>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
