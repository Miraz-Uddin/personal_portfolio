<?php

  require_once "../vendor/autoload.php";

  use App\Controllers\Users;
  $user = new Users;

  $user_id = $_POST['id'];

  $user->deleteUser($user_id);

  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>A User has been Destroyed from the DATABASE</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';

?>
