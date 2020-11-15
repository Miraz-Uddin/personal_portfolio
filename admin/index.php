<?php
session_start();
require_once "../vendor/autoload.php";

//  Create Instant of Auth Class
use App\Support\Auth;
$auth = new Auth;

//  Page Security
if(!empty($_SESSION['logged_user_id']) AND !empty($_SESSION['logged_user_role']) AND !empty($_SESSION['logged_user_name']) AND !empty($_SESSION['logged_user_username']) AND !empty($_SESSION['logged_user_cell']) AND !empty($_SESSION['logged_user_email']) AND !empty($_SESSION['logged_user_password'])){
   header('location:dashboard.php');
}
?>

<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8" />
  <title>Personal_portfolio Admin</title>
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

  <script src="../assets/backend/js/modernizr.min.js"></script>

</head>


<body class="account-pages">

  <!-- Begin page -->
  <div class="accountbg" style="background: url('../assets/backend/images/bg-1.jpg');background-size: cover;background-position: center;"></div>

  <div class="wrapper-page account-page-full">
    <?php

    if(isset($_POST['login'])){

      //  Value Get
      $user_info = $_POST['user_info'];
      $pass = $_POST['pass'];

      // Login Data Check
      if( empty($user_info) ){
        $_SESSION['user_info_blank_error'] = "Please Give a Username / Email / Cell Number";
      }elseif( empty($pass) ){
        $_SESSION['pass_blank_error'] = "Please Give Password Here";
      }else{
        $mess = $auth->userLogIn($user_info,$pass);
        if($mess['status']=='Success'){
          header('location:dashboard.php');
        }else{
          if($mess['status']=='Error_info'){
            $_SESSION['login_error_info'] = $mess['message'];
          }else{
            $_SESSION['login_error'] = $mess['message'];
          }
        }
      }
    }

    ?>

    <div class="card">
      <div class="card-block">
        <div class="account-box">
          <div class="card-box p-5">
            <?php if( isset($_SESSION['login_error']) ){ ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?php echo $_SESSION['login_error']; ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php
              }
              unset($_SESSION['login_error']);
            ?>

              <h2 class="text-uppercase text-center pb-4">
                  <a href="index.html" class="text-success">
                    <span><img src="../assets/backend/images/logo.png" alt="" height="26"></span>
                  </a>
              </h2>
              <form method="POST">
                <div class="form-group m-b-20 row">
                  <div class="col-12">
                    <label for="emailaddress">E-mail Address / username / Contact number</label>
                    <input class="form-control" type="text" name="user_info" id="emailaddress" placeholder="email / username / cell">
                    <?php if(isset($_SESSION['user_info_blank_error'])){ ?>
                      <p class="small text-danger"><?php echo $_SESSION['user_info_blank_error']; ?></p>
                    <?php
                      }
                      unset($_SESSION['user_info_blank_error']);
                    ?>
                  </div>
                </div>

                <div class="form-group row m-b-20">
                  <div class="col-12">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="pass" id="password" placeholder="Enter your password here">
                    <?php if(isset($_SESSION['pass_blank_error'])){ ?>
                      <p class="small text-danger"><?php echo $_SESSION['pass_blank_error']; ?></p>
                    <?php
                      }
                      unset($_SESSION['pass_blank_error']);
                    ?>
                    <?php if(isset($_SESSION['login_error_info'])){ ?>
                      <p class="small text-info"><?php echo $_SESSION['login_error_info']; ?></p>
                    <?php
                      }
                      unset($_SESSION['login_error_info']);
                    ?>
                  </div>
                </div>

                <div class="form-group row text-center m-t-10">
                  <div class="col-12">
                    <button class="btn btn-block btn-custom waves-effect waves-light" type="submit" name="login">Sign In</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- jQuery  -->
    <script src="../assets/backend/js/jquery.min.js"></script>
    <script src="../assets/backend/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/backend/js/metisMenu.min.js"></script>
    <script src="../assets/backend/js/waves.js"></script>
    <script src="../assets/backend/js/jquery.slimscroll.js"></script>

    <!-- App js -->
    <script src="../assets/backend/js/jquery.core.js"></script>
    <script src="../assets/backend/js/jquery.app.js"></script>

  </body>

</html>
