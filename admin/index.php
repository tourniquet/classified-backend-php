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
    // TODO: sprintf()

    $item_state = $row['enabled'] == 1
      ? array(
        'class_name' => 'enabled',
        'href' => 'enable.php?id=' . $row['id'],
        'title' => 'Enable'
      )
      : array(
        'class_name' => 'disabled',
        'href' => 'disable.php?id=' . $row['id'],
        'title' => 'Disable'
      );


    echo '<li class="' . $item_state['class_name']  . '">' . $row['title'] .
            '<a href="remove.php?id=' . $row['id'] . '"> Remove</a>&nbsp;
            <a href="' . $item_state['href'] . '">' . $item_state['title'] .'</a>
            <a href="renew.php?id=' . $row['id'] . '">Renew</a>
          </li>';
  }
  echo '</ul>';

  mysqli_close($dbc);

  include './footer.php';
?>
