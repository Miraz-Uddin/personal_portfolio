<?php

namespace App\Requests;
use App\Support\Database;
use App\Controllers\Users;


/**
 *  User Profile Edit Form Data Validation
 */
class UserEditFormValidate extends Database
{

  /**
   *  ----------Name DATA Validation----------
   *
   *  It will only accept
   *      => 'Letters & Spaces'
   *  It won't accept
   *      => 'Empty Field'
   *      => 'Only Spaces but no letters'
   *      => 'Any Special Characters'
   *      => 'Any Numbers'
   *
   */
   public function validateName($name){
     //  Preg Match for Name Value
     $name_exception = preg_match('/[\d\[\]\/\'`^£$%&*()};"!:{@#~?><>,|=_+¬-]/', $name);
     $name_back_slash_check = preg_match('/\\\\/', $name);

     //  Conditions for Name field
     if(empty($name)){
       $_SESSION['user_edit_name_error']="You Must have to Give Name Here";
       return false;
     }elseif(empty(trim($name)) || $name_exception || $name_back_slash_check){
       $_SESSION['user_edit_name_error']="Please Give a Valid Name";
       return false;
     }else{
       return true;
     }
   }

   /**
    *  ----------Email DATA Validation----------
    *
    *  It will only accept
    *      => '@yahoo.com' , '@gmail.com' , '@bracu.ac.bd' , '@aiub.edu' , '@northsouth.edu'
    *  It won't accept
    *      => 'Empty Field'
    *      => 'Invalid Email Address'
    *      => 'other university e-mail except BRACU,AIUB,NSU university'
    *      => 'other platform except gmail or yahoo mailing system'
    *
    */
   public function validateEmail($email_address){
     //  Preg Match for Email Value
     $email = strtolower($email_address);
     $email_validity = filter_var($email,FILTER_VALIDATE_EMAIL);
     $email_piece = explode('@',$email_validity);
     $extension = end($email_piece);
     $email_institution = in_array($extension,['gmail.com','yahoo.com','bracu.ac.bd','aiub.edu','northsouth.edu']);

     // Checking if the given email address exists in the email colum
     $id = $_SESSION['logged_user_id'];
     $user = new Users;
     $data = $this->dataExistInColumExcludingId($user->tableName(), 'email', $email, $id);

     //  Conditions for Email field
     if(empty($email)){
       $_SESSION['user_edit_email_error']="You Must have to Give Email Here";
       return false;
     }elseif($data['status']==true){
       $_SESSION['user_edit_email_error']="This Email Already Exists";
       return false;
     }elseif(!$email_validity){
       $_SESSION['user_edit_email_error']="Please Give Proper Email Address";
       return false;
     }elseif(!$email_institution){
       $_SESSION['user_edit_email_error']="This Email isn't Linked to our Institution";
       return false;
     }else{
       return true;
     }
   }


   /**
    *  ----------Username DATA Validation----------
    *
    *  It will only accept
    *      => 'Letters'
    *      => 'Numbers'
    *      => 'Underscore'
    *  It won't accept
    *      => 'Empty Field'
    *      => 'Only Spaces but no letters'
    *      => 'Any Special Characters excluding underscore'
    *
    */
    public function validateUsername($username){
      //  Preg Match for Username Value
      $name = $username;
      $allowed_characters = preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/',$name);

      // Checking if the given Username exists in the username colum
      $id = $_SESSION['logged_user_id'];
      $user = new Users;
      $data = $this->dataExistInColumExcludingId($user->tableName(), 'username', $name, $id);

      //  Conditions for Username field
      if(empty($name)){
        $_SESSION['user_edit_username_error']="You Must have to Give Username Here";
        return false;
      }elseif(empty(trim($name))){
        $_SESSION['user_edit_username_error']="You can't write only Spaces Here";
        return false;
      }elseif($data['status']==true){
        $_SESSION['user_edit_username_error']="This Username has been Already Used";
        return false;
      }elseif(strlen($name)<5){
        $_SESSION['user_edit_username_error']="Your username must have atleast 5 Characters";
        return false;
      }elseif(strlen($name)>12){
        $_SESSION['user_edit_username_error']="Your username must not exceed 12 characters";
        return false;
      }elseif(!$allowed_characters){
        $_SESSION['user_edit_username_error']="Please Give a Valid username here";
        return false;
      }else{
        return true;
      }
    }

    /**
     *  ----------Cell DATA Validation----------
     *
     *  It will only accept
     *       => +88018******** / 0088018********
     *       => 011******** / 013******** / 014********
     *       => 015******** / 016******** / 017********
     *       => 018******** / 019********
     *  It won't accept
     *      => 'Empty Field'
     *      => 'Invalid Phone Numbers in Bangladesh'
     *      => 'Number that starts with 012 or 010'
     *
     */
    public function validateCell($cell){
      //  Preg Match for Cell Value
      $cell_validity = preg_match('/(^(\+8801|8801|01|008801))[1|3-9]{1}(\d){8}$/',$cell) ;

      // Checking if the given cell exists in the cell colum
      $id = $_SESSION['logged_user_id'];
      $user = new Users;
      $data = $this->dataExistInColumExcludingId($user->tableName(), 'cell', $cell, $id);

      //  Conditions for CEll Number field
      if(empty($cell)){
        $_SESSION['user_edit_cell_error']="You Must have to Give Contact Number Here";
        return false;
      }elseif($data['status']==true){
        $_SESSION['user_edit_cell_error']="This Contact Number has been already used";
        return false;
      }elseif(!$cell_validity){
        $_SESSION['user_edit_cell_error']="Give a Proper Phone Number of Bangladesh";
        return false;
      }else{
        return true;
      }
    }
}


?>
