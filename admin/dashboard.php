<?php include_once "templates/header.php"; ?>

<!-- Start Page content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <ol class="breadcrumb">
          <li class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></li>
      </ol>
    </div>
  </div>
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="header-title mb-4">Welcome to <span class="text-primary"><?=$_SESSION['logged_user_role']?></span> Dashboard</h4>
            </div>
        </div>
    </div>
</div>
<!-- End Page content -->

<?php include_once "templates/footer.php" ?>
