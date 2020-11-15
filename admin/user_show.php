<?php

  require_once "../vendor/autoload.php";

  use App\Controllers\Users;
  $user = new Users;

  $user_id = $_POST['id'];

  $data = $user->showSingleUser($user_id);
  $user_data = json_encode($data);
  print_r($user_data);
?>
