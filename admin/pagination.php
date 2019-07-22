<ul class="pagination">
  <?php
    if ($page == 1) {
      echo '<li class="prev-button disabled">Prev</li>';
    } else {
      echo "<li class='prev-button'><a href='{$page_name}.php?page=" . ($page - 1) . "'>Prev</a></li>";
    }

    for ($i = 0; $i < count($pages); $i++) {
      if ($page == $pages[$i]) {
        echo "<li><a class='page active' href='{$page_name}.php?page={$pages[$i]}'>{$pages[$i]}</a></li>";
      } else {
        echo "<li><a class='page' href='{$page_name}.php?page={$pages[$i]}'>{$pages[$i]}</a></li>";
      }
    }

    if ($page >= count($pages)) {
      echo '<li class="next-button disabled">Next</li>';
    } else {
      echo "<li class='next-button'><a href='{$page_name}.php?page=" . ($page + 1) . "'>Next</a></li>";
    }
  ?>
</ul>
