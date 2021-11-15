<?php
    if(isset($_GET['edit_user'])) {
        $the_user_id = $_GET['edit_user'];

        $query = "SELECT * FROM staffs where id = $the_user_id ";
        $sel_users_query = mysqli_query($connection, $query);

        if($row = mysqli_fetch_assoc($sel_users_query)) {
            $user_id = $row['id'];
            $username = $row['username'];
            $name = $row['name'];
            $designation = $row['designation'];
            $roleId = $row['role_id'];
            $deptId = $row['dept_id'];
        }
        $query_depart = "SELECT * FROM departments where id = $deptId ";
        $sel_depart_query = mysqli_query($connection, $query_depart);

        if($row = mysqli_fetch_assoc($sel_depart_query)) {
            $departmentID = $row['id']; 
            $departmentName = $row['name']; 
        }
    }
    if(isset($_POST['edit_user'])) {
        $username = $_POST['username'];
        $name = $_POST['fullname'];
        $designation = $_POST['designation'];
        $department = $_POST['department'];
        $user_role = $_POST['user_role'];
        echo $user_role;

        $query = "UPDATE staffs SET username = '{$username}', name = '{$name}', role_id = '$user_role', dept_id = '$department', designation = '{$designation}' WHERE staffs.id = {$the_user_id} ";
        $log_action="User profile updated"; 
        create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action);

        $update_user_query = mysqli_query($connection, $query);
        confirm($update_user_query);
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
    }


?>

<div class="row">
    <div class="col col-12">
        <form action="" method="post" autocomplete="on">
            <legend class="mt-2">Edit Profile: </legend>
                <div class="card-body p-4" style="border: 1px solid black">
                    
                    <div class="form-group col-4">
                    <label for="exampleUsername">Username</label>
                    <input type="text" class="form-control" id="exampleUsername" name="username" value="<?php echo $username; ?>">
                    <small><?php echo isset($error['username']) ? $error['username'] : '' ?></small> 
                    </div>
                    <div class="form-group col-4">
                    <label for="examplefullname">Full Name</label>
                    <input type="text" class="form-control" id="examplefullname" name="fullname" value="<?php echo $name; ?>">
                    <small><?php echo isset($error['username']) ? $error['username'] : '' ?></small> 
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="exampleDesignation">Department</label>
                      <select name="department" class="form-control">
                        <option value="<?php echo $departmentID; ?>"><?php echo $departmentName;?></option>';
                          <?php
                          $query_role1 = "SELECT * FROM departments ";
                          $sel_role1 = mysqli_query($connection, $query_role1);
                          while($row = mysqli_fetch_assoc($sel_role1)) {
                              $id = $row['id'];
                              $deptName = $row['name'];?>
                            <option value="<?php echo $id; ?>"><?php echo $deptName;?></option>';
                              <?php
                          }
                          ?> 
                        </select>
                      </div>
                    <div class="form-group col-4">
                    <label for="exampleDesignation">Designation</label>
                    <input type="text" class="form-control" id="exampleDesignation" name="designation" value="<?php echo $designation; ?>">
                    </div>
                    <div class="form-group col-4">
                        <label for="exampleEvaluateename" class="col-form-label">User Roles</label>
                        <select name="user_role" id="txtHint" class="form-control">
                            <?php 
                            $query_role = "SELECT * FROM roles WHERE id = '$roleId' ";
                            $sel_role = mysqli_query($connection, $query_role);
                            if($row = mysqli_fetch_assoc($sel_role)) {
                                $default = $row['name'];
                            }
                            ?>
                            <option value="<?php echo $roleId ?>"><?php echo $default; ?></option>;
                            <?php
                            $query_role1 = "SELECT * FROM roles WHERE id <> '$roleId' AND name <> 'superadmin' ";
                            $sel_role1 = mysqli_query($connection, $query_role1);
                            while($row = mysqli_fetch_assoc($sel_role1)) {
                                $id = $row['id'];
                                $role = $row['name'];
                                ?>
                              <option value="<?php echo $id; ?>"><?php echo $role;?></option>';
                                <?php
                            }
                            ?> 
                        </select>
                    </div>
                    <!--                     
                    <div class="form-group col-4">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="password" 
                    onkeyup='check();' name="password" placeholder="Password">
                    </div>
                    <div class="form-group col-4">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" 
                    onkeyup='check();' name="confirm_password" placeholder="Password">
                    <span id='message'></span>
                    </div> -->
                    <button type="submit" id="submit" name="edit_user" class="btn btn-primary ml-2">Save</button>
                    <a class="btn btn-danger" href="staffs.php">cancel</a>
                </div>
                <!-- /.card-body -->
        </form>
    </div>
    <!-- col col-6 ended -->
</div>
<!-- row ended -->

