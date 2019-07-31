<?php
  include_once './head.php';
?>

<div class="admin-panel">
  <?php
    include_once './header.php';
    include_once './sidebar.php';

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
    ?>

    <form action="remove-categories.php" method="POST">
      <ul class="categories-list">
        <?php
          while ($row = mysqli_fetch_array($categories)) {
          echo "<li>
            <span class='check-category'>
              <input name='items[]' type='checkbox' value='{$row['id']}'>
            </span>
            <span class='category-id'>{$row['id']}</span>
            <span class='category-name'>{$row['title']}</span>
            <div class='action-icons'>
              <a href='#' class='edit-category'>
                <i class='icon ion-md-create'></i>
              </a>
              <a
                class='remove-category'
                href='remove-category.php?id={$row['id']}'
                onclick='return confirm(\"Are you sure?\")'
              >
                <i class='icon ion-md-trash'></i>
              </a>
            </div>
          </li>";
        }
      ?>
      </ul>

      <button name="submit" onclick="return confirm('Are you sure?')">Delete selected categories</button>
    </form>

    <?php
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

      include_once './pagination.php';
    ?>
  </main>

  <?php include_once './footer.php'; ?>
</div>
