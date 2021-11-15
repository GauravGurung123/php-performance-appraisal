<?php include_once "includes/header.php" ?>
<?php if(isLoggedIn() && checkPermission()): ?>
<!-- Navigation -->
<?php include_once "includes/nav.php" ?>
<!-- /.Navigation -->
<!-- Sidebar -->
<?php include_once "includes/sidebar.php" ?>
<!-- /.sidebar -->
<?php
  // if(isset($_POST['create_criteria'])){
// if ($_POST['idCriteria']!=""){
//     $criteriaName = trim($_POST['idCriteria']);
    
//   $error = [
//       'criteriaName'=> '',
//   ];

//   if (strlen($criteriaName) < 2) {
//     $error['criteriaName'] = 'criteria name cannot be less than 2 characters <hr color="red">';
//   }
//   if (criteria_exists($criteriaName)) {
//     $error['criteriaName'] = 'criteria name already exists, pick another one <hr color="red">';
//   }

//   foreach ($error as $key => $value) {
//       if (empty($value)) {
//       unset($error[$key]);
//       }
//   }

//   if (empty($error)) {
      
//       $query = "INSERT INTO appraisal_criterias(name)";
//       $query .= "values('$criteriaName')";

//       $create_criteria_query = mysqli_query($connection, $query);
//       $log_action = "new criteria added";
//     create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 

//       if(!$create_criteria_query) {
//         die("QUERY Failed". mysqli_error($connection) );
//     }
//     header('Location: '.$_SERVER['PHP_SELF']);
//     die;
//     if($criteriaName){
//       echo "<span style='color:green; font-weight:bold;'>
//       Thank you for contacting us, we will get back to you shortly.
//       </span>";
//     }
//     else{
//       echo "<span style='color:red; font-weight:bold;'>
//       Sorry! Your form submission is failed.
//       </span>";
//       } 
//   }
// }
?>
<?php
  if(isset($_POST['create_range'])) {
    // var_dump($_POST);
    // die();
    $res_id = hexdec(uniqid());
    $query = "SELECT * FROM fields";
    $field = mysqli_query($connection, $query);
    // $nums = mysqli_num_rows($field);
   
    while($row = mysqli_fetch_assoc($field)) {
      // $id = $row['id'];
      $field_id = $row['id'];
      $name = $row['name'];
      $min = $name.'min';
      $max = $name.'max';
      $minimum = trim($_POST[$min]);
      $maximum = trim($_POST[$max]);

      $field_exist_query = "SELECT * FROM fields_range WHERE field_id = '$field_id' ORDER BY id DESC LIMIT 1";
      $sel_exist = mysqli_query($connection, $field_exist_query);
  
      if($row_n = mysqli_fetch_assoc($sel_exist)) {
        $minimum_n = $row_n['minimum'];
        $maximum_n = $row_n['maximum'];
        $field_exist_query = "INSERT INTO fields_range(field_id, minimum, maximum, result_id)";
        $field_exist_query .= "VALUES('$field_id', '$minimum_n', '$maximum_n', '$res_id')";
        $update_result_query = mysqli_query($connection, $field_exist_query);
      }else {
        $field_query = "INSERT INTO fields_range(field_id, minimum, maximum, result_id)";
        $field_query .= "VALUES('$field_id', '$minimum', '$maximum', '$res_id')";
        $create_result_query = mysqli_query($connection, $field_query);
      }
    }
    ?><?php
    $log_action="range created";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action);

    header('Location: '.$_SERVER['PHP_SELF']);
    die;
  } 
?>                     

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">


<div class="row">
    <div class="col col-sm-12">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-criteria-tab" data-toggle="pill" href="#custom-tabs-four-criteria" role="tab" aria-controls="custom-tabs-four-criteria" aria-selected="false">Appraisal Criteria</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-four-result-tab" data-toggle="pill" href="#custom-tabs-four-result" role="tab" aria-controls="custom-tabs-four-result" aria-selected="true">Result</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-scale-tab" data-toggle="pill" href="#custom-tabs-four-scale" role="tab" aria-controls="custom-tabs-four-scale" aria-selected="false">Scale</a>
                    </li>
                    
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade" id="custom-tabs-four-criteria" role="tabpanel" aria-labelledby="custom-tabs-four-criteria-tab">
                        <?php include "includes/criteriatab.php"; ?>
                    </div>
                    <div class="tab-pane fade active show" id="custom-tabs-four-result" role="tabpanel" aria-labelledby="custom-tabs-four-result-tab">
                        <div class="row">    
                            <!-- <div class="col col-sm-7">  -->
                            <?php include "includes/rangetab.php"; ?>
                            <!-- </div>
                            <div class="col col-sm-5"> 
                            <?php  // include "includes/resulttab.php"; ?>
                            </div> -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-four-scale" role="tabpanel" aria-labelledby="custom-tabs-four-scale-tab">
                    <?php include "includes/scaletab.php"; ?>
                    </div>
                    
                </div>
            </div>
            <!-- /.card-body ended -->
        </div>
        <!-- card card-primary ended -->
    </div>
    <!-- col col-sm-12 ended -->
</div>
<!-- row ended -->

</div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
</div>
<!-- /.content-wrapper -->

<?php include "includes/footer.php" ?>
<?php include("includes/modal_delete.php"); ?>

<script>
  $(document).ready(function(){
      $(".del_link").on('click', function(){
          var delId1 = $(this).attr("rel");
          var delUrl1 = "config1.php?delete="+ delId1 +" ";

          $(".modal_del_link").attr("href", delUrl1);

          $("#modal-sm").modal('show');
          
      });
      $(".del_field_link").on('click', function(){
          var delId1 = $(this).attr("rel");
          var delUrl1 = "config1.php?delete_field="+ delId1 +" ";
          
          $(".modal_del_link").attr("href", delUrl1);

          $("#modal-sm").modal('show');
          
      });
  });
  
  $(function() {

  $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
    localStorage.setItem('lastTab', $(this).attr('href'));
  });
  var lastTab = localStorage.getItem('lastTab');
  
  if (lastTab) {
    $('[href="' + lastTab + '"]').tab('show');
  }
    
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
//delete field query
if(isset($_GET['delete_field'])) {
  $log_action="criteria deleted";
  $the_id = mysqli_real_escape_string($connection,$_GET['delete_field']);

  $query = "DELETE FROM fields where id = '{$the_id}'";
  create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 
  $del_report_query = mysqli_query($connection, $query);
  header('Location: '.$_SERVER['PHP_SELF']);
  die;
}
?>
<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>