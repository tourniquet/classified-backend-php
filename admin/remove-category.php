<?php
  require_once('../dbc.php');

  $category_id = $_GET['id'];
  $query = "DELETE
    FROM cls_categories
    WHERE id = $category_id";
  mysqli_query($dbc, $query);
  mysqli_close($dbc);

  header('Location: categories.php?page=1');
?>
