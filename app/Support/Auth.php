<?php

namespace App\Support;


use App\Support\Database;
use App\Controllers\Users;

/**
 *  Authentication Management
 */
class Auth extends Database
{

  /**
   *  Login Management
   */
  function userLogIn($info,$pass)
  {
    //  get the name of the desired Table
    $user = new Users;
    $table = $user->tableName();

    // Checking if the given info found in the given colum
    $data = $this->dataExistInColums($table,['email','username','cell'],$info,'OR');
    if($data['num']!=0){

      $id = $data['user_id'];

      //  Check if Password is matched or not
      $matching_pass = $this->passwordCheck($table, $id, $pass);
      if($matching_pass == true){

        //  Set a Session for Logged in User
        $logged_user = $this->getData($table, $id);
        $_SESSION['logged_user_id'] = $logged_user['id'];
        $_SESSION['logged_user_role'] = $logged_user['role'];
        $_SESSION['logged_user_name'] = $logged_user['name'];
        $_SESSION['logged_user_username'] = $logged_user['username'];
        $_SESSION['logged_user_cell'] = $logged_user['cell'];
        $_SESSION['logged_user_email'] = $logged_user['email'];
        $_SESSION['logged_user_photo'] = $logged_user['photo'];
        $_SESSION['logged_user_password'] = $logged_user['password'];
        $_SESSION['logged_user_created_at'] = $logged_user['created_at'];
        return [
          'status'=>"Success",
          'message'=>"Log In Succeed"
        ];
      }else{
        return [
          'status'=>"Error_info",
          'message'=>"Your given email/username/cell is OK but password isn't"
        ];
      }
    }else{
      return [
        'status'=>"Error",
        'message'=>"email/username/cell doesn't exist"
      ];
    }

  }

  /**
   *  Login Management
   */
  function userLogOut()
  {
    session_destroy();
    header('location:index.php');
  }
}


?>
