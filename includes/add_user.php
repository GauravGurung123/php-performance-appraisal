<?php include_once "includes/header.php" ?>
<!-- Navigation -->
<?php include_once "includes/nav.php" ?>
<!-- /.Navigation -->
<!-- Sidebar -->
<?php include_once "includes/sidebar.php" ?>
<!-- /.sidebar -->  

<?php
if(isset($_POST['create_user'])){
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
  
   
    $query = "insert into users(username, user_email, user_password)";
    $query .= "values({$_SESSION['user_id']}, '{$contact_no}','$contact_document')";

    $log_action="Contact added";
    create_log($_SESSION['username'], $_SESSION['user_id'], $log_action);
    $create_contact_query = mysqli_query($connection, $query);
    confirm($create_contact_query);
    
}
?>


<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
<!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
            <div class="row text-center mb-2">
            <p class="display-4">Welcome Admin</p>
            </div>
            <!-- /.row -->
            <form>
                <div class="card-body">
                    <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    
                </div>
                    <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" name="create_user" class="btn btn-primary">Submit</button>
                </div>
            </form>

            </div>
        <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

    </div>
<!-- /.content-wrapper -->
<script>
function check_pass() {
    if (document.getElementById('password').value ==
            document.getElementById('confirm_password').value) {
        document.getElementById('submit').disabled = false;
    } else {
        document.getElementById('submit').disabled = true;
    }
}
</script>
<?php include "footer.php" ?>
