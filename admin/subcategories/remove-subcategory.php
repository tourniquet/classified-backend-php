<?php
  require_once('../../dbc.php');

  $subcategory_id = $_GET['id'];
  $parent_id = $_GET['parent_id'];

  $query = "DELETE
    FROM cls_categories
    WHERE id = $subcategory_id AND parent_id = $parent_id";
  mysqli_query($dbc, $query) or die('Error deleting subcategory');
  mysqli_close($dbc);

  header('Location: index.php?page=1');
?>
