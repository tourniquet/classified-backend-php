<?php
  function is_blank ($value) {
    return !isset($value) || trim($value) === '';
  }
?>
