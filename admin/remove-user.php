<?php
  require_once('../dbc.php');

  $user_id = $_GET['id'];

  $remove_user_query = "DELETE
    FROM cls_users
    WHERE id = $user_id";
  mysqli_query($dbc, $remove_user_query);
  mysqli_close($dbc);

  header('Location: users.php?page=1');
?>
