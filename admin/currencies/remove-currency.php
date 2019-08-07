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

    $currency_id = $_GET['id'];
    $currency = return_field_name('cls_currencies', $currency_id);

    if (is_post_request()) {
      delete_item('cls_currencies', $currency_id);
    }
  ?>

  <main>
    <a href="index.php?page=1"><<< Back</a>
    <br>

    <form action="remove-currency.php?id=<?php echo $currency_id; ?>" method="POST">
      <span>Are you sure you want to remove <?php echo $currency['title']; ?>?</span>
      <button>Remove currency</button>
    </form>
  </main>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
