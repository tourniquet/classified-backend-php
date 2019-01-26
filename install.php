<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Install CLASSIFIED</title>

  <link rel="stylesheet" href="./styles/styles.css">
</head>
<body>
  <?php
    $db_host_err = $db_name_err = $db_user_err = $db_password_err = '';
    $db_host = $db_name = $db_user = $db_password = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST['db-host'])) {
        $db_host_err = 'required!';
      } else {
        $db_host = $_POST['db-host'];
      }

      if (empty($_POST['db-name'])) {
        $db_name_err = 'required!';
      } else {
        $db_name = $_POST['db-name'];
      }

      if (empty($_POST['db-username'])) {
        $db_user_err = 'required!';
      } else {
        $db_user = $_POST['db-username'];
      }

      if (empty($_POST['db-password'])) {
        $db_password_err = 'required!';
      } else {
        $db_password = $_POST['db-password'];
      }

      if ($db_host && $db_name && $db_user && $db_password) {
        $dbc = mysqli_connect(
          $db_host,
          $db_user,
          $db_password,
          $db_name
        ) or die('Error connecting to database');
        
        // create cls_ads table
        $query = "
          CREATE TABLE cls_ads (
            id INTEGER PRIMARY KEY AUTO_INCREMENT,
            url INT(8) NOT NULL,
            user_id INTEGER  NULL,
            user_email VARCHAR(50) NULL,
            published DATETIME NOT NULL,
            modified DATETIME NULL,
            title VARCHAR(50) NOT NULL,
            description VARCHAR(100) NOT NULL,
            phone INT(12),
            name VARCHAR(30) NOT NULL,
            price VARCHAR(10) NULL,
            enabled TINYINT(4) NOT NULL,
            views INT(6) NOT NULL
          );
        ";
        mysqli_query($dbc, $query) or die('Error querying database.');

        // create cls_users table
        $query = "
          CREATE TABLE cls_users (
            id INTEGER PRIMARY KEY AUTO_INCREMENT,
            email VARCHAR(50) NOT NULL,
            password VARCHAR(50) NOT NULL,
            token VARCHAR(12) NOT NULL
          )
        ";
        mysqli_query($dbc, $query) or die('Error querying database.');

        // create cls_images table
        $query = "
            CREATE TABLE cls_images (
              image VARCHAR(30),
              ad_id INT
            )
        ";
        mysqli_query($dbc, $query) or die('Error querying database.');

        $query = "
          INSERT INTO cls_ads (url, published, name, title, description, price)
            VALUES (12345678, NOW(), 'Anonymous', 'Demo ad', 'Demo description', 'free');
        ";
        mysqli_query($dbc, $query) or die('Error querying database.');

        mysqli_close($dbc);
      }
    }
  ?>

  <div class="container">
    <span class="somespan">Below you should enter your database connection details. If you're not sure about these, contact your host.</span>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="host">Host</label>
        <input type="text" id="db-host" class="form-control" name="db-host" placeholder="Host">
        <span class="required"><?php echo $db_host_err; ?></span>
        <span class="hint">Server name or IP where the database engine resides.</span>
      </div>

      <div class="form-group">
        <label for="database">Database</label>
        <input type="text" id="db-name" class="form-control" name="db-name" placeholder="Database name">
        <span class="required"><?php echo $db_name_err; ?></span>
        <span class="hint">The name of the database you want to use with CLASSIFIED.</span>
      </div>

      <div class="form-group">
        <label for="db-username">Database username</label>
        <input type="text" id="db-username" class="form-control" name="db-username" placeholder="Database username">
        <span class="required"><?php echo $db_user_err; ?></span>
        <span class="hint">Your database username.</span>
      </div>

      <div class="form-group">
        <label for="db-password">Database password</label>
        <input type="text" id="db-password" class="form-control" name="db-password" placeholder="Database password">
        <span class="required"><?php echo $db_password_err; ?></span>
        <span class="hint">Your database password.</span>
      </div>

      <div class="form-group">
        <label for="admin-username">Admin username</label>
        <input type="text" id="admin-username" class="form-control" name="admin-username" placeholder="Admin username">
        <span class="required"><?php ?></span>
        <span class="hint">Admin username.</span>
      </div>

      <div class="form-group">
        <label for="admin-password">Admin password</label>
        <input type="text" id="admin-password" class="form-control" name="admin-password" placeholder="Admin password">
        <span class="required"><?php ?></span>
        <span class="hint">Admin password.</span>
      </div>

      <button type="submit" class="button">Submit</button>
    </form>
  </div>
</body>
</html>
