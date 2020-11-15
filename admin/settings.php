<?php include_once "templates/header.php"; ?>

<!-- Start Page content -->
  <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="user_profile.php">Profile</a></li>
              <li class="breadcrumb-item active">Settings</li>
          </ol>
        </div>
      </div>
      <div class="row">
          <div class="col-12">

            <div class="card-box">
                <?php if(isset($_SESSION['user_profile_update_info'])){ ?>
                  <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong><?php echo $_SESSION['user_profile_update_info']; ?></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php
                  }
                  unset($_SESSION['user_profile_update_info']);
                ?>
                <?php if(isset($_SESSION['user_profile_update_success'])){ ?>
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?php echo $_SESSION['user_profile_update_success']; ?></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php
                  }
                  unset($_SESSION['user_profile_update_success']);
                ?>
                <form method="post">
                  <div class="row">
                    <div class="col-6">
                      <div class="row">
                        <div class="col-6">
                          <input type="hidden" name="id" value="<?=$_SESSION['logged_user_id']?>">
                          <div class="form-group">
                              <label for="edit_settings_name"><h6>Name</h6> </label>
                              <input id="edit_settings_name" class="form-control" type="text" name="name" value="<?=$_SESSION['logged_user_name']?>">

                              <!-- Show Errors if have Any At Name Field -->
                              <?php if(isset($_SESSION['user_edit_name_error'])){?>
                                <p class="small text-danger"><?=$_SESSION['user_edit_name_error']?></p>
                              <?php } unset($_SESSION['user_edit_name_error']); ?>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                              <label for="edit_settings_username"><h6>Username (Unique, if change)</h6> </label>
                              <input id="edit_settings_username" class="form-control" type="text" name="username" value="<?=$_SESSION['logged_user_username']?>">

                              <!-- Show Errors if have Any At Username Field -->
                              <?php if(isset($_SESSION['user_edit_username_error'])){?>
                                <p class="small text-danger"><?=$_SESSION['user_edit_username_error']?></p>
                              <?php } unset($_SESSION['user_edit_username_error']); ?>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                          <label for="edit_settings_cell"><h6>Cell (Unique, if change)</h6> </label>
                          <input id="edit_settings_cell" class="form-control" type="text" name="cell" value="<?=$_SESSION['logged_user_cell']?>">

                          <!-- Show Errors if have Any At Contact Details Field -->
                          <?php if(isset($_SESSION['user_edit_cell_error'])){?>
                            <p class="small text-danger"><?=$_SESSION['user_edit_cell_error']?></p>
                          <?php } unset($_SESSION['user_edit_cell_error']); ?>
                      </div>

                      <div class="form-group">
                          <label for="edit_settings_email"><h6>Email (Unique, if change)</h6> </label>
                          <input id="edit_settings_email" class="form-control" type="text" name="email" value="<?=$_SESSION['logged_user_email']?>">

                          <!-- Show Errors if have Any At Email Address Field -->
                          <?php if(isset($_SESSION['user_edit_email_error'])){?>
                            <p class="small text-danger"><?=$_SESSION['user_edit_email_error']?></p>
                          <?php } unset($_SESSION['user_edit_email_error']); ?>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                          <label for="user_edit_new_pass"><h6>New Password (Optional)</h6> </label>
                          <input id="user_edit_new_pass" class="form-control" type="password" name="new_pass">

                          <!-- Show Errors if have Any At New Password Field -->
                          <?php if(isset($_SESSION['user_edit_new_pass_error'])){?>
                            <p class="small text-danger"><?=$_SESSION['user_edit_new_pass_error']?></p>
                          <?php } unset($_SESSION['user_edit_new_pass_error']); ?>

                      </div>
                      <div class="form-group">
                          <label for="user_edit_new_pass_confirm"><h6>Confirm New Password (Optional)</h6> </label>
                          <input id="user_edit_new_pass_confirm" class="form-control" type="password" name="new_pass_confirm">

                          <!-- Show Errors if have Any At Confirm New Password Field -->
                          <?php if(isset($_SESSION['user_edit_new_pass_confirm_error'])){?>
                            <p class="small text-danger"><?=$_SESSION['user_edit_new_pass_confirm_error']?></p>
                          <?php } unset($_SESSION['user_edit_new_pass_confirm_error']); ?>

                      </div>
                      <div class="form-group">
                          <label for="edit_settings_old_pass"><h6>Old Password **</h6> </label>
                          <input id="edit_settings_old_pass" class="form-control" type="password" name="old_pass">

                          <!-- Show Errors if have Any At Old Password Field -->
                          <?php if(isset($_SESSION['user_edit_old_pass_error'])){?>
                            <p class="small text-danger"><?=$_SESSION['user_edit_old_pass_error']?></p>
                          <?php } unset($_SESSION['user_edit_old_pass_error']); ?>

                      </div>
                    </div>

                  </div>

                  <div class="row">
                    <div class="col-8">
                      <p class="small mb-0">** If You want to <span class="text-info font-weight-bold">UPDATE</span> anything You must have to fill the Old Password</p>
                      <p class="small">*** If You <span class="text-danger font-weight-bold">DON'T</span> want to <span class="text-info font-weight-bold">UPDATE</span> Password, Keep New & Confirm New Password Blank</p>
                    </div>
                    <div class="col-2">
                      <div class="form-group">
                          <button class="btn btn-block btn-primary" type="submit" name="update_settings">Update</button>
                      </div>
                    </div>
                    <div class="col-2">
                      <div class="form-group">
                          <a href="dashboard.php" class="btn btn-block btn-outline-dark waves-effect waves-light">Cancel</a>
                      </div>
                    </div>
                  </div>
                </form>
            </div>

          </div>
      </div>
  </div> <!-- container -->
<!-- End Page content -->




<?php include_once "templates/footer.php" ?>
