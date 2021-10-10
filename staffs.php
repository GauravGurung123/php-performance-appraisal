<?php include_once "includes/header.php" ?>
<?php if(isLoggedIn()): ?>

<!-- Navigation -->
<?php include_once "includes/nav.php" ?>
<!-- /.Navigation -->
<!-- Sidebar -->
<?php include_once "includes/sidebar.php" ?>
<!-- /.sidebar -->


<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
            <div class="row">
                <p class="display-4">All staffs</p>
            </div>
            <button class="btn btn-success"><a class="text-white" href="add_staff.php">add staff</a></button>
            <?php
if(isset($_GET['source'])) {
    $source = $_GET['source']; 
} else {
    $source = '';
}
switch($source) {  
    // case 'add_user';
    // include "includes/add_user.php";
    // break;
    case 'edit_user';
    include "includes/edit_user.php";
    break;
    case '200';
    echo "nice 200";
    break;
    default:
    // include "users.php";
    break;
}

?>
            <!-- /.row -->
        <div class="row mt-2">
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Show 
    <select name="page_no" id="">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select> Entries
</h3> 

                <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                    </div>
                </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Designation</th>
                </tr>
                </thead>
                <tbody>
        <?php
            $per_page = 4;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else { $page = ""; }

            if ($page == "" || $page == 1) {
                $page_1 = 0;
            } else {
                $page_1 = ($page * $per_page) - $per_page;
            }

            $user_query_count = "SELECT * FROM staffs";
            $do_count = mysqli_query($connection, $user_query_count);
            $count = mysqli_num_rows($do_count);
            $count = ceil($count / $per_page);

            $query = "SELECT * FROM departments ORDER BY staff_name LIMIT $page_1, $per_page";
            $sel_departments = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($sel_departments)) {
                $staff_id = $row['staff_id'];
                $staff_username = $row['staff_username'];
                $staff_name = $row['staff_name'];
                $staff_designation = $row['staff_designation'];

                echo"<tr>";
                echo"<td>{$staff_id}</td>";
                echo"<td>{$staff_username}</td>";
                echo"<td>{$staff_name}</td>";
                echo"<td>{$staff_designation}</td>";
                echo "<td><a href='users.php?source=edit_user&edit_user={$staff_id}'>Edit</a>";
                if (!($_SESSION['staff_id']==$staff_id)){
                echo"<a href='staffs.php?delete={$staff_id}'>Delete</a></td>";
                }
                echo"</tr>";
        }
        ?>
                
                </table>
                <div class="row mt-3">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                    Showing 1 to 4 of 15 entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">

                                    <ul class="pagination">

<?php
    for ($i=1; $i<=$count; $i++) {
        if ($i == $page ){
        echo "<li class='paginate_button page-item active'><a class='page-link active' href='staffs.php?page={$i}'>{$i}</a>";
        } else {
        echo "<li class='paginate_button page-item'><a class='page-link' href='staffs.php?page={$i}'>{$i}</a>";
       
        }
    }
?>
  </ul>
                                </div>
                            </div>
                        </div> 
<!-- ./row mt-3 -->


            </div>
            <!-- /.card-body -->
        </div>
        </div>
        <!-- /.card -->
        </div>
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->


        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

<?php include "includes/footer.php" ?>
<?php
//delete users query
if(isset($_GET['delete'])) {
    $log_action="staff deleted";
    $the_staff_id = mysqli_real_escape_string($connection,$_GET['delete']);

    $query = "DELETE FROM staffs where staff_id = {$the_staff_id} ";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 
    $del_staff_query = mysqli_query($connection, $query);
    header('Location: '.$_SERVER['PHP_SELF']);
    die;

}

?>
<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>