<?php
  require_once('../private/initialize.php');
  include(SHARED_PATH . '/head.php');

  if (!isset($_COOKIE['email'])) {
    redirect_to('login.php');
  }
?>

<div class="admin-panel">
  <?php
    include(SHARED_PATH . '/header.php');
    include(SHARED_PATH . '/sidebar.php');

    require_once('../dbc.php');
    require_once('./constants.php');

    $item_id = $_GET['id'];
    // item query
    $query = "SELECT *
      FROM cls_ads
      WHERE id = '$item_id'";
    $item = mysqli_fetch_assoc(mysqli_query($dbc, $query));

    // subcategories query
    $query = "SELECT *
      FROM cls_categories
      WHERE parent_id IS NOT NULL";
    $subcategories = mysqli_query($dbc, $query);

    // regions query
    $query = "SELECT *
      FROM cls_regions";
    $regions = mysqli_query($dbc, $query);

    // currencies query
    $query = "SELECT *
      FROM cls_currencies";
    $currencies = mysqli_query($dbc, $query);
  ?>

  <main>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" class="edit-item" method="POST">
      <input name="id" type="hidden" value="<?= $item_id ?>">

      <select class="subcategories" name="subcategory">
        <?php
          while ($row = mysqli_fetch_assoc($subcategories)) {
            echo '<option value="' . $row['id'] . '" ';
            echo ($row['id'] == $item['subcategory_id']) ? 'selected' : '';
            echo '>' . $row['name'] . '</option>';
          }
        ?>
      </select>

      <select class="regions" name="region">
        <?php
          while ($row = mysqli_fetch_assoc($regions)) {
            echo '<option value="' . $row['id'] . '" ';
            echo ($row['id'] == $item['region_id']) ? 'selected' : '';
            echo '>' . $row['name'] . '</option>';
          }
        ?>
      </select>

      <input class="title" name="title" type="text" value="<?= $item['title'] ?>">

      <textarea class="description" name="description"><?= $item['description'] ?></textarea>

      <div class="images-container">
        <?php
          // images query
          $query = "SELECT *
            FROM cls_images
            WHERE ad_id = '$item_id'";
          $images = mysqli_query($dbc, $query);

          while ($row = mysqli_fetch_assoc($images)) {
            echo '<div class="image-block" id="' . $row['image'] . '">';
              echo '<img class="remove-button" onclick="removeImage(\'' . $row['image'] . '\', ' . $_GET['id'] . ')" src="' . WWW_ROOT . '/img/remove.png">';
              echo '<img class="image" src="' . WWW_ROOT . '/uploads/thumb_' . $row['image'] . '">';
            echo '</div>';
          }
        ?>
      </div> <!-- .images-container -->

      <input class="phone" name="phone" type="text" value="<?= $item['phone'] ?>">

      <input class="visitor" name="visitor" type="text" value="<?= $item['visitor_name'] ?>">

      <input class="price" id="price" name="price" type="text" value="<?= $item['price'] ?>">

      <select class="currencies" id="currencies" name="currency">
        <?php
          while ($row = mysqli_fetch_assoc($currencies)) {
            echo '<option value="' . $row['id'] . '" ';
            echo ($row['id'] == $item['currency_id']) ? 'selected' : '';
            echo '>' . $row['name'] . '</option>';
          }
        ?>
      </select>

      <button class="update">Update</button>
    </form>

    <?php
      if (is_post_request()) {
        $query = "UPDATE cls_ads
          SET
            subcategory_id = " . db_escape($dbc, $_POST['subcategory']) . ",
            region_id = " . db_escape($dbc, $_POST['region']) . ",
            title = '" . db_escape($dbc, $_POST['title']) . "',
            description = '" . db_escape($dbc, $_POST['description']) . "',
            phone = '" . db_escape($dbc, $_POST['phone']) . "',
            visitor_name = '" . db_escape($dbc, $_POST['visitor']) . "',
            price = " . db_escape($dbc, $_POST['price']) . ",
            currency_id = " . db_escape($dbc, $_POST['currency']) . "
          WHERE id = " . db_escape($dbc, $_POST['id']) . "
          LIMIT 1";
        $result = mysqli_query($dbc, $query) or die(mysqli_error($dbc));

        if ($result) {
          redirect_to('index.php?page=1');
        }
      }
    ?>
  </main>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>

<script src="js/remove-image.js"></script>
