<?php
  require_once('../dbc.php');

  $raw_data = file_get_contents('php://input');
  $credentials = json_decode($raw_data, true);

  $user_id = mysqli_real_escape_string($dbc, trim($credentials['userId']));
  $user_email = mysqli_real_escape_string($dbc, trim(strtolower($credentials['userEmail'])));

  $query = "
    SELECT * FROM cls_ads
    WHERE user_id = '$user_id'
    AND user_email = '$user_email'
    ORDER BY published DESC
  ";
  $data = mysqli_query($dbc, $query);

  $results = [];
  while ($i = mysqli_fetch_assoc($data)) {
    $results[] = $i;
  }

  header('Access-Control-Allow-Origin: *', false);
  header('Content-type: application/json', false);
  header('HTTP/1.1 200 OK');

  if (empty($user_id) || empty($user_email)) {
    echo json_encode(['error' => 'User must be logged in to acces this page!']);
    return;
  }

  echo json_encode($results);

  mysqli_close($dbc);
?>
