<?php
  require_once('../../dbc.php');

  $category_title = $_POST['title'];

  $query = "INSERT INTO cls_categories (title)
    VALUES ('$category_title')";
  mysqli_query($dbc, $query);
  mysqli_close($dbc);

  header('Location: index.php?page=1');
?>
