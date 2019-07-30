<?php include_once './head.php'; ?>

<div class="admin-panel">
  <?php
    include_once './header.php';
    require_once('../dbc.php');

    if (isset($_POST['submit']) && isset($_POST)) {
      $items = implode(',', $_POST['items']);

      $remove_currencies_query = "DELETE
        FROM cls_regions
        WHERE id IN ($items)";
      mysqli_query($dbc, $remove_currencies_query);
    }
  ?>

  <div>
    <a href="regions.php?page=1"><<< Back</a>
  </div>

  <?php include_once './footer.php'; ?>
</div>
