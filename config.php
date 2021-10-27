<?php include_once "includes/header.php" ?>
<?php if(isLoggedIn() && checkPermission()): ?>

<!-- Navigation -->
<?php include_once "includes/nav.php" ?>
<!-- /.Navigation -->
<!-- Sidebar -->
<?php include_once "includes/sidebar.php" ?>
<!-- /.sidebar -->
<?php
  if(isset($_POST['create_criteria'])){
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
      
      $query = "INSERT INTO appraisal_criterias(name)";
      $query .= "values('$criteriaName')";

      $create_criteria_query = mysqli_query($connection, $query);
      $log_action = "new criteria added";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 

      if(!$create_criteria_query) {
        die("QUERY Failed". mysqli_error($connection) );
    }
    header('Location: '.$_SERVER['PHP_SELF']);
    die;
    
  }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-edit"></i>
            Performance Appraisal Settings
          </h3>
        </div>
        <div class="card-body">
          <h4>Settings</h4>
          <div class="row">
            <div class="col-5 col-sm-3">
              <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="vert-tabs-criteria-tab" data-toggle="pill" href="#vert-tabs-criteria" role="tab" aria-controls="vert-tabs-criteria" aria-selected="true">Set Appraisal Criteria</a>
                <a class="nav-link" id="vert-tabs-result-tab" data-toggle="pill" href="#vert-tabs-result" role="tab" aria-controls="vert-tabs-result" aria-selected="false">Set Result</a>
                <a class="nav-link" id="vert-tabs-scale-tab" data-toggle="pill" href="#vert-tabs-scale" role="tab" aria-controls="vert-tabs-scale" aria-selected="false">Set Scale</a>
              </div>
            </div>
            <div class="col-7 col-sm-9">
              <div class="tab-content" id="vert-tabs-tabContent">
                <!-- appraisal settings      -->
                <div class="tab-pane text-left fade show active" id="vert-tabs-criteria" role="tabpanel" aria-labelledby="vert-tabs-criteria-tab">
                  <div class="row">
                    <?php
                    $source=null;
                    if(isset($_GET['source'])) {
                        $source = $_GET['source']; 
                    }
                    if(!$source=='edit_contact'): ?>               
            
              
                    <div class="col col-5 border-right">
                      <form action="" method="post" autocomplete="on">
                            <div class="card-body">
                              <div class="form-group">
                                  <label for="exampleCriteria">Criteria</label>
                                  <input type="text" class="form-control" id="exampleCriteria" name="criteria_name" placeholder="add new criteria">
                                  <small><?php echo isset($error['criteriaName']) ? $error['criteriaName'] : '' ?></small>
                              </div>
                              <button type="submit" id="submit" name="create_criteria" class="btn btn-primary">Add New</button>
                              
                          </div>
                      <!-- /.card-body -->
                      </form>
                     

                    </div>
                    <!-- col col-5 border-right ended -->
                    <?php endif; ?>

                    <?php
                    if(isset($_GET['source'])) {
                        $source = $_GET['source']; 
                    } else {
                        $source = '';
                    }
                    switch($source) {  
                        case 'edit_criteria';
                        include "includes/edit_criteria.php";
                        break;
                        default:
                        // include "users.php";
                        break;
                    }

                    ?>
                    <style>
                    table, td, th, thead {
                      border: 1px solid black !important;
                    }
                    </style>
                    <!-- /.col col-5 -->
                    <div class="col col-7 pl-4">
                      <table class="table">
                        <thead>
                          <tr>
                            <th style="width: 10px">S.N.</th>
                            <th>Criteria</th>
                            <th>Scale</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM appraisal_criterias";
                            $sel_criteria = mysqli_query($connection, $query);
                
                            while($row = mysqli_fetch_assoc($sel_criteria)) {
                                $id = $row['id'];
                                $name = ucfirst($row['name']);
                                
                                $query = "SELECT * FROM scales";
                                $sel_scl = mysqli_query($connection, $query);
                                echo"<tr>";
                                echo"<td>{$id}</td>";
                                echo"<td>{$name}</td>";
                                
                                if($row = mysqli_fetch_assoc($sel_scl)) {
                                  $minimum = $row['minimum'];
                                  $maximum = $row['maximum'];
                                  echo"<td>{$minimum} - {$maximum}</td>";
                                }  


                            echo "<td><a class='bg-primary p-1' href='config.php?source=edit_criteria&edit_criteria={$id}'>Edit</a>
                                      <a class='bg-danger p-1' href='config.php?delete={$id}'>Delete</a></td>";
                          echo"</tr>";
                
                          }?>         
                        </tbody>
                      </table>
                    </div>
                    <!-- /.col col-7 -->
                  </div>
                  <!-- /.row ended -->
                </div>
                <!-- set appraisal tab ended -->
                <!-- Set Result Tab -->
                <div class="tab-pane fade" id="vert-tabs-result" role="tabpanel" aria-labelledby="vert-tabs-result-tab">
                  <div class="row"> 
                    <div class="col col-5 border-right">
                      <?php
                      $query = "SELECT * FROM remarks";
                      $remarks_query = mysqli_query($connection, $query);

                      while($row = mysqli_fetch_assoc($remarks_query)) {
                          $id = $row['id'];
                          $twenty = $row['twenty'];
                          $fourty = $row['fourty'];
                          $sixty = $row['sixty'];
                          $eighty= $row['eighty'];
                          $hundred= $row['hundred'];
                      }

                      if(isset($_POST['edit_remark'])) {
                        $twenty = trim($_POST['twenty']);
                        $fourty = trim($_POST['fourty']);
                        $sixty = trim($_POST['sixty']);
                        $eighty = trim($_POST['eighty']);
                        $hundred = trim($_POST['hundred']);

                        $query = "UPDATE remarks SET ";
                        $query .="twenty = '{$twenty}', fourty = '{$fourty}',sixty = '{$sixty}',eighty = '{$eighty}', hundred = '{$hundred}' ";
                        $query .="WHERE id = 1 ";
                        $log_action="remarks updated";
                        create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action);

                        $update_remarks_query = mysqli_query($connection, $query);
                        confirm($update_remarks_query);
                        header('Location: '.$_SERVER['PHP_SELF']);
                        die;
                      }
                      ?>  
                      <form action="" class="col" method="post" autocomplete="on">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="extwenty">0% - 20%</label>
                                <input type="text" class="form-control" id="extwenty" name="twenty" value="<?php echo $twenty ?>">
                                <label for="exfourty">20% - 40%</label>
                                <input type="text" class="form-control" id="exfourty" name="fourty" value="<?php echo $fourty ?>">
                                <label for="exsixty">40% - 60%</label>
                                <input type="text" class="form-control" id="exsixty" name="sixty" value="<?php echo $sixty ?>">
                                <label for="exeighty">60% - 80%</label>
                                <input type="text" class="form-control" id="exeighty" name="eighty" value="<?php echo $eighty ?>">
                                <label for="exhundred">80% - 100%</label>
                                <input type="text" class="form-control" id="exhundred" name="hundred" value="<?php echo $hundred ?>">
                                
                            </div>
                            <button type="submit" id="submit" name="edit_remark" class="btn btn-primary">Update</button>
                            
                        </div>
                        <!-- /.card-body -->
                      </form>
                    </div>
                    <!-- col-5 border-right  ended -->
                              
                    <div class="col col-7 pl-2">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                          <th>0% - 20%</th>
                          <th>20% - 40%</th>
                          <th>40% - 60%</th>
                            <th>60% - 80%</th>
                            <th>80% - 100%</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM remarks";
                            $sel_remarks = mysqli_query($connection, $query);
                
                            if($row = mysqli_fetch_assoc($sel_remarks)) {
                                $id = $row['id'];
                                $twenty = ucwords($row['twenty']);
                                $fourty = ucwords($row['fourty']);
                                $sixty = ucwords($row['sixty']);
                                $eighty = ucwords($row['eighty']);
                                $hundred = ucwords($row['hundred']);
                            
                          echo"<tr>";
                            echo"<td>{$twenty}</td>";
                            echo"<td>{$fourty}</td>";
                            echo"<td>{$sixty}</td>";
                            echo"<td>{$eighty}</td>";
                            echo"<td>{$hundred}</td>";
                            "</tr>";
                
                          }?>         
                        </tbody>
                      </table>
                    </div>
                    <!-- col-7 ended -->
                  </div>
                  <!-- row ended -->
                </div> 
                <!-- set  Result tab ended -->
                <!-- set scale range tab -->
                <div class="tab-pane fade" id="vert-tabs-scale" role="tabpanel" aria-labelledby="vert-tabs-scale-tab">
                  <div class="row"> 
                       <!-- update scale form -->
                       <?php
                        $query = "SELECT * FROM scales";
                        $scales_query = mysqli_query($connection, $query);

                          while($row = mysqli_fetch_assoc($scales_query)) {
                              $id = $row['id'];
                              $minimum = $row['minimum'];
                              $maximum = $row['maximum'];
                          }
                          if(isset($_POST['update_scale'])) {
                            $minimum = trim($_POST['minimum']);
                            $maximum = trim($_POST['maximum']);
                            $query = "UPDATE scales SET ";
                            $query .="minimum = '{$minimum}', maximum = '{$maximum}'";
                            $query .="WHERE id = 1 ";
                            $log_action="Scale range updated";
                            create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action);

                            $update_scales_query = mysqli_query($connection, $query);
                            confirm($update_scales_query);
                            header('Location: '.$_SERVER['PHP_SELF']);
                          }
                      ?>
                      <form action="" method="post" autocomplete="on">
                        <div class="card-body">
                          <div class="form-group">
                            <p>Set new scale range </p>
                            <div class="row">
                              <div class="col-4">
                                
                                <input type="number" class="form-control" id="exampleMinimum" name="minimum" placeholder="min: <?php echo $minimum;?>"> - &nbsp;
                              </div>
                              <div class="col-4">
                                  <input type="number" class="form-control" id="exampleMaximum" name="maximum" placeholder="max: <?php echo $maximum;?>">
                              </div>                              
                              <div class="col-4">
                              <button type="submit" id="submit" name="update_scale" class="btn btn-primary">Save</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      <!-- /.card-body -->
                      </form>
                  </div>
                  <!-- row ended -->
                </div> 
                <!-- set scale range tab ended -->                
              </div>
              <!-- Tab content ended -->
            </div>
            <!-- col-7 col-sm-9 ended -->
          </div>
          <!-- row ended -->
        </div>
        <!-- /.CARD card-body ended -->
      </div>
      <!-- /.card card-primary ended-->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
</div>
<!-- /.content-wrapper -->

<?php include "includes/footer.php" ?>
<?php
//delete criteria query
if(isset($_GET['delete'])) {
    $log_action="criteria deleted";
    $the_id = mysqli_real_escape_string($connection,$_GET['delete']);

    $query = "DELETE FROM appraisal_criterias where id = '{$the_id}'";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 
    $del_report_query = mysqli_query($connection, $query);
    header('Location: '.$_SERVER['PHP_SELF']);
    die;

}

?>
<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>