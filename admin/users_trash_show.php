 <?php
  session_start();
  require_once "../vendor/autoload.php";

  use App\Support\Auth;
  $auth = new Auth;
  use App\Controllers\Users;
  $user = new Users;
  $users = $user->showAllDeletedUsersExcept($_SESSION['logged_user_id']);
  $serial=0;
  foreach($users as $single_user):
 ?>

 <tr>
  <td><?=++$serial?></td>
  <td><?=$single_user['name']?></td>
  <td><?=$single_user['username']?></td>
  <td><?=$single_user['email']?></td>
  <td><?=$single_user['cell']?></td>
  <td><?=$single_user['role']?></td>
  <td class="text-center">
    <?php
      if($single_user['status']=='Active'){
    ?>
        <span class="badge badge-pill badge-success px-3">Active</span>
    <?php
      } else {
    ?>
        <span class="badge badge-pill badge-danger px-3">Inactive</span>
    <?php
      }
    ?>
  </td>
  <td class="text-center">
    <div class="btn-group" role="group">
      <a href="javascript: void(0);" id="user_data_restore" user_id="<?=$single_user['id']?>" class="btn btn-success btn-sm">Restore</a>
      <a href="javascript: void(0);" id="user_data_delete" user_id="<?=$single_user['id']?>" class="btn btn-danger btn-sm">Delete</a>
    </div>
  </td>
</tr>
<?php
  endforeach;
?>
