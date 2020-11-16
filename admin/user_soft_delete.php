<?php

  require_once "../vendor/autoload.php";

  use App\Controllers\Users;
  $user = new Users;

  $user_id = $_POST['id'];

  $user->userAccountSoftDelete($user_id);

  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>User has been Moved to Trash!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';

?>
