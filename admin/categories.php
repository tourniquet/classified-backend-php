<div class="admin-panel">
  <?php
    include './head.php';
    include './header.php';
    require_once('./constants.php');
  ?>

  <main>
    <?php
      require_once('../dbc.php');

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

    <?php
      $page = !empty($_GET['page']) ? $_GET['page'] : 1;
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

      $query = "SELECT COUNT(*) AS total FROM cls_categories WHERE parent_id IS NOT NULL";
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
        echo '<li class="prev-button"><a href="categories.php?page=' . ($page - 1) . '">Prev</a></li>';
      }

      for ($i = 0; $i < count($pages); $i++) {
        if ($page == $pages[$i]) {
          echo '<li><a class="page active" href="categories.php?page=' . $pages[$i] . '">' . $pages[$i] . '</a></li>';
        } else {
          echo '<li><a class="page" href="categories.php?page=' . $pages[$i] . '">' . $pages[$i] . '</a></li>';
        }
      }

      if ($page >= count($pages)) {
        echo '<li class="next-button disabled">Next</li>';
      } else {
        echo '<li class="next-button"><a href="categories.php?page=' . ($page + 1) . '">Next</a></li>';
      }
      echo '</ul>';
    ?>
  </main>
</div>
