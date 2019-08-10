<?php include_once './head.php'; ?>

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
    $enable_ad = "UPDATE cls_ads
      SET enabled = 1
      WHERE id = '$item_id'
      LIMIT 1";
    mysqli_query($dbc, $enable_ad);

    echo "<h3>Ad {$row['title']} was enabled!</h3";
  }

  mysqli_close($dbc);
?>
  
<div>
  <a href="/classified/backend/admin"><<< Back</a>
</div>

<?php
  include_once './footer.php';
?>
