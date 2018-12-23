<?php
  include './header.php';

  require_once('../dbc.php');

  if (!isset($_COOKIE['email'])) {
    header('Location: ' . 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/login.php');
  }

  $query = "SELECT * FROM cls_ads ORDER BY published DESC";
  $data = mysqli_query($dbc, $query);

  echo '<ul class="items-list">';
  while ($row = mysqli_fetch_array($data)) {
    if ($row['enabled'] == 1) {
      echo '<li class="enabled">' . $row['title'] .
          '<a href="remove.php?id=' . $row['id'] . '"> Remove</a>&nbsp;
          <a href="disable.php?id=' . $row['id'] . '">Disable</a>
          <a href="renew.php?id=' . $row['id'] . '">Renew</a>
        </li>';
    } else {
      echo '<li class="disabled">' . $row['title'] .
          '<a href="remove.php?id=' . $row['id'] . '"> Remove</a>&nbsp;
          <a href="enable.php?id=' . $row['id'] . '">Enable</a>&nbsp;
          <a href="renew.php?id=' . $row['id'] . '">Renew</a>
        </li>';
    }
  }
  echo '</ul>';

  mysqli_close($dbc);

  include './footer.php';
?>
