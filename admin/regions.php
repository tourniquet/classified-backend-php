<div class="admin-panel">
  <?php
    include './head.php';
    include './header.php';
  ?>

  <main>
    <?php
      require_once('../dbc.php');

      $page = !empty($_GET['page']) ? $_GET['page'] : 1;
      $offset = ($page - 1) * 5;

      echo '<form class="add-region">
          <input class="region-name" placeholder="Region name" type="text">
          <button>Add region</button>
        </form>';

      $query = "SELECT *
      FROM cls_regions
      ORDER BY id DESC
      LIMIT 5 OFFSET $offset";
      $regions = mysqli_query($dbc, $query);

      echo '<ul class="regions-list-header">
        <li class="check-all">
          <input id="check-all" type="checkbox">
        </li>
        <li class="region-id">ID</li>
        <li class="region-name">Region</li>
        <li>Actions</li>
      </ul>';

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
            <a href="remove.php?id=' . $row['id'] . '" class="remove-region">
              <i class="icon ion-md-trash"></i>
            </a>
          </div>
        </li>';
      }
      echo '</ul>';
    ?>
  </main>
</div>
