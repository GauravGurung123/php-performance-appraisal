<?php
    if(isset($_GET['edit_criteria'])) {
        $the_criteria_id = $_GET['edit_criteria'];
        
        $query = "SELECT * FROM appraisal_criterias where id = $the_criteria_id ";
        $sel_criterias_query = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($sel_criterias_query)) {
            $id = $row['id'];
            $name = $row['name'];
        }

    }
    if(isset($_POST['edit_criteria'])) {
        $criteriaName = trim($_POST['criteria_name']);

        $error = [
            'criteriaName'=> '',
        ];
      
        if (strlen($criteriaName) < 2) {
          $error['criteriaName'] = 'criteria name cannot be less than 2 characters <hr color="red">';
        }
        if (criteria_exists($criteriaName)) {
          $error['criteriaName'] = 'criteria name already exists, pick another one <hr color="red">';
      
        }
      
        foreach ($error as $key => $value) {
            if (empty($value)) {
            unset($error[$key]);
            }
        }
        if (empty($error)) {
        
            $query_update = "UPDATE appraisal_criterias SET name = '{$criteriaName}' WHERE appraisal_criterias.id = '{$the_criteria_id}' ";
            $log_action="citeria updated";
            create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action);

            $update_criteria_query = mysqli_query($connection, $query_update);
            header('Location: '.$_SERVER['PHP_SELF']);
            die;
        }
    }

?>

<div class="col col-5 border-right">
    <form action="" method="post" autocomplete="on">
        <div class="card-body">
            <div class="form-group">
                <label for="exampleCriteria">Criteria</label>
                <input type="text" class="form-control" id="exampleCriteria" name="criteria_name" value="<?php echo $name; ?>">
                <small><?php echo isset($error['criteriaName']) ? $error['criteriaName'] : '' ?></small>
            </div>
            <button type="submit" id="submit" name="edit_criteria" class="btn btn-primary">Update</button>
            
        </div>
    <!-- /.card-body -->
    </form>

</div>