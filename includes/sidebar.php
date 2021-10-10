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
        <span class="brand-text font-weight-light">AdminLTE 3</span>
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
        <li class="nav-item menu-open">
        <a href="index.php" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
        </a>
        </li>

        <li class="nav-item">
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
                <li class="nav-item">
                <a href="./add_staff.php" class="nav-link">
                    <i class="fas fa-chevron-right nav-icon"></i>
                    <p>Add Staff</p>
                </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon far fa-building"></i>
                <p>
                Departments
                <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="departments.php" class="nav-link">
                    <i class="fas fa-chevron-right nav-icon"></i>
                    <p>Department Lists</p>
                </a>
                </li>
                <li class="nav-item">
                <a href="add_department.php" class="nav-link">
                    <i class="fas fa-chevron-right nav-icon"></i>
                    <p>Add Department</p>
                </a>
                </li>
            </ul>
        </li>
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
            <a href="contacts.php" class="nav-link">
                <i class="fas fa-chevron-right nav-icon"></i>
                <p>Report Lists</p>
            </a>
            </li>
            <li class="nav-item">
            <a href="add_contact.php" class="nav-link">
                <i class="fas fa-chevron-right nav-icon"></i>
                <p>Self Appraisal</p>
            </a>
            </li>
            <li class="nav-item">
            <a href="add_contact.php" class="nav-link">
                <i class="fas fa-chevron-right nav-icon"></i>
                <p>Peer Appraisal</p>
            </a>
            </li>
            <li class="nav-item">
            <a href="add_contact.php" class="nav-link">
                <i class="fas fa-chevron-right nav-icon"></i>
                <p>Manager Appraisal</p>
            </a>
            </li>
        </ul>
        </li>
        <li class="nav-item">
        <a href="logs.php" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Logs</p>
        </a>
        </li>
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
