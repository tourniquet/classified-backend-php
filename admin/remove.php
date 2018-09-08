<?php
  include './header.php';

  require_once('../dbc.php');
  
  $ad_id = $_GET['id'];
  $img_query = "SELECT * FROM cls_ads WHERE id = $ad_id";
  $img = mysqli_query($dbc, $img_query);

  while ($row = mysqli_fetch_array($img)) {
    // remove image
    @unlink('../' . UPLOADS_PATH . $row['image']);

    $query = 'DELETE FROM cls_ads WHERE id = ' . $_GET['id'];
    mysqli_query($dbc, $query);

    echo '<h3>Your ad ' . $row['title'] . ' was removed!</h3';
  }

  mysqli_close($dbc);
?>
  
<div>
  <a href="/classified/backend/admin"><<< Back</a>
</div>

<?php
  include './footer.php';
?>
