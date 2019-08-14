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
    <?php
      $query = "SELECT *
      FROM cls_categories
      WHERE parent_id IS NULL
      ORDER BY id DESC";

      $parent_categories = mysqli_query($dbc, $query);
    ?>

    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" class="add-subcategory" method="POST">
      <input class="subcategory-name" name="name" placeholder="Subcategory name" type="text">

      <select class="parent-category" name="parent-id">
        <option>No parent</option>
        <?php
          while ($row = mysqli_fetch_assoc($parent_categories)) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
          }
        ?>
      </select>

      <button>Add subcategory</button>
    </form>

    <?php
      if (is_post_request()) {
        $subcategory_name = db_escape($dbc, $_POST['name']);
        $parent_id = is_numeric($_POST['parent-id']) ? db_escape($dbc, $_POST['parent-id']) : "NULL";

        $query = "INSERT INTO cls_categories (name, parent_id)
          VALUES ('$subcategory_name', $parent_id)";
        mysqli_query($dbc, $query) or die(mysqli_error());
        mysqli_close($dbc);

        redirect_to('index.php?page=1');
      }
    ?>

    <ul class="subcategories-list-header">
      <li class="check-all"><input id="check-all" type="checkbox"></li>
      <li class="subcategory-id">ID</li>
      <li class="subcategory-name">Subcategory</li>
      <li class="subcategory-parent">Category</li>
      <li>Actions</li>
    </ul>

    <?php
      // Use this syntax $page = $_GET['page'] ?? 1;
      $page = isset($_GET['page']) ? db_escape($dbc, $_GET['page']) : 1;
      $offset = ($page - 1) * ITEMS_PER_PAGE;

      $query = "SELECT sub.*, cat.name AS 'category'
        FROM cls_categories AS sub LEFT JOIN cls_categories AS cat ON sub.parent_id = cat.id
        WHERE sub.parent_id IS NOT NULL
        LIMIT " . ITEMS_PER_PAGE . " OFFSET $offset";
      $categories = mysqli_query($dbc, $query);

      $subcategories = [];
      while ($i = mysqli_fetch_assoc($categories)) {
        $subcategories[] = $i;
      }
    ?>

    <form action="remove-subcategories.php" method="POST">
      <ul class="subcategories-list">
        <?php for ($i = 0; $i < count($subcategories); $i++) { ?>
          <li>
            <span class="check-subcategory">
              <input name="items[]" type="checkbox" value="<?= $subcategories[$i]['id'] ?>">
            </span>
            <span class="subcategory-id"><?= $subcategories[$i]['id'] ?></span>
            <span class="subcategory-name"><?= $subcategories[$i]['name'] ?></span>
            <span class="subcategory-parent"><?= $subcategories[$i]['category'] ?></span>
            <div class="action-icons">
              <a href="edit-subcategory.php?id=<?= $subcategories[$i]['id'] ?>" class="edit-subcategory">
                <i class='icon ion-md-create'></i>
              </a>
              <a
                href="remove-subcategory.php?id=<?= $subcategories[$i]['id'] ?>&parent_id=<?= $subcategories[$i]['parent_id'] ?>"
                class="remove-subcategory"
              >
                <i class="icon ion-md-trash"></i>
              </a>
            </div>
          </li>
        <?php } ?>
      </ul>

      <button onclick="return confirm('Are you sure?')">Delete selected subcategories</button>
    </form>

    <?php
      $query = "SELECT COUNT(*) AS total
        FROM cls_categories
        WHERE parent_id IS NOT NULL";
      $res = mysqli_query($dbc, $query);
      $total_items = mysqli_fetch_row($res);
      $total_pages = ceil($total_items[0] / ITEMS_PER_PAGE);

      mysqli_close($dbc);

      $page_name = 'subcategories';
      $pages = [];
      for ($i = 0; $i < $total_pages; $i++) {
        $pages[] = $i + 1;
      }

      include(SHARED_PATH . '/pagination.php');
    ?>
  </main>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
