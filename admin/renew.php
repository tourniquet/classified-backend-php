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
    $query = "SELECT * FROM cls_ads WHERE id = $ad_id";
    $res = mysqli_query($dbc, $query);

    if (mysqli_connect_errno($dbc)) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }

    while ($row = mysqli_fetch_array($res)) {
      $enable_ad = 'UPDATE cls_ads SET published = NOW() WHERE id = ' . $ad_id;
      $data = mysqli_query($dbc, $enable_ad);

      echo '<h3>Your ad ' . $row['title'] . ' ' . $ad_id . ' was renewed!</h3';
    }

    mysqli_close($dbc);
  ?>
  
  <div>
    <a href="/classified/backend/admin"><<< Back</a>
  </div>
</body>
</html>
