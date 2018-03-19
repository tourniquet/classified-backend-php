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
    require_once('config.php');

    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('Error connecting to database');
    $query = "SELECT * FROM cls_ads ORDER BY pub_date DESC";
    $data = mysqli_query($dbc, $query);

    if (isset($_COOKIE['email'])) {
      echo '<a href="logout.php">Logout</a>';
    } else {
      echo '<a href="login.php">Login</a>';
    }

    echo '<ul>';

    while ($row = mysqli_fetch_array($data)) {
      if ($row['enabled'] == 1) {
        echo '<li class="enabled">' . $row['title'] . '</li>';
      }
    }

    echo '</ul>';

    mysqli_close($dbc);
  ?>
</body>
</html>
