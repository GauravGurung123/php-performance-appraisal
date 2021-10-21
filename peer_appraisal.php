<?php include_once "includes/header.php" ?>
<?php if(isLoggedIn()): ?>

<!-- Navigation -->
<?php include_once "includes/nav.php" ?>
<!-- /.Navigation -->
<!-- Sidebar -->
<?php include_once "includes/sidebar.php" ?>
<!-- /.sidebar -->  


<?php
    if(isset($_POST['create_report'])){
        $evaluatorname = $_SESSION['staff_name'];
        $evaluateename = trim($_POST['evaluateename']);
        $punctuality = trim($_POST['punctuality']);
        $attendance = trim($_POST['attendance']);
        $accuracy = trim($_POST['accuracy']);
        $teamwork = trim($_POST['teamwork']);
        $leadership = trim($_POST['leadership']);
        $communication = trim($_POST['communication']);
        $creativity = trim($_POST['creativity']);
        $totalScore = $punctuality+$attendance+$accuracy+$teamwork+$leadership+$communication+$creativity;
        $avgScore =  round($totalScore/7);
        switch($avgScore) {  
            case ($avgScore<=3);
            $remark = "poor";
            break;
            case ($avgScore>3 && $avgScore<6);
            $remark = "appreciable";
            break;
            case ($avgScore>5 && $avgScore<9);
            $remark = "strong work ethic";
            break;
            case 9;
            $remark = "excellent";
            break;
            default:
            $remark = "outstanding performance";
            break;
        }
         
        $query = "INSERT INTO eval_reports(evaluator_name, evaluatee_name, eval_punctuality, eval_attendance,
         eval_accuracy, eval_teamwork, eval_leadership, eval_communication, eval_creativity, eval_total_score, eval_score, eval_remarks)";
        $query .= "VALUES('$evaluatorname', '$evaluateename', '$punctuality', '$attendance', '$accuracy', '$teamwork', '$leadership', '$communication', '$creativity', '$totalScore', '$avgScore', '$remark')";

        $create_report_query = mysqli_query($connection, $query);
        $log_action = "new report added";
        create_log($_SERVER['REMOTE_ADDR'], $_SESSION['staff_username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 

        if(!$create_report_query) {
        die("QUERY Failed". mysqli_error($connection) );
        }else{
            $last_id = mysqli_insert_id($connection);
        }
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
        
    } 
?>
<script>
    window.onpageshow = function() {
        if (typeof window.performance != "undefined"
            && window.performance.navigation.type === 0) {
            $('#modal-lg').modal('show');
        }
    }
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <p class="display-4">Perform Evaluation <?php echo $_SESSION['staff_name'] ?></p>   
            </div>
            <!-- /.row -->
            <div class="row mb-2">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Peer Evaluation Form</h3>
                </div>
                    <!-- /.card-header -->
                    <!-- form start -->
        <form action="" method="post">
        <div class="card-body">
            <div class="form-group row">
                <label for="exampleEvaluatorname" class="col-sm-6 col-form-label">Evaluator Name</label>
                <div class="col-sm-6">
                <input type="text" name="evaluatorname" class="form-control" 
                id="exampleEvaluatorname" value="<?php echo $_SESSION['staff_name']; ?>" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleEvaluateename" class="col-sm-6 col-form-label">Evaluatee Name</label>
                <div class="col-sm-6">
                <select name="evaluateename" class="form-control select2" style="width: 100%;">
                <?php

                    $query = "SELECT * from staffs";
                    $sel_staffs = mysqli_query($connection, $query);
                    confirm($sel_staffs);
                    while($row = mysqli_fetch_assoc($sel_staffs)) {
                        $staff_id = $row['staff_id'];
                        $staff_name = $row['staff_name'];
                        $staff_username = $row['staff_username'];

                        echo '<option value="'. $staff_name .'" ' . ($_SESSION['staff_username']=='' . $staff_username . ''  ? 'disabled="disabled"' : ''). '>' . $staff_name .'</option>';

                    }

                    ?>
                    
                  </select>
                </div>
            </div>
            <span class="validity"><p>rating must be in range of 1 to 10.</p></span>

            <div class="form-group row">
                <label for="examplePunctuality" class="col-sm-6 col-form-label">Punctuality</label>
                <div class="col-sm-6">
                <input type="number" name="punctuality" class="form-control" 
                id="examplePunctuality" placeholder="1 to 10" min="1" max="10" pattern="[0-9]{2}" required>
                
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleAttendace" class="col-sm-6 col-form-label">Attendace</label>
                <div class="col-sm-6">
                <input type="number" name="attendance" class="form-control" 
                id="exampleAttendace" placeholder="1 to 10" min="1" max="10" pattern="[0-9]{2}" required>
                
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleAccuracy" class="col-sm-6 col-form-label">Accuracy</label>
                <div class="col-sm-6">
                <input type="number" name="accuracy" class="form-control" 
                id="exampleAccuracy" placeholder="1 to 10" min="1" max="10" pattern="[0-9]{2}" required>
                
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleTeamwork" class="col-sm-6 col-form-label">Teamwork</label>
                <div class="col-sm-6">
                <input type="number" name="teamwork" class="form-control" 
                id="exampleTeamwork" placeholder="1 to 10" min="1" max="10" pattern="[0-9]{2}" required>
                
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleLeadership" class="col-sm-6 col-form-label">Leadership</label>
                <div class="col-sm-6">
                <input type="number" name="leadership" class="form-control" 
                id="exampleLeadership" placeholder="1 to 10" min="1" max="10" pattern="[0-9]{2}" required>
                
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleCommunication" class="col-sm-6 col-form-label">Communication</label>
                <div class="col-sm-6">
                <input type="number" name="communication" class="form-control" 
                id="exampleCommunication" placeholder="1 to 10" min="1" max="10" pattern="[0-9]{2}" required>
                
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleCreativity" class="col-sm-6 col-form-label">Creativity</label>
                <div class="col-sm-6">
                <input type="number" name="creativity" class="form-control" 
                id="exampleCreativity" placeholder="1 to 10" min="1" max="10" pattern="[0-9]{2}" required>
                
                </div>
            </div>
  
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" name="create_report" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">Submit</button>
        </div>
        <!-- /.card-footer -->
      </form>

      <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
            <?php
            $query = "SELECT * FROM eval_reports ORDER BY eval_id DESC LIMIT 1 ";
            $sel_report = mysqli_query($connection, $query);
            confirm($sel_report);
            if($row = mysqli_fetch_assoc($sel_report)) {
                $eval_id = $row['eval_id'];
                $eval_datetime = $row['eval_datetime'];
                $evaluator_name = ucwords($row['evaluator_name']);
                $evaluatee_name = ucwords($row['evaluatee_name']);
                $eval_punctuality = $row['eval_punctuality'];
                $eval_attendance = $row['eval_attendance'];
                $eval_accuracy = $row['eval_accuracy'];
                $eval_teamwork = $row['eval_teamwork'];
                $eval_leadership = $row['eval_leadership'];
                $eval_communication = $row['eval_communication'];
                $eval_creativity = $row['eval_creativity'];
                $eval_total_score = $row['eval_total_score'];
                $eval_score = $row['eval_score'];
                $eval_remarks = $row['eval_remarks'];
            echo "
              <h4 class='modal-title'>Performance Appraisal Report <span><small>Report ID : 00{$eval_id} || DateTime : {$eval_datetime} </small> </span></h4>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body'>";
                echo "
                <p>Evaluator : {$evaluator_name} || Evaluatee : {$evaluatee_name} </p>
                <hr>
                <p>Punctuality : {$eval_punctuality} </p>
                <p>Attendance : {$eval_attendance} </p>
                <p>Accuracy : {$eval_accuracy} </p>
                <p>Teamwork : {$eval_teamwork} </p>
                <p>Leadership : {$eval_leadership} </p>
                <p>Communication : {$eval_communication} </p>
                <p>Creativity : {$eval_creativity} </p>
                <hr>
                <p>Total Score : {$eval_total_score} || Average Score : {$eval_score} </p>
                <hr>
                <p>Remarks: {$eval_remarks} </P> 
                ";

            } 

            ?>
                
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

  </div>
<!-- /peer appraisal -->
<!-- self appraisal -->
<div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Self Appraisal Form</h3>
                </div>
                    <!-- /.card-header -->
                    <!-- form start -->
        <form action="" method="post">
        <div class="card-body">
            <div class="form-group row">
                <label for="exampleEvaluatorname" class="col-sm-6 col-form-label">Evaluator Name</label>
                <div class="col-sm-6">
                <input type="text" name="evaluatorname" class="form-control" 
                id="exampleEvaluatorname" value="<?php echo $_SESSION['staff_name']; ?>" disabled>
                </div>
            </div>
            
            <span class="validity"><p>rating must be in range of 1 to 10.</p></span>

            <div class="form-group row">
                <label for="examplePunctuality" class="col-sm-6 col-form-label">Punctuality</label>
                <div class="col-sm-6">
                <input type="number" name="punctuality" class="form-control" 
                id="examplePunctuality" placeholder="1 to 10" min="1" max="10" pattern="[0-9]{2}" required>
                
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleAttendace" class="col-sm-6 col-form-label">Attendace</label>
                <div class="col-sm-6">
                <input type="number" name="attendance" class="form-control" 
                id="exampleAttendace" placeholder="1 to 10" min="1" max="10" pattern="[0-9]{2}" required>
                
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleAccuracy" class="col-sm-6 col-form-label">Accuracy</label>
                <div class="col-sm-6">
                <input type="number" name="accuracy" class="form-control" 
                id="exampleAccuracy" placeholder="1 to 10" min="1" max="10" pattern="[0-9]{2}" required>
                
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleTeamwork" class="col-sm-6 col-form-label">Teamwork</label>
                <div class="col-sm-6">
                <input type="number" name="teamwork" class="form-control" 
                id="exampleTeamwork" placeholder="1 to 10" min="1" max="10" pattern="[0-9]{2}" required>
                
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleLeadership" class="col-sm-6 col-form-label">Leadership</label>
                <div class="col-sm-6">
                <input type="number" name="leadership" class="form-control" 
                id="exampleLeadership" placeholder="1 to 10" min="1" max="10" pattern="[0-9]{2}" required>
                
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleCommunication" class="col-sm-6 col-form-label">Communication</label>
                <div class="col-sm-6">
                <input type="number" name="communication" class="form-control" 
                id="exampleCommunication" placeholder="1 to 10" min="1" max="10" pattern="[0-9]{2}" required>
                
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleCreativity" class="col-sm-6 col-form-label">Creativity</label>
                <div class="col-sm-6">
                <input type="number" name="creativity" class="form-control" 
                id="exampleCreativity" placeholder="1 to 10" min="1" max="10" pattern="[0-9]{2}" required>
                
                </div>
            </div>
  
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" name="create_report" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">Submit</button>
        </div>
        <!-- /.card-footer -->
      </form>

      <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
            <?php
            $query = "SELECT * FROM eval_reports ORDER BY eval_id DESC LIMIT 1 ";
            $sel_report = mysqli_query($connection, $query);
            confirm($sel_report);
            if($row = mysqli_fetch_assoc($sel_report)) {
                $eval_id = $row['eval_id'];
                $eval_datetime = $row['eval_datetime'];
                $evaluator_name = ucwords($row['evaluator_name']);
                $evaluatee_name = ucwords($row['evaluatee_name']);
                $eval_punctuality = $row['eval_punctuality'];
                $eval_attendance = $row['eval_attendance'];
                $eval_accuracy = $row['eval_accuracy'];
                $eval_teamwork = $row['eval_teamwork'];
                $eval_leadership = $row['eval_leadership'];
                $eval_communication = $row['eval_communication'];
                $eval_creativity = $row['eval_creativity'];
                $eval_total_score = $row['eval_total_score'];
                $eval_score = $row['eval_score'];
                $eval_remarks = $row['eval_remarks'];
            echo "
              <h4 class='modal-title'>Performance Appraisal Report <span><small>Report ID : 00{$eval_id} || DateTime : {$eval_datetime} </small> </span></h4>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body'>";
                echo "
                <p>Evaluator : {$evaluator_name} || Evaluatee : {$evaluatee_name} </p>
                <hr>
                <p>Punctuality : {$eval_punctuality} </p>
                <p>Attendance : {$eval_attendance} </p>
                <p>Accuracy : {$eval_accuracy} </p>
                <p>Teamwork : {$eval_teamwork} </p>
                <p>Leadership : {$eval_leadership} </p>
                <p>Communication : {$eval_communication} </p>
                <p>Creativity : {$eval_creativity} </p>
                <hr>
                <p>Total Score : {$eval_total_score} || Average Score : {$eval_score} </p>
                <hr>
                <p>Remarks: {$eval_remarks} </P> 
                ";

            } 

            ?>
                
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

  </div>
   
<!-- /self appraisal -->

   
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</div>
<!-- /.content-wrapper -->

  
<?php include_once "includes/footer.php"?>

<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>