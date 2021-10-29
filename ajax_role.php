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
                <form>
                <?php
                    if($_POST['type']==""){
                        $query = "SELECT * from staffs WHERE role <> 'superadmin' ";
                        $sel_staffs = mysqli_query($connection, $query);
                        confirm($sel_staffs);
                        $str = "";
                        echo '<option value="">Select a Username:</option>';
                        while($row = mysqli_fetch_assoc($sel_staffs)) {
                            $id = $row['id'];
                            $name = $row['name'];
                            $username = $row['username'];
                            
                            $str = '<option value="'. $id .'" ' . ($_SESSION['username']=='' . $username . ''  ? 'disabled="disabled"' : ''). '>' . $name .'</option>';

                        }
                    }else if($_POST['type']=="roleData"){
                        $query = "SELECT * from staffs WHERE role_id = {$_POST['id']} ";
                        $sel_staffs = mysqli_query($connection, $query);
                        confirm($sel_staffs);
                        $str = "";
                        echo '<option value="">Select a Username:</option>';
                        while($row = mysqli_fetch_assoc($sel_staffs)) {
                            $id = $row['id'];
                            $name = $row['name'];
                            $username = $row['username'];
                            
                            $str = '<option value="'. $id .'" ' . ($_SESSION['username']=='' . $username . ''  ? 'disabled="disabled"' : ''). '>' . $name .'</option>';

                        }
                    }
                                
                                echo $str;
                    ?>
                            </select>
                        </div>
                    </div>
            
                    <div class="col col-4">
                        <div class="form-group row">
                        
                            <label for="exampleEvaluateename" class="col-form-label">User Roles</label>
                            <select name="userrole" id="txtHint" class="form-control">
                            <?php
                                if($_POST['type'] == ""){

                                $query = "SELECT role FROM staffs where id='".$q."'";
                                $sel_roles = mysqli_query($connection, $query);
                                $str="";
                                confirm($sel_roles);
                                if($row = mysqli_fetch_assoc($sel_roles)) {
                                    $role = $row['role'];
                                    echo '<option value="member">-- select (default role {$role}) --</option>';
                                    echo '<option value="admin">Admin</option>';
                                    echo '<option value="member">Member</option>';
                                }
                              } elseif ($_POST['type'] == "roleData"){

                                $query = "SELECT role FROM staffs where id= {$_POST['id']}";
                                $sel_roles = mysqli_query($connection, $query);
                                $str="";
                                confirm($sel_roles);
                                if($row = mysqli_fetch_assoc($sel_roles)) {
                                    $role = $row['role'];
                                    echo '<option value="member">-- select (default role {$role}) --</option>';
                                    echo '<option value="admin">Admin</option>';
                                    echo '<option value="member">Member</option>';
                                }
                              } 
                            ?>
                            </select>
                        </div>
                    </div>
                    
                </form>
            </div>
        <!-- Container fluid ended -->
    </div>
    <!-- Content header ended -->
</div>
<!-- Content wrapper ended -->

<?php include "includes/footer.php" ?>

<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>