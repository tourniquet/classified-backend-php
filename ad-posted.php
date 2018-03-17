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

    $visitor_name = $_POST['name'];
    $ad_title = $_POST['title'];
    $ad_description = $_POST['description'];
    $ad_price = $_POST['price'];
    $image = $_FILES['image']['name'];
    
    $file_target = UPLOADS_PATH . $image;
    move_uploaded_file($_FILES['image']['tmp_name'], $file_target);

    echo "<h2>Your ad \"$ad_title\" was posted!</h2>";
    echo '<img src="' . UPLOADS_PATH . $image . '" alt="some alt">';

    $dbc = mysqli_connect(
      DB_HOST,
      DB_USER,
      DB_PASSWORD,
      DB_NAME
    ) or Die('Error connecting to database');
    $query = "INSERT INTO cls_ads (pub_date, name, title, description, price, image) VALUES (NOW(), '$visitor_name', '$ad_title', '$ad_description', '$ad_price', '$image')";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');
    mysqli_close($dbc);

    // try to delete temporary image
    @unlink($_FILES['image']['tmp_name']);
  ?>

  <a href="https://google.com">Google</a>
</body>
</html>
