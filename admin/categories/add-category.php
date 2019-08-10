<?php
  require_once('../../private/initialize.php');
  require_once('../../dbc.php');

  $category_title = db_escape($dbc, $_POST['title']);

  $query = "INSERT INTO cls_categories (title)
    VALUES ('$category_title')";
  mysqli_query($dbc, $query);
  mysqli_close($dbc);

  redirect_to('index.php?page=1');
?>
