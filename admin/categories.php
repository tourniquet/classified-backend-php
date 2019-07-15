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

      $query = "SELECT *
      FROM cls_categories
      WHERE parent_id IS NULL
      ORDER BY id DESC";
      $parent_categories = mysqli_query($dbc, $query);

      echo '<form class="add-category">
        <input class="category-name" type="text" placeholder="Category name">

        <select class="parent-category">
          <option>No parent</option>';
          while ($row = mysqli_fetch_array($parent_categories)) {
            echo '<option>' . $row['title'] . '</option>';
          }
        echo '</select>
        <button>Add category</button>
      </form>';

      $query = "SELECT *
        FROM cls_categories
        ORDER BY id DESC
        LIMIT 5 OFFSET $offset";
      $categories = mysqli_query($dbc, $query);
      
      echo '<ul class="categories-list-header">
          <li class="check-all"><input id="check-all" type="checkbox"></li>
          <li class="category-id">ID</li>
          <li class="category-name">Category</li>
          <li>Actions</li>
        </ul>';

      echo '<ul class="categories-list">';
      while ($row = mysqli_fetch_array($categories)) {
        echo '<li>
          <span class="check-category"><input type="checkbox"></span>
          <span class="category-id">' . $row['id'] . '</span>
          <span class="category-title">' . $row['title'] . '</span>
          <div class="action-icons">
            <a href="#" class="edit-category"><i class="icon ion-md-create"></i></a>
            <a href="remove.php?id=' . $row['id'] . '" class="remove-category">
              <i class="icon ion-md-trash"></i>
            </a>
          </div>
        </li>';
      }
      echo '</ul>';
    ?>
  </main>
</div>
