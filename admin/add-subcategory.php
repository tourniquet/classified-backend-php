<?php
  require_once('../dbc.php');

  $category_title = $_POST['title'];
  $parent_id = is_numeric($_POST['parent-id']) ? $_POST['parent-id'] : "NULL";

  $query = "INSERT INTO cls_categories (title, parent_id)
    VALUES ('$category_title', $parent_id)";
  mysqli_query($dbc, $query);
  mysqli_close($dbc);

  header('Location: subcategories.php?page=1');
?>
