<?php

namespace App\Requests;
use App\Support\Database;
use App\Controllers\Users;


/**
 *  User Profile Create Form Data Validation
 */
class UserCreateFormValidate extends Database
{

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
     $user = new Users;
     $data = $this->dataExistInColum($user->tableName(), 'email', $email);

     //  Conditions for Email field
     if(empty($email)){
       $_SESSION['user_create_email_error']="You Must have to Give Email Here";
       return false;
     }elseif($data['status']==true){
       $_SESSION['user_create_email_error']="This Email Already Exists";
       return false;
     }elseif(!$email_validity){
       $_SESSION['user_create_email_error']="Please Give Proper Email Address";
       return false;
     }elseif(!$email_institution){
       $_SESSION['user_create_email_error']="This Email isn't Linked to our Institution";
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
      //  Preg Match for username Value
      $name = $username;
      $allowed_characters = preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/',$name);

      // Checking if the given username exists in the username colum
      $user = new Users;
      $data = $this->dataExistInColum($user->tableName(), 'username', $username);

      //  Conditions for Username field
      if(empty($name)){
        $_SESSION['user_create_username_error']="You Must have to Give Username Here";
        return false;
      }elseif(empty(trim($name))){
        $_SESSION['user_create_username_error']="You can't write only Spaces Here";
        return false;
      }elseif($data['status']==true){
        $_SESSION['user_create_username_error']="This Username has been Already Used";
        return false;
      }elseif(strlen($name)<5){
        $_SESSION['user_create_username_error']="Your username must have atleast 5 Characters";
        return false;
      }elseif(strlen($name)>12){
        $_SESSION['user_create_username_error']="Your username must not exceed 12 characters";
        return false;
      }elseif(!$allowed_characters){
        $_SESSION['user_create_username_error']="Please Give a Valid username here";
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

      // Checking if the given Contact Number exists in the cell colum
      $user = new Users;
      $data = $this->dataExistInColum($user->tableName(), 'cell', $cell);

      //  Conditions for Cell field
      if(empty($cell)){
        $_SESSION['user_create_cell_error']="You Must have to Give Contact Number Here";
        return false;
      }elseif($data['status']==true){
        $_SESSION['user_create_cell_error']="This Contact Number has been already used";
        return false;
      }elseif(!$cell_validity){
        $_SESSION['user_create_cell_error']="Give a Proper Phone Number of Bangladesh";
        return false;
      }else{
        return true;
      }
    }
}


?>
