<?php
    if(isset($_GET['edit_field'])) {
        $the_field_id = $_GET['edit_field'];

        $query = "SELECT * FROM fields where id = $the_field_id ";
        $sel_field_query = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($sel_field_query)) {
            $id = $row['id'];
            $name = $row['name'];
            $remark = $row['remark'];
            $salary = $row['salary'];
        }

    }
    if(isset($_POST['edit_field'])) {
        $fieldName = trim($_POST['field_name']);
        $remarkName = trim($_POST['remark_name']);
        $salaryName = trim($_POST['salary_name']);

        $query = "UPDATE fields SET ";
        $query .="name = '{$fieldName}', remark = '{$remarkName}', salary = '{$salaryName}'";
        $query .="WHERE id = {$the_field_id} ";
        $log_action="Field updated";
        create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action);

        $update_field_query = mysqli_query($connection, $query);
        confirm($update_field_query);
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
    
    }

?>
<div class="col col-4 border-right">
    <form action="" method="post" autocomplete="on">
        <div class="card-body">
            <div class="form-group">
                <label for="exampleCriteria">Field Name</label>
                <input type="text" class="form-control" id="exampleCriteria" name="field_name" value="<?php echo $name; ?>">
                <small><?php echo isset($error['criteriaName']) ? $error['criteriaName'] : '' ?></small>
            </div>
            <div class="form-group">
                <label for="exampleCriteria">Field remark</label>
                <input type="text" class="form-control" id="exampleCriteria" name="remark_name" value="<?php echo $remark; ?>">
                <small><?php echo isset($error['criteriaName']) ? $error['criteriaName'] : '' ?></small>
            </div>
            <div class="form-group">
                <label for="exampleCriteria">Salary</label>
                <input type="number" class="form-control" name="salary_name" min="0" max="100" value="<?php echo $salary; ?>">
            </div>
            <button type="submit" id="submit" name="edit_field" class="btn btn-sm btn-primary">Save</button>
            <a href="config1.php" class="btn btn-sm btn-danger">Cancel</a>
            
        </div>
    <!-- /.card-body -->
    </form>
</div>
