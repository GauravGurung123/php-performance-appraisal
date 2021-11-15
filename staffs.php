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
                <?php include("includes/modal_delete.php"); ?>
            </div>
            
            <?php if (checkPermission()): ?>
            
            
            <button id="button">Add staff</button>
            <style>
                #newpost { display: none; }
            </style>
            <script>
             $("#button").click(function() { 
                // assumes element with id='button'
                $("#newpost").toggle('slow');
            });
            </script>
            <?php include "add_staff.php"; ?>
            <?php endif; ?>
<?php
if(isset($_GET['source'])) {
    $source = $_GET['source']; 
} else {
    $source = '';
}
switch($source) {  
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
                    <input type="text" name="table_search" id="myInput" onkeyup="searchFun()"
                    class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                    </div>
                </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body" style="overflow: scroll">
                <table id="myTable" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <style>
                        th{
                        background-color: #f8f9fa;
                        }
                    </style>
                    <th>S/N</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Department</th>
                    <th>Designation</th>
            <?php if (checkPermission()): ?>
                    <th>Role</th>
                    <th>Action</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
        <?php
            $per_page = 8;
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

            $query = "SELECT * FROM staffs WHERE role_id <> '1' ORDER BY name LIMIT $page_1, $per_page";
            $sel_staffs = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($sel_staffs)) {
                $id = $row['id'];
                $role_id = $row['role_id'];
                $dept_id = $row['dept_id'];
                global $sid;
                ++$sid;
                $username = $row['username'];
                $name = ucwords($row['name']);
                $designation = ucfirst($row['designation']);
                
                $query_role = "SELECT * FROM roles WHERE id='$role_id'";
                $sel_role = mysqli_query($connection, $query_role);
                if($rows = mysqli_fetch_assoc($sel_role)){
                    $roleName = ucwords($rows['name']);
                }
                $query_dept = "SELECT * FROM departments WHERE id='$dept_id'";
                $sel_dept = mysqli_query($connection, $query_dept);
                if($rows = mysqli_fetch_assoc($sel_dept)){
                    $deptName = ucwords($rows['name']);
                }
                ?><tr class="<?php if($roleName=='Admin') echo "bg-info";  ?>"><?php
                echo"<td>{$sid}</td>";
                echo"<td>{$username}</td>";
                echo"<td>{$name}</td>";
                echo"<td>{$deptName}</td>";
                echo"<td>{$designation}</td>";
            if (checkPermission()){
                echo"<td>{$roleName}</td>";
                if(!(is_admin($_SESSION['role_id']) && ($roleName=='Admin'))){
                    echo "<td style='background-color: #fff;'><a class='bg-primary p-1' href='staffs.php?source=edit_user&edit_user={$id}'>Edit</a>";
                    if (!($_SESSION['id']==$id)){
                    // echo"&nbsp; <a class='bg-danger p-1' href='staffs.php?delete={$id}'>Delete</a></td>";
                    echo"&nbsp; <a rel='$id' class='del_link bg-danger p-1' href='javascript:void(0)'>Remove</a></td>";
                    }
                }else {
                    echo "<td class='bg-info'>N/A</td>";
                } 
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
    $the_id = mysqli_real_escape_string($connection,$_GET['delete']);

    $query = "DELETE FROM staffs where id = {$the_id} ";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 
    $del_query = mysqli_query($connection, $query);
    header('Location: '.$_SERVER['PHP_SELF']);
    die;

}

?>
<script>
    $(document).ready(function(){
        $(".del_link").on('click', function(){
            var delId = $(this).attr("rel");
            var delUrl = "staffs.php?delete="+ delId +" ";

            $(".modal_del_link").attr("href", delUrl);

            $("#modal-sm").modal('show');
           
        });
    });

    const searchFun = ()=>{
        let filter = document.getElementById('myInput').value.toUpperCase();
        let myTable = document.getElementById('myTable');
        let tr = myTable.getElementsByTagName('tr');

        for(var ite=0; ite<tr.length; ite++){
            let td = tr[ite].getElementsByTagName('td')[1];
            let td2 = tr[ite].getElementsByTagName('td')[2];
            let td3 = tr[ite].getElementsByTagName('td')[3];

            if(td || td2 || td3) {
                let textvalue = td.textContent || td.innerHTML;
                let textvalue2 = td2.textContent || td2.innerHTML;
                let textvalue3 = td3.textContent || td3.innerHTML;
                if((textvalue.toUpperCase().indexOf(filter) > -1) || (textvalue2.toUpperCase().indexOf(filter) > -1) || (textvalue3.toUpperCase().indexOf(filter) > -1)){
                    tr[ite].style.display ="";
                }else {
                    tr[ite].style.display = "none"
                }
            }
        }
    }

</script>
<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>