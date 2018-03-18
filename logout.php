<?php
  if (isset($_COOKIE['email'])) {
    setcookie('email', time() - 3600);
  }

  $home_url = 'http://localhost/' . $_SERVER['HTTP_POST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
  header('Location: ' . $home_url);
?>
