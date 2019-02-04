<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Document</title>

  <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
  <?php
    if (isset($_POST['submit'])) {
      setcookie('email', '', time() - 3600, '/');

      header('Location: ' . 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php');
      exit;
    }

    if (isset($_COOKIE['email'])) {
  ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <button name="submit">Log out</button>
    </form>
  <?php
    }
  ?>
