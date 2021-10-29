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
                <div class="tab-pane text-left fade show active" id="vert-tabs-criteria" role="tabpanel" aria-labelledby="vert-tabs-criteria-tab">
                  <!-- appraisal settings      -->
                  <?php include("includes/modal_delete.php"); ?>
                  <?php include "includes/criteriatab.php"; ?>
                </div>
                <!-- set appraisal tab ended -->
                <!-- Set Result Tab -->
                <div class="tab-pane fade" id="vert-tabs-result" role="tabpanel" aria-labelledby="vert-tabs-result-tab">
                  <?php include "includes/resulttab.php"; ?>
                </div> 
                <!-- set  Result tab ended -->
                <!-- set scale range tab -->
                <div class="tab-pane fade" id="vert-tabs-scale" role="tabpanel" aria-labelledby="vert-tabs-scale-tab">
                  <?php include "includes/scaletab.php"; ?>
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
<script>
    $(document).ready(function(){
        $(".del_link").on('click', function(){
            var delId1 = $(this).attr("rel");
            var delUrl1 = "config.php?delete="+ delId1 +" ";

            $(".modal_del_link").attr("href", delUrl1);

            $("#modal-sm").modal('show');
           
        });
    });

</script>
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