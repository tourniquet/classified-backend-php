<?php
  require_once('../private/initialize.php');

  if (isset($_COOKIE['email'])) {
    setcookie('email', '', time() - 3600, '/');
  }

  redirect_to('login.php');
?>
