
 <div class="left side-menu">

    <div class="slimscroll-menu" id="remove-scroll">

        <!-- LOGO -->
        <div class="topbar-left">
            <a href="index.html" class="logo">
                <span>
                    <img src="../assets/backend/images/logo.png" alt="" height="22">
                </span>
                <i>
                    <img src="../assets/backend/images/logo_sm.png" alt="" height="28">
                </i>
            </a>
        </div>

        <!-- User box -->
        <div class="user-box">
            <div class="user-img">
                <img src="../assets/uploaded_images/users/<?=$_SESSION['logged_user_photo']?>" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
            </div>
            <h5><a href="#"><?=$_SESSION['logged_user_name']?></a> </h5>
            <p class="text-muted"><?=$_SESSION['logged_user_email']?></p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li>
                    <a href="dashboard.php">
                        <i class="fi-air-play"></i> <span> Dashboard </span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);"><i class="dripicons-user"></i> <span> User </span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="user_add.php">ADD New</a></li>
                        <li><a href="user_all.php">View All Users</a></li>
                        <li><a href="user_trash.php">Deleted Users</a></li>
                    </ul>
                </li>

                <li class="menu-title">Navigation</li>
                <!-- <li> <a href="javascript: void(0);"><i class="dripicons-user"></i> <span>  </span></a></li> -->
                <li> <a href="javascript: void(0);"><i class="icon-menu"></i><span> Menu </span></a></li>
                <li> <a href="javascript: void(0);"><i class="fi-box"></i><span> Banner </span></a></li>
                <li> <a href="javascript: void(0);"><i class="fi-paper"></i> <span> About-Intro </span></a></li>
                <li> <a href="javascript: void(0);"><i class="fi-paper"></i> <span> About-Education </span></a> </li>
                <li> <a href="javascript: void(0);"><i class="icon-wrench"></i> <span> Service </span></a></li>
                <li> <a href="javascript: void(0);"><i class="fi-briefcase"></i> <span> Portfolio </span></a></li>
                <li> <a href="javascript: void(0);"><i class="dripicons-stopwatch"></i> <span> Counter </span></a></li>
                <li> <a href="javascript: void(0);"><i class="dripicons-trophy"></i> <span> Testimonial </span></a></li>
                <li> <a href="javascript: void(0);"><i class="icon-anchor"></i> <span> Client </span></a></li>
                <li> <a href="javascript: void(0);"><i class="icon-phone"></i> <span> Contact </span></a></li>
                <li> <a href="javascript: void(0);"><i class="dripicons-checklist"></i> <span> Footer </span></a></li>

            </ul>

        </div>
        <!-- Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
