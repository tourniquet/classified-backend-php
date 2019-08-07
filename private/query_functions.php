<?php
  function delete_item ($table, $id) {
    global $dbc;

    $query = "DELETE
      FROM $table
      WHERE id = '$id'
      LIMIT 1";
    $result = mysqli_query($dbc, $query);

    if ($result) {
      redirect_to('index.php?page=1');
    } else {
      request_error();
    }
  }

  function request_error () {
    global $dbc;

    echo mysqli_error($dbc);
    mysqli_close($dbc);
    exit;
  }

  function return_field_name ($table, $id) {
    global $dbc;

    $query = "SELECT *
      FROM $table
      WHERE id='$id'
      LIMIT 1";

    return mysqli_fetch_assoc(mysqli_query($dbc, $query));
  }
?>
