<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <?php
    require_once('../config.php');
    require_once('../dbc.php');
    
    $ad_id = $_GET['id'];
    $img_query = "SELECT * FROM cls_ads WHERE id = $ad_id";
    $img = mysqli_query($dbc, $img_query);

    while ($row = mysqli_fetch_array($img)) {
      // remove image
      @unlink('../' . UPLOADS_PATH . $row['image']);

      $query = 'DELETE FROM cls_ads WHERE id = ' . $_GET['id'];
      $data = mysqli_query($dbc, $query);

      echo '<h3>Your ad ' . $row['title'] . ' was removed!</h3';
    }

    mysqli_close($dbc);
  ?>
  
  <div>
    <a href="/classified/backend/admin"><<< Back</a>
  </div>
</body>
</html>
