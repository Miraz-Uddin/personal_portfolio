<?php
  include_once "templates/header.php";
?>

<!-- Start Page content -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
          <li class="breadcrumb-item active">User</li>
        </ol>
      </div>
    </div>
    <div class="row">

        <?php if($_SESSION['logged_user_role'] != 'Admin'){?>
          <div class="col-md-6 mr-auto">
        <?php }else{ ?>
            <div class="col-12">
          <?php } ?>
        <div class="card shadow">
          <?php if($_SESSION['logged_user_role'] != 'Admin'){}
            else{ ?>
          <div class="card-header">
            <h3 class="text-center">ALL USERS</h3>
          </div>
        <?php } ?>
          <div class="card-body">
            <div id="user_moved_to_trash_message"></div>
            <?php if($_SESSION['logged_user_role'] != 'Admin'){ ?>
              <h2 class="text-danger">ACCESS DENIED</h2>
              <p>Did You Know ? There are 8 billion people in the world but only few of them have privilege to access this page.</p>
              <p>Unfortunately, You are not one of them.</p>
              <p>If you think you should have the privilege to access this page, please contact with the administrator.</p>
            <?php }else{ ?>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Cell</th>
                  <th>Role</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody id="all_students_information"></tbody>
            </table>
            <?php } ?>
          </div>
          <?php
            if($_SESSION['logged_user_role'] != 'Admin'){}
            else{ ?>
          <div class="card-footer">
            <a href="user_add.php" class="card-link">Create New User</a>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Single User Data Change Modal Preview -->
  <div id="user_data_change_modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="card">
          <div class="card-header">
            <h4>Edit a USER</h4>
          </div>
          <div class="card-body">
            <div id="user_data_change_modal_form_response_message"></div>
            <form id="user_data_change_modal_form">
              <input type="hidden" class="form-control" name="id">
              <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Name</span>
                  </div>
                  <input type="text" class="form-control" name="name">
              </div>
              <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Username</span>
                  </div>
                  <input type="text" class="form-control" name="username">
              </div>
              <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Email</span>
                  </div>
                  <input type="text" class="form-control" name="email">
              </div>
              <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Cell</span>
                  </div>
                  <input type="text" class="form-control" name="cell">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text">Role</label>
                </div>
                <select class="custom-select" name="role">
                  <option value="Admin">Admin</option>
                  <option value="Editor">Editor</option>
                </select>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text">Status</label>
                </div>
                <select class="custom-select" name="status">
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
              </div>
              <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">New Password</span>
                  </div>
                  <input type="password" class="form-control" name="password">
                  <div class="input-group-append">
                    <span class="input-group-text text-warning">Optional</span>
                  </div>
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-primary btn-sm form-control" value="Update">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Single User Data View Modal Preview -->
  <div id="user_data_show_modal" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content p-4">
        <!-- <div class="modal-head">
          <h3 class="text-center">Information of <span id="user_data_show_modal_username"></span> </h3>
        </div> -->
        <div class="modal-body">
          <table class="table border-0">
            <tr class="d-flex">
              <td class="col-3 border-0">
                <img id="user_data_show_modal_img" class="w-100 d-block mx-auto mt-4 img-thumbnail img-fluid" src="../assets/uploaded_images/users/default_photo.jpg" alt="">
              </td>
              <td class="col-9 border-0">
                <table class="table border-0">
                  <tr class="d-flex">
                    <th class="col-3 border-0">Registration ID</th>
                    <th class="col-1 border-0">:</th>
                    <td id="user_data_show_modal_id" class="col-8 border-0"></td>
                  </tr>
                  <tr class="d-flex">
                    <th class="col-3 border-0">Name</th>
                    <th class="col-1 border-0">:</th>
                    <td id="user_data_show_modal_name" class="col-8 border-0"></td>
                  </tr>
                  <tr class="d-flex">
                    <th class="col-3 border-0">E - Mail</th>
                    <th class="col-1 border-0">:</th>
                    <td id="user_data_show_modal_email" class="col-8 border-0"></td>
                  </tr>
                  <tr class="d-flex">
                    <th class="col-3 border-0">Cell</th>
                    <th class="col-1 border-0">:</th>
                    <td id="user_data_show_modal_cell" class="col-8 border-0"></td>
                  </tr>
                  <tr class="d-flex">
                    <th class="col-3 border-0">Registered</th>
                    <th class="col-1 border-0">:</th>
                    <td id="user_data_show_modal_created_at" class="col-8 border-0"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

<?php include_once "templates/footer.php" ?>
