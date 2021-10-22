<?php
    if(isset($_GET['edit_department'])) {
        $the_department_id = $_GET['edit_department'];

        $query = "SELECT * FROM departments where id = $the_department_id ";
        $sel_departments_query = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($sel_departments_query)) {
            $id = $row['id'];
            $name = $row['name'];
        }

    }
    if(isset($_POST['edit_department'])) {
        $departmentName = trim($_POST['department_name']);

        $error = [
            'departmentName'=> '',
        ];
      
        if (strlen($departmentName) < 2) {
          $error['departmentName'] = 'department name cannot be less than 2 characters <hr color="red">';
        }
        if (department_exists($departmentName)) {
          $error['departmentName'] = 'department name already exists, pick another one <hr color="red">';
      
        }
      
        foreach ($error as $key => $value) {
            if (empty($value)) {
            unset($error[$key]);
            }
        }
        if (empty($error)) {
        
            $query = "UPDATE departments SET ";
            $query .="name = '{$departmentName}' ";
            $query .="WHERE id = {$the_department_id} ";
            $log_action="department updated";
            create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action);

            $update_department_query = mysqli_query($connection, $query);
            confirm($update_department_query);
            header('Location: '.$_SERVER['PHP_SELF']);
            die;
        }
    }

?>
<div class="col col-6">
    <form action="" method="post" autocomplete="on">
        <div class="card-body">
            <div class="form-group">
                <label for="exampleDepartment">Department Name</label>
                <input type="text" class="form-control" id="exampleDepartment" name="department_name"
                 value="<?php echo $name ?>">
                <small><?php echo isset($error['departmentName']) ? $error['departmentName'] : '' ?></small> 
            </div>
            <button type="submit" name="edit_department" class="btn btn-primary">Update</button>
            
        </div>
    <!-- /.card-body -->
    </form>

</div>
