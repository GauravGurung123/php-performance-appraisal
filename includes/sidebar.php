 <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index.php" class="brand-link">
        <img
            src="dist/img/AdminLTELogo.png"
            alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: 0.8"
        />
        <span class="brand-text font-weight-light">Dashboard</span>
        </a>
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
    <ul
        class="nav nav-pills nav-sidebar flex-column"
        data-widget="treeview"
        role="menu"
        data-accordion="false"
    >
        <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
        <li class="nav-item">
        <a href="staffs.php" class="nav-link">
            <i class="nav-icon far fa-user"></i>
            <p>Staffs</p>
        </a>
        </li>
<!-- 
        <li class="nav-item" >
            <a href="#" class="nav-link">
                <i class="nav-icon far fa-user"></i>
                <p>
                Staffs
                <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="staffs.php" class="nav-link">
                    <i class="fas fa-chevron-right nav-icon"></i>
                    <p>Staff Lists</p>
                </a>
                </li>
                <?php if (is_superadmin($_SESSION['role_id']) || is_admin($_SESSION['role_id'])): ?>
                <li class="nav-item">
                <a href="./add_staff.php" class="nav-link">
                    <i class="fas fa-chevron-right nav-icon"></i>
                    <p>Add Staff</p>
                </a>
                </li>
                <?php endif; ?>
            </ul>
        </li> -->
        <li class="nav-item">
        <a href="departments.php" class="nav-link">
            <i class="nav-icon far fa-building"></i>
            <p>Departments</p>
        </a>
        </li>
                <?php if (checkPermission()): ?>
                <!-- <li class="nav-item">
                <a href="add_department.php" class="nav-link">
                    <i class="fas fa-chevron-right nav-icon"></i>
                    <p>Add Department</p>
                </a>
                </li> -->
                <?php endif ?>
            
        <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-drafting-compass"></i>
            <p>
            Evaluation
            <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
            <a href="reports.php" class="nav-link">
                <i class="fas fa-chevron-right nav-icon"></i>
                <p>Report Lists</p>
            </a>
            </li>
            
            <li class="nav-item">
            <a href="peer_appraisal.php" class="nav-link">
                <i class="fas fa-chevron-right nav-icon"></i>
                <p>Performance Appraisal</p>
            </a>
            </li>
            <?php if (checkPermission()): ?>
            <li class="nav-item">
            <a href="config1.php" class="nav-link">
                <i class="fas fa-chevron-right nav-icon"></i>
                <p>Config</p>
            </a>
            </li>
            <?php endif ?>
        </ul>
        </li>
        <?php if (checkPermission()): ?>
        <li class="nav-item">
        <a href="logs.php" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Logs</p>
        </a>
        </li>
        <?php endif ?>
        <li class="nav-item">
        <a href="includes/logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
        </a>
        </li>
    </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
</aside>
