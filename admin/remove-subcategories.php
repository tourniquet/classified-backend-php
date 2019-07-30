<?php
  include_once './head.php'
?>

<div class="admin-panel">
  <?php
    include_once './header.php';
    require_once('../dbc.php');

    if (isset($_POST['submit']) && isset($_POST)) {
      $items = implode(',', $_POST['items']);

      $remove_subcategories_query = "DELETE
        FROM cls_categories
        WHERE id IN ($items)";
      mysqli_query($dbc, $remove_subcategories_query);
      mysqli_close($dbc);
    }
  ?>

  <div>
    <a href="subcategories.php?page=1"><<< Back</a>
  </div>

  <?php
    include_once './footer.php';
  ?>
</div>
