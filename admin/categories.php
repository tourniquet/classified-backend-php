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
      $offset = ($page - 1) * ITEMS_PER_PAGE;

      $query = "SELECT sub.id, sub.title, cat.title AS 'category'
        FROM cls_categories AS sub LEFT JOIN cls_categories AS cat ON sub.parent_id = cat.id
        WHERE sub.parent_id IS NOT NULL
        LIMIT " . ITEMS_PER_PAGE . " OFFSET $offset";
      $categories = mysqli_query($dbc, $query);
      
      echo '<ul class="categories-list-header">
          <li class="check-all"><input id="check-all" type="checkbox"></li>
          <li class="category-id">ID</li>
          <li class="category-name">Category</li>
          <li>Actions</li>
        </ul>';


      $subcategories = [];
      while ($i = mysqli_fetch_assoc($categories)) {
        $subcategories[] = $i;
      }

      echo '<ul class="subcategories-list">';
        for ($i = 0; $i < count($subcategories); $i++) {
        echo '<li>
          <span class="check-category"><input type="checkbox"></span>
          <span class="subcategory-id">' . $subcategories[$i]['id'] . '</span>
          <span class="subcategory-name">' . $subcategories[$i]['title'] . '</span>
          <span class="subcategory-parent">' . $subcategories[$i]['category'] . '</span>
          <div class="action-icons">
            <a href="#" class="edit-category"><i class="icon ion-md-create"></i></a>
            <a href="remove.php?id=' . $subcategories[$i]['id'] . '" class="remove-category">
              <i class="icon ion-md-trash"></i>
            </a>
          </div>
        </li>';
      }
      echo '</ul>';
    ?>
  </main>
</div>
