<?php include_once "templates/header.php"; ?>

<!-- Start Page content -->
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-7">
                              <table class="table table-bordered">
                                <tr>
                                    <th>Registration ID</th>
                                    <td><?=$_SESSION['logged_user_id']?></td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td><?=$_SESSION['logged_user_name']?></td>
                                </tr>
                                <tr>
                                    <th>Contact Number</th>
                                    <td><?=$_SESSION['logged_user_cell']?></td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td><?=$_SESSION['logged_user_username']?></td>
                                </tr>
                                <tr>
                                    <th>E-Mail Address</th>
                                    <td><?=$_SESSION['logged_user_email']?></td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td><?=$_SESSION['logged_user_role']?></td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td><?php
                                    $date = strtotime($_SESSION['logged_user_created_at']);
                                    echo date('l, jS \of F Y, h:i A', $date);
                                    ?></td>
                                </tr>
                              </table>
                            </div>
                            <div class="col-5">
                              <?php if(isset($_SESSION['user_photo_update_status'])){ ?>
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                  <strong><?=$_SESSION['user_photo_update_status']?></strong>
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                              <?php } unset($_SESSION['user_photo_update_status']);?>
                              <div class="card d-block mx-auto user_profile_image" style="width: 250px;height;250px;" >
                                <div class="card-body p-0">
                                  <img id="user_photo_upload" class="img-fluid img-thumbnail w-100" src="../assets/uploaded_images/users/<?=$_SESSION['logged_user_photo']?>" alt="">
                                </div>
                                <label for="user_photo" class="d-block mb-0">
                                  <div class="user_profile_image_over">
                                    <p class="lead text-white font-weight-bold">Click to Edit</p>
                                  </div>
                                </label>
                              </div>
                              <form method="post" enctype="multipart/form-data">
                                <input style="display:none;" type="file" name="change_photo" id="user_photo">
                                <button type="submit" class="btn btn-success btn-sm d-block mx-auto mt-3" name="user_photo_update_btn">Click to Update Photo</button>
                              </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php include_once "templates/footer.php" ?>
