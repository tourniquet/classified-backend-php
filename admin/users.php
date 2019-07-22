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
    <ul class="users-list-header">
      <li class="check-all"><input id="check-all" type="checkbox"></li>
      <li class="user-id">ID</li>
      <li class="user-email">Email</li>
      <li class="registration-date">Date</li>
      <li>Actions</li>
    </ul>

    <?php
      $page = !empty($_GET['page']) ? $_GET['page'] : 1;
      $offset = ($page - 1) * 5;

      $query = "SELECT *
        FROM cls_users
        ORDER BY id DESC
        LIMIT 10 OFFSET $offset";
      $users = mysqli_query($dbc, $query);

      echo '<ul class="users-list">';
      while ($row = mysqli_fetch_array($users)) {
        echo '<li>
            <span class="check-user">
              <input type="checkbox" name="id[]" value="' . $row['id'] . '">
            </span>
            <span class="user-id">' . $row['id'] . '</span>
            <span class="user-email">' . $row['email'] . '</span>
            <span class="registration-date">08 July, 2019</span>
            <div class="action-icons">
              <a href="#" class="user-profile"><i class="icon ion-md-person"></i></a>
              <a href="#" class="edit-user"><i class="icon ion-md-create"></i></a>
              <a href="#" class="block-user"><i class="icon ion-md-alert"></i></a>
              <a href="remove.php?id=' . $row['id'] . '" class="remove-user"><i class="icon ion-md-trash"></i></a>
            </div>
          </li>';
      }
      echo '</ul>';

      $query = "SELECT COUNT(*) AS total FROM cls_users";
      $res = mysqli_query($dbc, $query);
      $total_users = mysqli_fetch_row($res);
      $total_pages = ceil($total_users[0] / 10);

      mysqli_close($dbc);

      $page_name = 'users';
      $pages = [];
      for ($i = 0; $i < $total_pages; $i++) {
        $pages[] = $i + 1;
      }

      include_once './pagination.php';
    ?>
  </main>

  <?php include_once './footer.php'; ?>
</div>
