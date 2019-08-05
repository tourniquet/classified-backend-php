  <!-- // $error_msg = '';

  // if (!isset($_COOKIE['email'])) {
    // $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/classified/backend/login.php';
    // header('Location: ' . $home_url);

    // if (isset($_POST['submit'])) {
      // require_once('../dbc.php');

      // $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
      // $password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      // if (!empty($email) && !empty($password)) {
        // $query = "SELECT email FROM cls_users WHERE email = '$email' AND password = SHA('$password')";
        // $data = mysqli_query($dbc, $query);

        // if (mysqli_num_rows($data) == 1) {
          // $row = mysqli_fetch_array($data);
          // setcookie('email', $row['email']);

          // $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/';
          // header('Location: ' . $home_url);
        // }
        // else {
        //   $error_msg = 'Sorry, you must enter a valid email and password to log in.';
        // }
      // }
      // else {
      //   $error_msg = 'Sorry, you must enter your email and password to log in.';
      // }
    // }
  // } -->

<?php
  include_once './head.php';
?>

<div class="admin-panel">
  <?php
    include_once './header.php';
    include_once './sidebar.php';

    require_once('../dbc.php');
    require_once('./constants.php');
  ?>

  <main>
    <form action="remove-items.php" method="POST">
      <ul class="items-list-header">
        <li class="check-all"><input id="check-all" type="checkbox"></li>
        <li class="item-id">ID</li>
        <li class="item-name">Item name</li>
        <li class="item-subcategory">Item subcategory</li>
        <li class="item-posted-date">Posted date</li>
        <li class="item-actions">Actions</li>
      </ul>

      <?php
        // when admin panel is accessed, url looks like www.example.com/admin/,
        // without page value, so by default page=1
        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * ITEMS_PER_PAGE;

        $query = "SELECT ads.*, sub.title AS subcategory
          FROM cls_ads AS ads
          INNER JOIN cls_categories AS sub ON ads.subcategory_id = sub.id
          ORDER BY published DESC
          LIMIT " . ITEMS_PER_PAGE . " OFFSET $offset";
        $data = mysqli_query($dbc, $query);

        // if (!$data) {
        //   echo json_encode(mysqli_connect_error());
        // }

        // echo json_encode($data);

        // if (isset($_COOKIE['email'])) {
        //   echo '<a href="../logout.php" style="color: red;">Logout</a>';
        // } else {
        //   echo '<a href="../login.php" style="color: red;">Login</a>';
        // }

        echo '<ul class="items-list">';
        while ($row = mysqli_fetch_assoc($data)) {
          // TODO: sprintf()
          $item_state = $row['enabled'] == 1
            ? array(
              'class_name' => 'enabled',
              'href' => 'disable-item.php?id=' . $row['id'],
              'state' => 'Disable'
            )
            : array(
              'class_name' => 'disabled',
              'href' => 'enable-item.php?id=' . $row['id'],
              'state' => 'Enable'
            );
          ?>

          <li class="<?= $item_state['class_name'] ?>">
            <span class="check-item">
              <input name="items[]" type="checkbox" value="<?= $row['id'] ?>">
            </span>
            <span class="item-id"><?= $row['id'] ?></span>
            <a href="<?= FRONT_SIDE . '/item/' . $row['url'] ?>" class="item-title" target="_blank">
              <?= $row['title'] ?>
            </a>
            <a href="#" class="subcategory"><?= $row['subcategory'] ?></a>
            <span class="item-posted-date"><?= date_format(date_create($row['published']), 'd F, Y') ?></span>

            <div class="action-icons">
              <a href="<?= FRONT_SIDE . '/item/' . $row['url'] ?>" class="item-url" target="_blank">
                <i class="icon ion-md-link"></i>
              </a>
              <a href="#" class="edit-icon">
                <i class="icon ion-md-create"></i>
              </a>
              <a href="<?= $item_state['href'] ?>" class="enable-icon">
                <i class="icon ion-md-trending"></i>
              </a>
              <a href="renew-item.php?id=<?= $row['id'] ?>" class="renew-icon">
                <i class="icon ion-md-refresh"></i>
              </a>
              <a href="#" class="disable-icon">
                <i class="icon ion-md-eye-off"></i>
              </a>
              <a href="#" class="spam-icon">
                <i class="icon ion-md-flame"></i>
              </a>
              <a
                class="remove-icon"
                href="remove-item.php?id=<?= $row['id'] ?>"
                onclick="return confirm('Are you sure?')"
              >
                <i class="icon ion-md-trash"></i>
              </a>
            </div>
          </li>
        <?php } ?>
      </ul>

      <button name="submit" onclick="return confirm('Are you sure?')">Delete selected items</button>
    </form>

    <?php
      $query = "SELECT COUNT(*) AS total FROM cls_ads";
      $res = mysqli_query($dbc, $query);
      $total_items = mysqli_fetch_row($res);
      $total_pages = ceil($total_items[0] / ITEMS_PER_PAGE);

      mysqli_close($dbc);

      $page_name = 'index';
      $pages = [];
      for ($i = 0; $i < $total_pages; $i++) {
        $pages[] = $i + 1;
      }
  
      include_once './pagination.php';
    ?>
  </main>
  
  <?php include './footer.php'; ?>
</div>

