<?php
  include './head.php';
?>

<div class="admin-panel">
  <?php
    include './header.php';

    require_once('../dbc.php');
    require_once('./constants.php');
  ?>

  <main>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"class="add-region" method="POST">
      <input class="region-name" name="region" placeholder="Region name" required type="text">
      <button name="submit">Add region</button>
    </form>

    <?php
      if (isset($_POST['submit'])) {
        $region = $_POST['region'];

        $query = "INSERT INTO cls_regions (title) VALUES ('$region')";
        mysqli_query($dbc, $query) or die('Error adding region.');

        header('Location: ' . $_SERVER['PHP_SELF']);
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
      $page = !empty($_GET['page']) ? $_GET['page'] : 1;
      $offset = ($page - 1) * ITEMS_PER_PAGE;

      $query = "SELECT *
        FROM cls_regions
        ORDER BY id DESC
        LIMIT " . ITEMS_PER_PAGE . " OFFSET $offset";
      $regions = mysqli_query($dbc, $query);

      echo '<ul class="regions-list">';
      while ($row = mysqli_fetch_array($regions)) {
        echo '<li>
          <span class="check-region">
            <input type="checkbox">
          </span>
          <span class="region-id">' . $row['id'] . '</span>
          <span class="region-title">' . $row['title'] . '</span>
          <div class="action-icons">
            <a href="#" class="edit-region"><i class="icon ion-md-create"></i></a>
            <a href="remove-region.php?id=' . $row['id'] . '" class="remove-region" onclick="confirm(\'Are you sure?\')">
              <i class="icon ion-md-trash"></i>
            </a>
          </div>
        </li>';
      }
      echo '</ul>';

      $query = "SELECT COUNT(*) AS total FROM cls_regions";
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
        echo '<li class="prev-button"><a href="regions.php?page=' . ($page - 1) . '">Prev</a></li>';
      }

      for ($i = 0; $i < count($pages); $i++) {
        if ($page == $pages[$i]) {
          echo '<li><a class="page active" href="regions.php?page=' . $pages[$i] . '">' . $pages[$i] . '</a></li>';
        } else {
          echo '<li><a class="page" href="regions.php?page=' . $pages[$i] . '">' . $pages[$i] . '</a></li>';
        }
      }

      if ($page >= count($pages)) {
        echo '<li class="next-button disabled">Next</li>';
      } else {
        echo '<li class="next-button"><a href="regions.php?page=' . ($page + 1) . '">Next</a></li>';
      }
      echo '</ul>';
    ?>
  </main>

  <?php include './footer.php'; ?>
</div>
