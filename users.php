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
                <p class="display-4">All user</p>
            </div>
            <button class="btn btn-success"><a class="text-white" href="add_user.php">add user</a></button>
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
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
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

            $user_query_count = "SELECT * FROM users";
            $do_count = mysqli_query($connection, $user_query_count);
            $count = mysqli_num_rows($do_count);
            $count = ceil($count / $per_page);

            $query = "SELECT * FROM users ORDER BY username LIMIT $page_1, $per_page";
            $sel_users = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($sel_users)) {
                $user_id = $row['user_id'];
                $username = $row['username'];
                $user_email = $row['user_email'];

                echo"<tr>";
                echo"<td>{$user_id}</td>";
                echo"<td>{$username}</td>";
                echo"<td>{$user_email}</td>";
                echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a>";
                if (!($_SESSION['user_id']==$user_id)){
                echo"<a href='users.php?delete={$user_id}'>Delete</a></td>";
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
        echo "<li class='paginate_button page-item active'><a class='page-link active' href='users.php?page={$i}'>{$i}</a>";
        } else {
        echo "<li class='paginate_button page-item'><a class='page-link' href='users.php?page={$i}'>{$i}</a>";
       
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
    $log_action="user deleted";
    $the_user_id = mysqli_real_escape_string($connection,$_GET['delete']);

    $query = "DELETE FROM users where user_id = {$the_user_id} ";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 
    $del_user_query = mysqli_query($connection, $query);
    header('Location: '.$_SERVER['PHP_SELF']);
    die;

}

?>
<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>