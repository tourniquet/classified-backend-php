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
  include './head.php';
?>

<div class="admin-panel">
  <?php
    include './header.php';
    include './sidebar.php';

    require_once('../dbc.php');
    require_once('./categories.php');
  ?>

  <main>
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
        while ($row = mysqli_fetch_array($data)) {
          // TODO: sprintf()

          $item_state = $row['enabled'] == 1
            ? array(
              'class_name' => 'enabled',
              'href' => 'disable.php?id=' . $row['id'],
              'state' => 'Disable'
            )
            : array(
              'class_name' => 'disabled',
              'href' => 'enable.php?id=' . $row['id'],
              'state' => 'Enable'
            );

          echo '<li class="' . $item_state['class_name'] . '">' . '
                  <a href="#" class="item-title">' . $row['title'] . '</a>
                  <a href="#" class="subcategory">' . $row['subcategory'] . '</a>
                  <span class="">' . date_format(date_create($row['published']), 'd F, Y') . '</span>
                  <div class="action-icons">
                    <a href="#" class="url-icon"></a>
                    <a href="#" class="edit-icon"></a>
                    <a href="' . $item_state['href'] . '" class="enable-icon"></a> <!-- $item_state[state] -->
                    <a href="renew.php?id=' . $row['id'] . '" class="renew-icon"></a>
                    <a href="#" class="disable-icon"></a>
                    <a href="#" class="spam-icon"></a>
                    <a href="remove.php?id=' . $row['id'] . '" class="remove-icon"></a>
                  </div>
                </li>';
        }
        echo '</ul>';

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

      include_once('./pagination.php');
    ?>
  </main>
  
  <?php include './footer.php'; ?>
</div>

