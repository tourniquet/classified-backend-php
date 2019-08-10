<?php include_once './head.php'; ?>

<div class="admin-panel">
  <?php
    include_once './header.php';
    require_once('../dbc.php');

    $item_id = db_escape($dbc, $_GET['id']);
    $query = "SELECT * FROM cls_ads WHERE id = '$item_id'";
    $res = mysqli_query($dbc, $query);

    if (mysqli_connect_errno($dbc)) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }

    while ($row = mysqli_fetch_assoc($res)) {
      $disable_ad = "UPDATE cls_ads
        SET enabled = 0
        WHERE id = '$item_id'
        LIMIT 1";
      $result = mysqli_query($dbc, $disable_ad);

      if ($result) {
        echo "<h3>Ad {$row['title']} was disabled!</h3";
        mysqli_close($dbc);
      } else {
        echo mysqli_error($dbc);
        mysqli_close($dbc);
        exit;
      }
    }
  ?>

  <div>
    <a href="/classified/backend/admin"><<< Back</a>
  </div>

  <?php  include_once './footer.php'; ?>
</div>
