<div class="topbar">

    <nav class="navbar-custom">

        <ul class="list-unstyled topbar-right-menu float-right mb-0">

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <img src="../assets/uploaded_images/users/<?=$_SESSION['logged_user_photo']?>" alt="user" class="rounded-circle"> <span class="ml-1"><?=$_SESSION['logged_user_name']?><i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="user_profile.php" class="dropdown-item notify-item">
                        <i class="fi-head"></i> <span>My Profile</span>
                    </a>

                    <!-- item-->
                    <a href="settings.php" class="dropdown-item notify-item">
                        <i class="fi-cog"></i> <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="?logout=success" class="dropdown-item notify-item">
                        <i class="fi-power"></i> <span>Logout</span>
                    </a>

                </div>
            </li>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left disable-btn">
                    <i class="dripicons-menu"></i>
                </button>
            </li>
            <li>
                <div class="page-title-box">
                    <h4 class="page-title"><?=$_SESSION['logged_user_role']?> Panel </h4>
                </div>
            </li>

        </ul>

    </nav>

</div>
