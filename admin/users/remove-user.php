<?php
  require_once('../../private/initialize.php');
  include(SHARED_PATH . '/head.php');
?>

<div class="admin-panel">
  <?php
    include(SHARED_PATH . '/header.php');
    include(SHARED_PATH . '/sidebar.php');

    require_once('../../private/initialize.php');
    require_once('../../dbc.php');

    $user_id = $_GET['id'];
    $user = return_field_name('cls_users', $user_id);

    if (is_post_request()) {
      delete_item('cls_users', $user_id);
    }
  ?>

  <main>
    <a href="index.php?page=1"><<< Back</a>
    <br>

    <form action="remove-user.php?id=<?php echo $user_id; ?>" method="POST">
      <span>Are you sure you want to remove <?php echo $user['email']; ?>?</span>
      <button>Remove user</button>
    </form>
  </main>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
