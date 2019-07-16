<div class="admin-panel">
  <?php
    include './head.php';
    include './header.php';
  ?>

  <main>
    <?php
      require_once('../dbc.php');

      $page = !empty($_GET['page']) ? $_GET['page'] : 1;
      $offset = ($page - 1) * 5;

      echo '<form class="add-currency">
          <input class="currency-name" placeholder="Currency name" type="text">
          <button>Add currency</button>
        </form>';
    ?>
    
    <ul class="currencies-list-header">
      <li class="check-all">
        <input id="check-all" type="checkbox">
      </li>
      <li class="currency-id">ID</li>
      <li class="currency-name">Currency</li>
      <li>Actions</li>
    </ul>

    <?php
      $query = "SELECT *
        FROM cls_currencies
        ORDER BY id DESC
        LIMIT 5 OFFSET $offset";
      $currencies = mysqli_query($dbc, $query);

      echo '<ul class="currencies-list">';
      while ($row = mysqli_fetch_array($currencies)) {
        echo '<li>
          <span class="check-currency">
            <input type="checkbox">
          </span>
          <span class="currency-id">' . $row['id'] . '</span>
          <span class="currency-name">' . $row['title'] . '</span>
          <div class="action-icons">
            <a href="#" class="edit-region"><i class="icon ion-md-create"></i></a>
            <a href="remove.php?id=' . $row['id'] . '" class="remove-region">
              <i class="icon ion-md-trash"></i>
            </a>
          </div>
        ';
      }
    ?>
  </main>
</div>
