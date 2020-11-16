<?php

namespace App\Controllers;
use App\Support\Database;
use App\Requests\UserEditFormValidate;
use App\Requests\UsersEditFormValidate;
use App\Requests\UserCreateFormValidate;
use App\Libs\Functions;

/**
 *  User Management
 */
class Users extends Database
{
  public $table = 'users';

  /**
   *  Get Table Name
   */
  public function tableName(){
    return $this->table;
  }

  /**
   *  Old Password Verify
   */
  public function oldPasswordMatch($old_pass){
    $db_pass = $_SESSION['logged_user_password'];

    // Verify If Old Password is given or not
    if(empty($old_pass)){
      $_SESSION['user_edit_old_pass_error']="You Must have to Give Your Account PASSWORD here to Update Anything";
      return false;
    }else{
      //  Verify the Hash Password , if matched return true , else false
      if(password_verify($old_pass,$db_pass)){
        return true;
      }
      else{
        $_SESSION['user_edit_old_pass_error']="You have given a Wrong password";
        return false;
      }
    }
  }

  /**
   *  New Password Data Validation Check
   */
  public function newPasswordCheck($new_pass='',$new_pass_confirm='',$old_pass){

    // Preg Match for New Password characters
    $uppercase = preg_match('@[A-Z]@',$new_pass);
    $lowercase = preg_match('@[a-z]@',$new_pass);
    $number = preg_match('@[0-9]@',$new_pass);
    $special_chars = preg_match('/[\[\]\/\'`^£$%&*()};"!:{@#~?><>,|=_+¬-]/', $new_pass);

    // Flag Variables
    $status_code=1;
    $str='';
    $str2='';

    // Conditions for Newly Created password
    if(empty($new_pass) AND empty($new_pass_confirm)){
      $status_code=0;
    }
    elseif(empty($new_pass) AND !empty($new_pass_confirm)){ $str="You have to Fill New Password too to Update Old Password";  }
    elseif(!empty($new_pass) AND empty($new_pass_confirm)){ $str2="You have to Give the New Password Again to Update Old Password"; }
    elseif(!$uppercase){  $str="A Strong Password Must Contain a Block Letter"; }
    elseif(!$lowercase){  $str="A Strong Password should have atleast a Lower-case Letter"; }
    elseif(!$special_chars){  $str="A Strong Password have at least a Special Character"; }
    elseif(!$number){ $str="A Strong Password must have at least a Numeric Number"; }
    elseif(strlen($new_pass)<8){  $str="Password Length is Minimum 8 Characters"; }
    elseif($new_pass != $new_pass_confirm){
      $str="Your New Password mis-matched with your Confirmation Password";
      $str2="Your Confirmation Password mis-matched with your NEW Password";
    }
    else{
      $status_code=2;
    }

    //  Return the New Password if New Password Strong Enough
    if($status_code==0){
      $_SESSION['new_password_same']=true;
      $_SESSION['new_password_same_error']=false;
      return [  'status'=>false ];
    }
    if($status_code==1){
      $_SESSION['user_edit_new_pass_error']=$str;
      $_SESSION['user_edit_new_pass_confirm_error']=$str2;
      $_SESSION['new_password_same']=false;
      $_SESSION['new_password_same_error']=true;
      return [  'status'=>false ];
    }
    if($status_code==2){
      $db_pass = $_SESSION['logged_user_password'];
      if(password_verify($new_pass,$db_pass)){
        $_SESSION['new_password_same']=true;
        $_SESSION['new_password_same_error']=false;
      }
      else{
        $_SESSION['new_password_same']=false;
        $_SESSION['new_password_same_error']=false;
      }
      return [
        'status'=>true,
        'value'=>$new_pass
      ];
    }
  }

  /**
   *  Show Single User
   */
  public function showSingleUser($id){
    return $this->getData($this->tableName(),$id);
  }

  /**
   *  Show All Users
   */
  public function showAllUsers(){
    return $this->getAll($this->tableName());
  }

  /**
   *  Show All Users Except the id that is given
   */
  public function showAllUsersExcept($id){
    return $this->getAllExcept($this->tableName(),$id);
  }

  /**
   *  Show All Soft Deleted Users
   */
  public function showAllDeletedUsersExcept($id){
    return $this->getAllDeletedExcept($this->tableName(),$id);
  }

  /**
   *  Restore a User DATA
   */
  public function restoreUser($id){
    $this->restore($this->tableName(),$id);
    return true;
  }

  /**
   *  Delete a User DATA Permanently
   */
  public function deleteUser($id){
    $data = $this->getData($this->tableName(),$id);
    $location = '../assets/uploaded_images/users/';

    if($data['photo']!='default_photo.jpg'){
      unlink($location.$data['photo']);
    }
    $this->delete($this->tableName(),$id);
    return true;
  }

  /**
   *  User Profile's DATA Update For Logged in User
   */
  public function userDataUpdate($id,array $arr){
    $formDataValidate = new UserEditFormValidate;
    $check_updated_name = $formDataValidate -> validateName($arr['name']);
    $check_updated_username = $formDataValidate -> validateUsername($arr['username']);
    $check_updated_email = $formDataValidate -> validateEmail($arr['email']);
    $check_updated_cell = $formDataValidate -> validateCell($arr['cell']);

    if($arr['name']==$_SESSION['logged_user_name'] AND $arr['username']==$_SESSION['logged_user_username'] AND $arr['email']==$_SESSION['logged_user_email'] AND $arr['cell']==$_SESSION['logged_user_cell']){
      $_SESSION['new_data_same']=true;
      $_SESSION['new_data_same_error']=false;
      return true;
    }else{
      $_SESSION['new_data_same']=false;
      if(!$check_updated_name || !$check_updated_username || !$check_updated_email || !$check_updated_cell){
        $_SESSION['new_data_same_error']=true;
        return false;
      }else{
        $_SESSION['new_data_same_error']=false;
        date_default_timezone_set('Asia/Dhaka');
        $this->update($id,$this->tableName(),[
          'name'=>$arr['name'],
          'username'=>$arr['username'],
          'email'=>$arr['email'],
          'cell'=>$arr['cell'],
          'updated_at'=>date('Y-m-d h:i:s')
        ]);
        return true;
      }
    }
  }

  /**
   *  User Profile's DATA Update For all Users
   */
  public function userDataUpdatePro($id,array $arr){
    // Get Form Data
    $updated_name = $arr['name'];
    $updated_username = $arr['username'];
    $updated_email = $arr['email'];
    $updated_cell = $arr['cell'];
    $updated_role = $arr['role'];
    $updated_status = $arr['status'];
    $updated_password = $arr['password'];

    //  Get Original Data
    $data = $this->showSingleUser($id);
    $name = $data['name'];
    $username = $data['username'];
    $email = $data['email'];
    $cell = $data['cell'];
    $role = $data['role'];
    $status = $data['status'];
    $password = $data['password'];

    $formDataValidate = new UsersEditFormValidate;
    if($name==$updated_name AND $username==$updated_username AND $email==$updated_email AND $cell==$updated_cell AND $role==$updated_role AND $status==$updated_status){
      if($updated_password!=''){
        $check_updated_password = $formDataValidate -> validatePassword($updated_password);
        if($check_updated_password != 'ok'){  return $check_updated_password; }
        else{
          if(password_verify($updated_password,$password)){
            return "no";
          }
          else{
            $updated_password_hash = password_hash($updated_password,PASSWORD_DEFAULT);
            $this->update($id,$this->tableName(),[  'password'=>$updated_password_hash ]);
            return "ok";
          }
        }
      }else{
        return "no";
      }
    }else{
      $check_updated_name = $formDataValidate -> validateName($updated_name,$id);
      $check_updated_username = $formDataValidate -> validateUsername($updated_username,$id);
      $check_updated_email = $formDataValidate -> validateEmail($updated_email,$id);
      $check_updated_cell = $formDataValidate -> validateCell($updated_cell,$id);
      if($updated_password!=''){
        $check_updated_password = $formDataValidate -> validatePassword($updated_password);
        if($check_updated_name != 'ok'){  return $check_updated_name; }
        elseif($check_updated_username != 'ok'){  return $check_updated_username; }
        elseif($check_updated_email != 'ok'){  return $check_updated_email; }
        elseif($check_updated_cell != 'ok'){  return $check_updated_cell; }
        elseif($check_updated_password != 'ok'){  return $check_updated_password; }
        else{
          $updated_password_hash = password_hash($updated_password,PASSWORD_DEFAULT);
          date_default_timezone_set('Asia/Dhaka');
          $this->update($id,$this->tableName(),[
            'name'=>$updated_name,
            'username'=>$updated_username,
            'email'=>$updated_email,
            'cell'=>$updated_cell,
            'role'=>$updated_role,
            'status'=>$updated_status,
            'password'=>$updated_password_hash,
            'updated_at'=>date('Y-m-d h:i:s')
          ]);
          return "ok";
        }
      }
      else{
        if($check_updated_name != 'ok'){  return $check_updated_name; }
        elseif($check_updated_username != 'ok'){  return $check_updated_username; }
        elseif($check_updated_email != 'ok'){ return $check_updated_email;  }
        elseif($check_updated_cell != 'ok'){  return $check_updated_cell; }
        else{
          date_default_timezone_set('Asia/Dhaka');
          $this->update($id,$this->tableName(),[
            'name'=>$updated_name,
            'username'=>$updated_username,
            'email'=>$updated_email,
            'cell'=>$updated_cell,
            'role'=>$updated_role,
            'status'=>$updated_status,
            'updated_at'=>date('Y-m-d h:i:s')
          ]);
          return "ok";
        }
      }
    }
  }

  /**
   *  User Profile Photo Update
   */
  public function userPhotoUpdate(array $arr){
    $id = $_SESSION['logged_user_id'];
    $arr['id'] = $id;
    $photo = $_SESSION['logged_user_photo'];
    $location = '../assets/uploaded_images/users/';
    if($photo!='default_photo.jpg'){
      unlink($location.$photo);
    }
    $func = new Functions;
    $data = $func->fileUpload($arr,$location,['jpg','png','jpeg']);
    $_SESSION['logged_user_photo'] = $data['name'];
    date_default_timezone_set('Asia/Dhaka');
    $this->update($id,$this->tableName(),[
      'photo'=>$data['name'],
      'updated_at'=> date('Y-m-d h:i:s')
    ]);
    return "User Photo has been Successfully Updated";
  }

  /**
   *  User Profile Password Update
   */
  public function userPasswordUpdate($id,$new_pass){
    $new_password = password_hash($new_pass,PASSWORD_DEFAULT);
    date_default_timezone_set('Asia/Dhaka');
    $this->update($id,$this->tableName(),[
      'password'=>$new_password,
      'updated_at'=> date('Y-m-d h:i:s')
    ]);
    return true;
  }

  /**
   *  Create a USER Account
   */
  public function userAccountCreate(array $arr){
    $formDataValidate = new UserCreateFormValidate;
    $check_username = $formDataValidate -> validateUsername($arr['username']);
    $check_email = $formDataValidate -> validateEmail($arr['email']);
    $check_cell = $formDataValidate -> validateCell($arr['cell']);

    if($check_username AND $check_email AND $check_cell){
      date_default_timezone_set('Asia/Dhaka');
      $this->create($this->tableName(),[
        'username'=>$arr['username'],
        'cell'=>$arr['cell'],
        'email'=>$arr['email'],
        'password'=>password_hash('mr.RAZ@786',PASSWORD_DEFAULT),
        'created_at'=>date('Y-m-d h:i:s'),
        'updated_at'=>'0000-00-00 00:00:00'
      ]);
      return true;
    }
  }

  /**
   *  Soft Delete a User Account
   */
  public function userAccountSoftDelete($id){
    $this->softDelete($this->tableName(),$id);
    return true;
  }
}


?>
