<?php
  include './header.php';

  require_once('../dbc.php');

  $ad_id = $_GET['id'];
  $query = "SELECT * FROM cls_ads WHERE id = $ad_id";
  $res = mysqli_query($dbc, $query);

  if (mysqli_connect_errno($dbc)) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  while ($row = mysqli_fetch_array($res)) {
    $enable_ad = 'UPDATE cls_ads SET enabled = 1 WHERE id = ' . $ad_id;
    mysqli_query($dbc, $enable_ad);

    echo '<h3>Your ad ' . $row['title'] . ' ' . $ad_id . ' was enabled!</h3';
  }

  mysqli_close($dbc);
?>
  
<div>
  <a href="/classified/backend/admin"><<< Back</a>
</div>

<?php
  include './footer.php';
?>
