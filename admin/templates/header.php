<?php
  session_start();
  require_once "../vendor/autoload.php";

  use App\Support\Auth;
  $auth = new Auth;

  if(isset($_GET['logout']) AND $_GET['logout']=='success'){
    $auth -> userLogOut();
  }
  //  Page Security
  if(empty($_SESSION['logged_user_id']) AND empty($_SESSION['logged_user_role']) AND empty($_SESSION['logged_user_name']) AND empty($_SESSION['logged_user_username']) AND empty($_SESSION['logged_user_cell']) AND empty($_SESSION['logged_user_email']) AND empty($_SESSION['logged_user_password'])){
     $auth -> userLogOut();
  }

  use App\Controllers\Users;
  $user = new Users;

  // After Clicking Create Button
  if(isset($_POST['create_user'])){
    // get all FORM Datas
    $username = $_POST['username'];
    $cell = $_POST['cell'];
    $email = $_POST['email'];

    // DATA Create
    $user_create_status = $user->userDataCreate([
      'username'=>$username,
      'cell'=>$cell,
      'email'=>$email,
    ]);
    if($user_create_status){
      $_SESSION['user_create_success']="A User has been SUCCESSFULLY CREATED";
    }
  }
  //  After Clicking Update Photo
  if(isset($_POST['user_photo_update_btn'])){
    $file = $_FILES['change_photo'];
    if(empty($file['name'])){
      $_SESSION['user_photo_update_status']='NO photo has been selected to update';
    }else {
      $_SESSION['user_photo_update_status'] = $user->userPhotoUpdate($file);
    }
  }

  // After Clicking Update Button
  if(isset($_POST['update_settings'])){

    // get all form Datas
    $id = $_POST['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $cell = $_POST['cell'];
    $email = $_POST['email'];
    $new_pass = $_POST['new_pass'];
    $new_pass_confirm = $_POST['new_pass_confirm'];
    $old_pass = $_POST['old_pass'];

    // Password & Data Management
    if($user->oldPasswordMatch($old_pass)){
      $updated_password = $user->newPasswordCheck($new_pass,$new_pass_confirm,$old_pass);

      // PASSWORD Update
      if($updated_password['status']){
        $user->userPasswordUpdate($id,$updated_password['value']);
      }

      // DATA Update
      $user->userDataUpdate($id,[
        'name'=>$name,
        'username'=>$username,
        'cell'=>$cell,
        'email'=>$email,
      ]);

      // Print User DATA Update Status
      if(!$_SESSION['new_data_same_error'] AND !$_SESSION['new_password_same_error']){
        if($_SESSION['new_data_same']){
          if($_SESSION['new_password_same']){
            $_SESSION['user_profile_update_info']="Nothing to Update";
          }else{
            $_SESSION['user_profile_update_success']="Your Password has been Updated Successfully";
            //  UPDATE Logged in User's Info too
            $logged_user = $user->getDataFromDatabase($_SESSION['logged_user_id']);
            $_SESSION['logged_user_password'] = $logged_user['password'];
          }
        }else{
          if($_SESSION['new_password_same']){
            $_SESSION['user_profile_update_success']="Some DATA Changes has been Saved";
            //  UPDATE Logged in User's Info too
            $logged_user = $user->getDataFromDatabase($_SESSION['logged_user_id']);
            $_SESSION['logged_user_name'] = $logged_user['name'];
            $_SESSION['logged_user_username'] = $logged_user['username'];
            $_SESSION['logged_user_cell'] = $logged_user['cell'];
            $_SESSION['logged_user_email'] = $logged_user['email'];
          }else{
            $_SESSION['user_profile_update_success']="All DATA Changes has been Updated Successfully";
            //  UPDATE Logged in User's Info too
            $logged_user = $user->getDataFromDatabase($_SESSION['logged_user_id']);
            $_SESSION['logged_user_name'] = $logged_user['name'];
            $_SESSION['logged_user_username'] = $logged_user['username'];
            $_SESSION['logged_user_cell'] = $logged_user['cell'];
            $_SESSION['logged_user_email'] = $logged_user['email'];
            $_SESSION['logged_user_password'] = $logged_user['password'];
          }
        }
      }

    }
  }

?>
<!doctype html>
<html lang="en">

<head>
        <meta charset="utf-8" />
        <title>Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/backend/images/favicon.ico">

        <!-- App css -->
        <link href="../assets/backend/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/backend/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="../assets/backend/css/metismenu.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/backend/css/style.css" rel="stylesheet" type="text/css" />



    </head>


    <body>

        <!-- Begin page -->
        <div id="wrapper">

          <!-- ========== Left Sidebar Start ========== -->
          <?php include_once "templates/menu.php"; ?>
          <!-- ========== Left Sidebar End ========== -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->

            <div class="content-page">

                <!-- Top Bar Start -->
                <?php include_once "templates/topbar.php" ?>
                <!-- Top Bar End -->


                <div class="content">
