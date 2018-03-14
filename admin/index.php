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
    require_once('../appvars.php');

    $dbc = mysqli_connect(
      DB_HOST,
      DB_USER,
      DB_PASSWORD,
      DB_NAME
    ) or Die('Error connecting to database');

    $query = "SELECT * FROM cls_ads ORDER BY pub_date DESC";
    $data = mysqli_query($dbc, $query);

    echo '<ul>';

    while ($row = mysqli_fetch_array($data)) {
      echo '<li>' . $row['title'] . '<a href="remove-ad.php?id=' . $row['id'] . '"> Remove</a></li>';
    }

    echo '</ul>';

    mysqli_close($dbc);
  ?>
</body>
</html>
