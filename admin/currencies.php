<?php
  include './head.php';
?>

<div class="admin-panel">
  <?php
    include './header.php';
    include './sidebar.php';

    require_once('../dbc.php');
    require_once('./constants.php');
  ?>

  <main>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" class="add-currency" method="POST">
      <input class="currency-name" name="currency" placeholder="Currency name" required type="text">
      <button name="submit">Add currency</button>
    </form>

    <?php
      if (isset($_POST['submit'])) {
        $currency = $_POST['currency'];

        $query = "INSERT INTO cls_currencies (title) VALUES ('$currency')";
        mysqli_query($dbc, $query) or die('Error adding currency.');

        header('Location: ' . $_SERVER['PHP_SELF']);
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
      $page = !empty($_GET['page']) ? $_GET['page'] : 1;
      $offset = ($page - 1) * ITEMS_PER_PAGE;

      $query = "SELECT *
        FROM cls_currencies
        ORDER BY id DESC
        LIMIT " . ITEMS_PER_PAGE . " OFFSET $offset";
      $currencies = mysqli_query($dbc, $query);

      echo '<ul class="currencies-list">';
      while ($row = mysqli_fetch_array($currencies)) {
        echo '<li>
          <span class="check-currency">
            <input type="checkbox">
          </span>
          <span class="currency-id">' . $row['id'] . '</span>
          <span class="currency-name">' . $row['title'] . '</span>
          <div class="action-icons">
            <a href="#" class="edit-currency"><i class="icon ion-md-create"></i></a>
            <a href="remove-currency.php?id=' . $row['id'] . '" class="remove-currency" onclick="return confirm(\'Are you sure?\')">
              <i class="icon ion-md-trash"></i>
            </a>
          </div>
        </li>';
      }
      echo '</ul>';

      $query = "SELECT COUNT(*) AS total FROM cls_currencies";
      $res = mysqli_query($dbc, $query);
      $total_items = mysqli_fetch_row($res);
      $total_pages = ceil($total_items[0] / ITEMS_PER_PAGE);

      mysqli_close($dbc);

      $pages = [];
      for ($i = 0; $i < $total_pages; $i++) {
        $pages[] = $i + 1;
      }

      echo '<ul class="pagination">';
      if ($page == 1) {
        echo '<li class="prev-button disabled">Prev</li>';
      } else {
        echo '<li class="prev-button"><a href="currencies.php?page=' . ($page - 1) . '">Prev</a></li>';
      }

      for ($i = 0; $i < count($pages); $i++) {
        if ($page == $pages[$i]) {
          echo '<li><a class="page active" href="currencies.php?page=' . $pages[$i] . '">' . $pages[$i] . '</a></li>';
        } else {
          echo '<li><a class="page" href="currencies.php?page=' . $pages[$i] . '">' . $pages[$i] . '</a></li>';
        }
      }

      if ($page >= count($pages)) {
        echo '<li class="next-button disabled">Next</li>';
      } else {
        echo '<li class="next-button"><a href="currencies.php?page=' . ($page + 1) . '">Next</a></li>';
      }
      echo '</ul>';
    ?>
  </main>

  <?php include './footer.php'; ?>
</div>
