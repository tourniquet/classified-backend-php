<?php
  require_once('../../private/initialize.php');
  include(SHARED_PATH . '/head.php');
?>

<div class="admin-panel">
  <?php
    include(SHARED_PATH . '/header.php');
    include(SHARED_PATH . '/sidebar.php');

    require_once('../../dbc.php');

    $currency_id = $_GET['id'];
    $query = "SELECT name
      FROM cls_currencies
      WHERE id = '$currency_id'";
    $currency = mysqli_fetch_assoc(mysqli_query($dbc, $query));
  ?>

  <main>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
      <input name="id" type="hidden" value="<?= $currency_id; ?>">
      <input
        class="currency-name"
        name="currency"
        placeholder="Currency name"
        required
        type="text"
        value="<?= $currency['name']; ?>"
      >

      <button>Update</button>
    </form>
  </main>

  <?php
    if (is_post_request()) {
      $currency_id = $_POST['id'];
      $currency_name = $_POST['currency'];
      $query = "UPDATE cls_currencies
        SET name = '$currency_name'
        WHERE id = '$currency_id'";
      mysqli_query($dbc, $query);

      redirect_to('index.php?page=1');
    }
  ?>

  <?php include(SHARED_PATH . '/footer.php'); ?>
</div>
