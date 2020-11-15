<?php

require_once "../vendor/autoload.php";

session_start();
use App\Controllers\Users;
$user = new Users;
$user_id = $_POST['id'];
$data = $user->userDataUpdatePro($user_id,$_POST);

if($data == 'no'){
  echo '<div class="alert alert-info" role="alert"><strong>Nothing to Update</strong></div>';
}elseif($data == 'ok'){
  echo '<div class="alert alert-success" role="alert"><strong>Datas has been SUCCESSFULLY Changed</strong></div>';
}else{
  echo '<div class="alert alert-danger" role="alert"><strong>'.$data.'</strong></div>';
}

?>
