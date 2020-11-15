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
          <li class="breadcrumb-item active">Deleted Users</li>
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
            <h3 class="text-center">ALL Deleted USERS</h3>
          </div>
        <?php } ?>
          <div class="card-body">
            <div id="user_restore_message"></div>
            <div id="user_delete_message"></div>
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
              <tbody id="all_deleted_students_information"></tbody>
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

<?php include_once "templates/footer.php" ?>
