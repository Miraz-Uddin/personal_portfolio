<?php
    include_once "templates/header.php";
?>

<!-- Start Page content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="user_all.php">User</a></li>
          <li class="breadcrumb-item active">Add New User</li>
      </ol>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 mr-auto">
      <div class="card shadow">
        <?php if($_SESSION['logged_user_role'] != 'Admin'){}
          else{ ?>
            <div class="card-header">
              <h3>ADD New User</h3>
            </div>
          <?php } ?>
        <div class="card-body">
          <?php if(isset($_SESSION['user_create_success'])){ ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong><?=$_SESSION['user_create_success'];?></strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php
            }
            unset($_SESSION['user_create_success']);
          ?>
          <?php if($_SESSION['logged_user_role'] != 'Admin'){ ?>
            <h2 class="text-danger">ACCESS DENIED</h2>
            <p>Did You Know ? There are 8 billion people in the world but only few of them have privilege to access this page.</p>
            <p>Unfortunately, You are not one of them.</p>
            <p>If you think you should have the privilege to access this page, please contact with the administrator.</p>
          <?php }else{ ?>
          <form method="post">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Username</span>
              </div>
              <input type="text" class="form-control" placeholder="Give a Username" name="username">
            </div>
            <!-- Show Errors if have Any At Username Field -->
            <?php if(isset($_SESSION['user_create_username_error'])){?>
            <p class="small text-danger"><?=$_SESSION['user_create_username_error']?></p>
            <?php } unset($_SESSION['user_create_username_error']); ?>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Email</span>
              </div>
              <input type="text" class="form-control" placeholder="Enter Valid Email Id" name="email">
            </div>
            <!-- Show Errors if have Any At Email Field -->
            <?php if(isset($_SESSION['user_create_email_error'])){?>
            <p class="small text-danger"><?=$_SESSION['user_create_email_error']?></p>
            <?php } unset($_SESSION['user_create_email_error']); ?>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Cell</span>
              </div>
              <input type="text" class="form-control" placeholder="Contact Number" name="cell">
            </div>
            <!-- Show Errors if have Any At Contact Details Field -->
            <?php if(isset($_SESSION['user_create_cell_error'])){?>
              <p class="small text-danger"><?=$_SESSION['user_create_cell_error']?></p>
            <?php } unset($_SESSION['user_create_cell_error']); ?>

            <div class="form-group">
              <button type="submit" class="btn btn-success btn-sm" name="create_user">Create</button>
            </div>
          </form>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once "templates/footer.php" ?>
