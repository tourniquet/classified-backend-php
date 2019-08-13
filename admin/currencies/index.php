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
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" class="add-currency" method="POST">
      <input class="currency-name" name="currency" placeholder="Currency name" required type="text">
      <button>Add currency</button>
    </form>

    <?php
      if (is_post_request()) {
        $currency = $_POST['currency'];

        $query = "INSERT INTO cls_currencies (name) VALUES ('$currency')";
        mysqli_query($dbc, $query) or die(mysqli_error());

        redirect_to($_SERVER['PHP_SELF']);
      }
    ?>

    <ul class="currencies-list-header">
      <li class="check-all">
        <input id="check-all" type="checkbox">
      </li>
      <li class="currency-id">ID</li>
      <li class="currency-name">Currency</li>
      <li>Actions</li>
    </ul>

    <?php
      $page = isset($_GET['page']) ? db_escape($dbc, $_GET['page']) : 1;
      $offset = ($page - 1) * ITEMS_PER_PAGE;

      $query = "SELECT *
        FROM cls_currencies
        ORDER BY id DESC
        LIMIT " . ITEMS_PER_PAGE . " OFFSET $offset";
      $currencies = mysqli_query($dbc, $query);
    ?>

    <form action="remove-currencies.php" method="POST">
      <ul class="currencies-list">
        <?php while ($row = mysqli_fetch_assoc($currencies)) { ?>
          <li>
            <span class="check-currency">
              <input name="items[]" type="checkbox" value="<?= $row['id'] ?>">
            </span>
            <span class="currency-id"><?= $row['id'] ?></span>
            <span class="currency-name"><?= $row['name'] ?></span>
            <div class="action-icons">
              <a href="edit-currency.php?id=<?= $row['id'] ?>" class="edit-currency">
                <i class="icon ion-md-create"></i>
              </a>
              <a
                class="remove-currency"
                href="remove-currency.php?id=<?= $row['id'] ?>"
              >
                <i class="icon ion-md-trash"></i>
              </a>
            </div>
          </li>
        <?php } ?>
      </ul>

      <button name="submit" onclick="return confirm('Are you sure?')">Delete selected currencies</button>
    </form>

    <?php
      $query = "SELECT COUNT(*) AS total FROM cls_currencies";
      $res = mysqli_query($dbc, $query);
      $total_items = mysqli_fetch_row($res);
      $total_pages = ceil($total_items[0] / ITEMS_PER_PAGE);

      mysqli_close($dbc);

      $page_name = 'currencies';
      $pages = [];
      for ($i = 0; $i < $total_pages; $i++) {
        $pages[] = $i + 1;
      }

      include(SHARED_PATH . '/pagination.php');
    ?>
  </main>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
