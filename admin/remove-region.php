<?php
  require_once('../dbc.php');

  $region_id = $_GET['id'];
  $query = "DELETE
    FROM cls_regions
    WHERE id = $region_id";
  mysqli_query($dbc, $query);
  mysqli_close($dbc);

  header('Location: regions.php?page=1');
?>
