<?php
  if(isset($_POST['update_range'])) {
    // var_dump($_POST);
    // die();
    $query = "SELECT * FROM fields";
    $field = mysqli_query($connection, $query);
    // $nums = mysqli_num_rows($field);
    while($row = mysqli_fetch_assoc($field)) {
      $field_id = $row['id'];
      $name = $row['name'];
      $min = $name.'min';
      $max = $name.'max';
      $minimum = trim($_POST[$min]);
      $maximum = trim($_POST[$max]);
      // var_dump($field_id);
      // die();
      $query = "UPDATE fields_range SET ";
      $query .="minimum = '{$minimum}', maximum = '{$maximum}' ";
      $query .="WHERE field_id = {$field_id} ";
      $update_field_query = mysqli_query($connection, $query);     
    }
    $log_action="Field updated";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action);

    header('Location: '.$_SERVER['PHP_SELF']);
    die;
  }
?>
<style> 
input{
  /* height: 50%; */
  margin: -1px;
}
</style>
<div class="row"> 
  <div class="col col-6">
  <?php
        $query_field = "SELECT * FROM fields";
        $fields_query = mysqli_query($connection, $query_field);
        $times = mysqli_num_rows($fields_query);
        $query_field_id = "SELECT field_id FROM fields_range";
        $fields_id_query = mysqli_query($connection, $query_field_id);
        
  ?>
  <!-- if field is not updated -->
  <?php if(field_exists()): ?>
    <form action="" method="post">
      <p style="margin-bottom: -5px; color:red;">Note: set 0% to 100% only </p>
      <div class="card-body">
      <?php
        while($row = mysqli_fetch_assoc($fields_query)) {
            $id = $row['id'];
            $name = $row['name'];
            $remark = $row['remark'];
            $min = $name.'min'; 
            $max = $name.'max';
            $field_exist_query = "SELECT * FROM fields_range WHERE field_id = '$id' ORDER BY id DESC limit 1";
            $sel_exist = mysqli_query($connection, $field_exist_query);
        
            if($row_n = mysqli_fetch_assoc($sel_exist)) {
              $minimum_n = $row_n['minimum'];
              $maximum_n = $row_n['maximum'];
            }
      ?>
        <div class="form-group" style="margin-bottom: -2px">
          <label for="extwenty"><?php echo $name; ?></label>
        </div>
        <div class="row" >
            <div class="col-sm-6">
              <input type="number" class="form-control" id="exampleMinimum" name="<?php echo $min;?>" value="<?php echo $minimum_n;  ?>">
            </div>
            <div class="col-sm-6">
                <input type="number" class="form-control" id="exampleMaximum" name="<?php echo $max; ?>"  value="<?php  echo $maximum_n; ?>">
            </div>
        </div>
        <?php
    }
    ?>
        <input type="submit" value="Update" name="update_range" class="btn btn-sm btn-primary mt-2">
      </div>
      <!-- /.card-body -->
    </form>
    <?php endif; ?>
  <!-- if field is not updated ended -->
  <!-- if field is updated  -->
  <?php if(!(field_exists())): ?>
    <form action="config1.php" method="post">
      <div class="card-body">
      <?php
        // while($row = mysqli_fetch_assoc($fields_id_query)) {
        //     $fieldId = $row['field_id'];
            $new_field_query = "SELECT * FROM fields WHERE id NOT IN (SELECT field_id FROM fields_range) ";
            $sel_new = mysqli_query($connection, $new_field_query);
          while($row = mysqli_fetch_assoc($sel_new)) {
            $id = $row['id'];
            $name = $row['name'];
            $remark = $row['remark'];
            $min = $name.'min';
            $max = $name.'max';
      ?>
        <div class="form-group" style="margin-bottom: -2px">
          <label for="extwenty"><?php echo $name; ?></label>
        </div>
        <div class="row" >
            <div class="col-sm-6">
              <input type="number" class="form-control" id="exampleMinimum" name="<?php echo $min;?>" placeholder="min">
            </div>
            <div class="col-sm-6">
                <input type="number" class="form-control" id="exampleMaximum" name="<?php echo $max; ?>"  placeholder="max">
            </div>
        </div>
        <?php
        }
    // }
    ?>
        <input type="submit" value="submit" name="create_range" class="btn btn-sm btn-primary mt-2">
      </div>
      <!-- /.card-body -->
    </form>
    <?php endif; ?>
  </div>
  <!-- col-5 border-right  ended -->
            
  <div class="col col-sm-6">
    
    <?php
    $field_range_query = "SELECT * FROM fields_range ORDER BY id DESC limit $times";
    $sel_remarks = mysqli_query($connection, $field_range_query);

    while($row = mysqli_fetch_assoc($sel_remarks)) {
      $r_id = $row['id'];
      $f_id = $row['field_id'];
      $minimum = ucwords($row['minimum']);
      $maximum = ucwords($row['maximum']);
      $query1 = "SELECT * FROM fields where id='$f_id'";
      $sel_field = mysqli_query($connection, $query1);
      
      if($row = mysqli_fetch_assoc($sel_field)){
        $f_name = $row['name'];
        echo'<dl class="row">
            <dt class="col-sm-6">'.$f_name.':</dt>
            <dd class="col-sm-6">'.$minimum.'% - '.$maximum.'%</dd>
          </dl>';
      }
    }?>         
      
  </div>
  <!-- col-7 ended -->
</div>
<!-- row ended -->