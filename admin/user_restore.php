<?php

  require_once "../vendor/autoload.php";

  use App\Controllers\Users;
  $user = new Users;

  $user_id = $_POST['id'];

  $user->restoreUser($user_id);

  echo '<div class="alert alert-primary alert-dismissible fade show" role="alert"><strong>A User has been Restored SUCCESSFULLY !!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';

?>
