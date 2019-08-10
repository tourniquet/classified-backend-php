<?php
  require_once('../../private/initialize.php');
  require_once('../../dbc.php');

  $category_title = db_escape($dbc, $_POST['title']);
  $parent_id = is_numeric($_POST['parent-id']) ? db_escape($dbc, $_POST['parent-id']) : "NULL";

  $query = "INSERT INTO cls_categories (title, parent_id)
    VALUES ('$category_title', $parent_id)";
  mysqli_query($dbc, $query);
  mysqli_close($dbc);

  redirect_to('index.php?page=1');
?>
