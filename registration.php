<?php
  require_once('dbc.php');

  $raw_data = file_get_contents('php://input');
  $data = json_decode($raw_data, true);

  $email = mysqli_real_escape_string($dbc, trim(strtolower($data['email'])));
  $password = mysqli_real_escape_string($dbc, trim($data['password']));
  $password_confirmation = mysqli_real_escape_string($dbc, trim($data['passwordConfirmation']));

  if (!empty($email) && !empty($password) && !empty($password_confirmation)) {
    if ($password == $password_confirmation) {
      // check if email is already taken
      $query = "SELECT * FROM cls_users WHERE email = '$email'";
      $data = mysqli_query($dbc, $query);

      if (mysqli_num_rows($data) == 0) {
        // the email is unique, so insert the data into the database
        $query = "INSERT INTO cls_users (email, password, token) VALUES ('$email', '$password', '012345678912')";
        mysqli_query($dbc, $query) or die('Error querying database.');
        
        // confirm success with the user
        echo json_encode('Success!');
      } elseif (mysqli_num_rows($data) > 0) {
        echo json_encode('Existing!');
      }
    // password and confirmation password did not match
    } else {
      echo json_encode('Unmatch!');
    }
  }

  mysqli_close(dbc);
?>
