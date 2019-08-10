<?php
  include_once './header.php';

  require_once('../dbc.php');

  $item_id = db_escape($dbc, $_GET['id']);
  $query = "SELECT *
    FROM cls_ads
    WHERE id = '$item_id'
    LIMIT 1";
  $res = mysqli_query($dbc, $query);

  if (mysqli_connect_errno($dbc)) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  while ($row = mysqli_fetch_assoc($res)) {
    $enable_ad = "UPDATE cls_ads
      SET published = NOW()
      WHERE id = $item_id
      LIMIT 1";
    $data = mysqli_query($dbc, $enable_ad);

    echo "<h3>Your ad {$row['title']} {$item_id} was renewed!</h3";
  }

  mysqli_close($dbc);

  include_once './footer.php';
?>
