<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Install minClass</title>

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

        // create _users table
        // Because _ads table contains user_id FOREIGN KEY, _users table must be created first
        $query = "CREATE TABLE cls_users (
            id INTEGER PRIMARY KEY AUTO_INCREMENT,
            email VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            token VARCHAR(12) NOT NULL,
            registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            admin TINYINT(1) NOT NULL DEFAULT 0
          )";
        mysqli_query($dbc, $query) or die('Error creating _user table');

        // Create admin user
        $admin_user = $_POST['admin-email'];
        $admin_password = password_hash($_POST['admin-password'], PASSWORD_DEFAULT);
        $query = "INSERT INTO cls_users (email, password, admin)
          VALUES ('$admin_user', '$admin_password', 1)";
        mysqli_query($dbc, $query);

        // create _ads table
        $query = "CREATE TABLE cls_ads (
            id INTEGER PRIMARY KEY AUTO_INCREMENT,
            url INT(8) NOT NULL,
            user_id INTEGER NULL,
            FOREIGN KEY (user_id)
              REFERENCES cls_users (id)
              ON DELETE CASCADE
              ON UPDATE CASCADE,
            user_email VARCHAR(50) NULL,
            published TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            modified DATETIME NULL,
            title VARCHAR(50) NOT NULL,
            description VARCHAR(100) NOT NULL,
            phone VARCHAR(30) NOT NULL,
            visitor_name VARCHAR(30) NOT NULL,
            price VARCHAR(10) NULL,
            enabled TINYINT(1) NOT NULL DEFAULT 1,
            views INT(6) NOT NULL,
            currency_id TINYINT NOT NULL,
            region_id INT(4) NOT NULL,
            `subcategory_id` int(4) NOT NULL
          ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        mysqli_query($dbc, $query) or die('Error creating _ads table');

        // create cls_images table
        $query = "CREATE TABLE cls_images (
          image VARCHAR(30),
          ad_id INT,
          FOREIGN KEY (ad_id)
            REFERENCES cls_ads (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
          )";
        mysqli_query($dbc, $query) or die('Error creating _images table');

        /** create currencies table */
        $query = "CREATE TABLE cls_currencies (
            id INTEGER PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(10) NULL UNIQUE
          ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        mysqli_query($dbc, $query) or die('Error creating _currencies table');
        /**
         * insert a currency with ID == 0 && title == '' (empty string)
         * TODO: this query MUST be deleted when a solution to query an item without price && currency is found
         */
        $query = "INSERT INTO cls_currencies (id, name)
          VALUES (1, '')";
        mysqli_query($dbc, $query) or die('Error inserting into _currencies table');

        /** Create categories table */
        $query = "CREATE TABLE cls_categories (
            id INT(4) PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(50) UNIQUE,
            parent_id INT(4) NULL,
            FOREIGN KEY (parent_id)
              REFERENCES cls_categories (id)
              ON DELETE CASCADE
          ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        mysqli_query($dbc, $query) or die('Error creating _categories table');

        /** Add Transport category */
        $query = "INSERT INTO cls_categories (name)
          VALUES ('Transport')";
        mysqli_query($dbc, $query) or die('Error inserting Transport to categories table');
  
        /** Add Cars subcategory */
        $query = "INSERT INTO cls_categories (name, parent_id)
          VALUES ('Cars', 1)";
        mysqli_query($dbc, $query) or die('Error inserting Transport to categories table');

        /** create regions table */
        $query = "CREATE TABLE cls_regions (
            id INTEGER PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(20) NOT NULL
          ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        mysqli_query($dbc, $query) or die('Error creating _regions table');

        // Inserting default region in _regions table
        $query = "INSERT INTO cls_regions (name)
          VALUES ('London')";
        mysqli_query($dbc, $query) or die('Error inserting London to regions table');


        /** Add a basic ad on newly instaled script */
        $query = "INSERT INTO cls_ads (
            url,
            visitor_name,
            subcategory_id,
            title,
            description,
            price,
            currency_id,
            region_id
          ) VALUES (
            12345678,
            'Anonymous',
            2,
            'Demo ad',
            'Demo description',
            'free',
            1,
            1
          )";
        mysqli_query($dbc, $query) or die('Error querying database.');

        mysqli_close($dbc);
      }
    }
  ?>

  <div class="install">
    <span class="getting-started">
      Below you should enter your database connection details. If you're not sure about these, contact your host.
    </span>

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
        <span class="hint">The name of the database you want to use with minClass.</span>
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
        <label for="admin-email">Admin email</label>
        <input type="text" id="admin-email" class="form-control" name="admin-email" placeholder="Admin email">
        <span class="required"><?php ?></span>
        <span class="hint">Admin email</span>
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
