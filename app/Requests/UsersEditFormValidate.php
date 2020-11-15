<?php

namespace App\Requests;
use App\Support\Database;
use App\Controllers\Users;


/**
 *  User Profile Edit Form Data Validation
 */
class UsersEditFormValidate extends Database
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
       return "You Must have to Give Name Here";
     }elseif(empty(trim($name)) || $name_exception || $name_back_slash_check){
       return "Please Give a Valid Name";
     }else{
       return "ok";
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
   public function validateEmail($email_address,$user_id){
     //  Preg Match for Email Value
     $email = strtolower($email_address);
     $email_validity = filter_var($email,FILTER_VALIDATE_EMAIL);
     $email_piece = explode('@',$email_validity);
     $extension = end($email_piece);
     $email_institution = in_array($extension,['gmail.com','yahoo.com','bracu.ac.bd','aiub.edu','northsouth.edu']);

     // Checking if the given email address exists in the email colum
     $id = $user_id;
     $user = new Users;
     $data = $this->dataExistInColumExcludingId($user->tableName(), 'email', $email, $id);

     //  Conditions for Email field
     if(empty($email)){
       return "You Must have to Give Email Here";
     }elseif($data['status']==true){
       return "This Email Already Exists";
     }elseif(!$email_validity){
       return "Please Give Proper Email Address";
     }elseif(!$email_institution){
       return "This Email isn't Linked to our Institution";
     }else{
       return "ok";
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
    public function validateUsername($username,$user_id){
      //  Preg Match for Username Value
      $name = $username;
      $allowed_characters = preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/',$name);

      // Checking if the given Username exists in the username colum
      $id = $user_id;
      $user = new Users;
      $data = $this->dataExistInColumExcludingId($user->tableName(), 'username', $name, $id);

      //  Conditions for Username field
      if(empty($name)){
        return "You Must have to Give Username Here";
      }elseif(empty(trim($name))){
        return "You can't write only Spaces Here";
      }elseif($data['status']==true){
        return "This Username has been Already Used";
      }elseif(strlen($name)<5){
        return "Your username must have atleast 5 Characters";
      }elseif(strlen($name)>12){
        return "Your username must not exceed 12 characters";
      }elseif(!$allowed_characters){
        return "Please Give a Valid username here";
      }else{
        return "ok";
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
    public function validateCell($cell,$user_id){
      //  Preg Match for Cell Value
      $cell_validity = preg_match('/(^(\+8801|8801|01|008801))[1|3-9]{1}(\d){8}$/',$cell) ;

      // Checking if the given cell exists in the cell colum
      $id = $user_id;
      $user = new Users;
      $data = $this->dataExistInColumExcludingId($user->tableName(), 'cell', $cell, $id);

      //  Conditions for CEll Number field
      if(empty($cell)){
        return "You Must have to Give Contact Number Here";
      }elseif($data['status']==true){
        return "This Contact Number has been already used";
      }elseif(!$cell_validity){
        return "Give a Proper Phone Number of Bangladesh";
      }else{
        return "ok";
      }
    }

    /**
     *  ----------Password DATA Validation----------
     *
     *  It will accept
     *       => Any Value
     *  It won't accept
     *      => if the password has no BLOCK letter (Capital letter)
     *      => if the password has no Lower-case letter
     *      => if the password has no Special Character
     *      => if the password has no Number
     *      => if the password has less than 8 Characters
     *
     */
    public function validatePassword($pass){

      $new_pass = $pass;
      // Preg Match for New Password characters
      $uppercase = preg_match('@[A-Z]@',$new_pass);
      $lowercase = preg_match('@[a-z]@',$new_pass);
      $number = preg_match('@[0-9]@',$new_pass);
      $special_chars = preg_match('/[\[\]\/\'`^£$%&*()};"!:{@#~?><>,|=_+¬-]/', $new_pass);

      if(!$uppercase){
        return "A Strong Password Must Contain a Block Letter";
      }elseif(!$lowercase){
        return "A Strong Password should have atleast a Lower-case Letter";
      }elseif(!$special_chars){
        return "A Strong Password have at least a Special Character";
      }elseif(!$number){
        return "A Strong Password must have at least a Numeric Number";
      }elseif(strlen($new_pass)<8){
        return "Password Length is Minimum 8 Characters";
      }else{
        return "ok";
      }
    }
}


?>
