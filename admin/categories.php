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
    <form action="add-category.php" class="add-category" method="POST">
      <input class="category-name" name="title" placeholder="Category name" type="text"> <!-- TODO: replace title with name -->

      <button>Add category</button>
    </form>

    <ul class="categories-list-header">
      <li class="check-all"><input id="check-all" type="checkbox"></li>
      <li class="category-id">ID</li>
      <li class="category-name">Category</li>
      <li>Actions</li>
    </ul>

    <?php
      // TODO: Use this syntax $page = $_GET['page'] ?? 1;
      $page = !empty($_GET['page']) ? $_GET['page'] : 1;
      $offset = ($page - 1) * ITEMS_PER_PAGE;

      $query = "SELECT *
        FROM cls_categories
        WHERE parent_id IS NULL
        ORDER BY id DESC
        LIMIT " . ITEMS_PER_PAGE . " OFFSET $offset";
      $categories = mysqli_query($dbc, $query);

      echo '<ul class="categories-list">';
        while ($row = mysqli_fetch_array($categories)) {
        echo '<li>
          <span class="check-category"><input type="checkbox"></span>
          <span class="category-id">' . $row['id'] . '</span>
          <span class="category-name">' . $row['title'] . '</span>
          <div class="action-icons">
            <a href="#" class="edit-category"><i class="icon ion-md-create"></i></a>
            <a href="remove-category.php?id=' . $row['id'] . '" class="remove-category" onclick="return confirm(\'Are you sure?\')">
              <i class="icon ion-md-trash"></i>
            </a>
          </div>
        </li>';
      }
      echo '</ul>';

      $query = "SELECT COUNT(*) AS total
        FROM cls_categories WHERE parent_id IS NULL";
      $res = mysqli_query($dbc, $query);
      $total_items = mysqli_fetch_row($res);
      $total_pages = ceil($total_items[0] / ITEMS_PER_PAGE);

      mysqli_close($dbc);

      $page_name = 'categories';
      $pages = [];
      for ($i = 0; $i < $total_pages; $i++) {
        $pages[] = $i + 1;
      }

      include_once('./pagination.php');
    ?>
  </main>

  <?php include './footer.php'; ?>
</div>
