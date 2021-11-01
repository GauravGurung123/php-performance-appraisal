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
    if(isset($_POST['update_range'])) {
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