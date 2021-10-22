<?php include_once "includes/header.php" ?>
<?php if(isLoggedIn()): ?>

<!-- Navigation -->
<?php include_once "includes/nav.php" ?>
<!-- /.Navigation -->
<!-- Sidebar -->
<?php include_once "includes/sidebar.php" ?>
<!-- /.sidebar -->  

<!-- peer appraiasl form -->
<?php
// print_r($_POST);                               
// die();
    if(isset($_POST['create_report'])){
        $evaluatorname = $_SESSION['name'];
        $evaluateename = trim($_POST['evaluateename']);
      
        //

        $query = "SELECT * from appraisal_criterias";
        $criterias = mysqli_query($connection, $query);
        // confirm($sel_criterias);
        while($row = mysqli_fetch_assoc($criterias)) {
            // $id = $row['id'];
            $name = ucwords($row['name']);
            $count = intval($_POST[$name]);
        }


        $query = "INSERT INTO eval_reports(evaluator_name, evaluatee_name, eval_total_score, eval_score, eval_remarks)";
        $query .= "VALUES('$evaluatorname', '$evaluateename', '$totalScore', '$avgScore', '$remark')";

        $create_report_query = mysqli_query($connection, $query);
        $log_action = "new report added";
        create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 

        if(!$create_report_query) {
        die("QUERY Failed". mysqli_error($connection) );
        }
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
        
    } 
?>
<!-- self appraiasl form -->
<?php
    // if(isset($_POST['self_report'])){
    //     $evaluatorname = $_SESSION['name'];
    // 
    //     $totalScore = $punctuality+$attendance+$accuracy+$teamwork+$leadership+$communication+$creativity;
    //     $avgScore =  round($totalScore/7);
    //     switch($avgScore) {  
    //         case ($avgScore<=3);
    //         $remark = "poor";
    //         break;
    //         case ($avgScore>3 && $avgScore<6);
    //         $remark = "appreciable";
    //         break;
    //         case ($avgScore>5 && $avgScore<9);
    //         $remark = "strong work ethic";
    //         break;
    //         case 9;
    //         $remark = "excellent";
    //         break;
    //         default:
    //         $remark = "outstanding performance";
    //         break;
    //     }
         
    //     $query = "INSERT INTO eval_reports(evaluator_name, eval_total_score, eval_score, eval_remarks)";
    //     $query .= "VALUES('$evaluatorname', '$punctuality', '$attendance', '$accuracy', '$teamwork', '$leadership', '$communication', '$creativity', '$totalScore', '$avgScore', '$remark')";

    //     $create_report_query = mysqli_query($connection, $query);
    //     $log_action = "self report added";
    //     create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 

    //     if(!$create_report_query) {
    //     die("QUERY Failed". mysqli_error($connection) );
    //     }
    //     header('Location: '.$_SERVER['PHP_SELF']);
    //     die;
        
    // } 
?>
<!-- <script>
    window.onpageshow = function() {
        if (typeof window.performance != "undefined"
            && window.performance.navigation.type === 0) {
            $('#modal-lg').modal('show');
        }
    }
</script> -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="col-10">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-four-peer-tab" data-toggle="pill" href="#custom-tabs-four-peer" role="tab" aria-controls="custom-tabs-four-peer" aria-selected="true">Peer Appraisal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-self-tab" data-toggle="pill" href="#custom-tabs-four-self" role="tab" aria-controls="custom-tabs-four-self" aria-selected="false">Self Appraisal</a>
                    </li>
                    
                    </ul>
                </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-peer" role="tabpanel" aria-labelledby="custom-tabs-four-peer-tab">
                    <div class="card card-info m-2">
                            <div class="card-header">
                                <h3 class="card-title">Peer Evaluation Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="" method="post" class="col-10">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="exampleEvaluatorname" class="col-sm-6 col-form-label">Evaluator Name</label>
                                    <div class="col-sm-6">
                                    <input type="text" name="evaluatorname" class="form-control" 
                                    id="exampleEvaluatorname" value="<?php echo $_SESSION['name']; ?>" disabled>
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
                                            $id = $row['id'];
                                            $name = $row['name'];
                                            $username = $row['username'];

                                            echo '<option value="'. $name .'" ' . ($_SESSION['username']=='' . $username . ''  ? 'disabled="disabled"' : ''). '>' . $name .'</option>';

                                        }

                                        ?>
                                        
                                    </select>
                                    </div>
                                </div>
                                <span class="validity"><p>rating must be in range of 1 to 10.</p></span>
                                <?php

                                   $query = "SELECT * from appraisal_criterias";
                                $sel_criterias = mysqli_query($connection, $query);
                                confirm($sel_criterias);
                                while($row = mysqli_fetch_assoc($sel_criterias)) {
                                    // $id = $row['id'];
                                    $name = ucwords($row['name']);
                                    $minimum = $row['minimum'];
                                    $maximum = $row['maximum'];

                                    echo "<div class='form-group row'>
                                <label for='example{$name}' class='col-sm-6 col-form-label'>{$name}</label>
                                    <div class='col-sm-2'>
                                    <input type='number' name='{$name}' class='form-control' 
                                    id='example{$name}' placeholder='1 to 10' min='{$minimum}' max='{$maximum}'  required>
                                    
                                    </div>
                                    <label for='examplefbk{$name}' class='col-sm-6 col-form-label'>Remarks</label>
                                    <div class='col-sm-6'>
                                    <input type='text' name='comment{$name}' class='form-control' 
                                    id='examplefbk{$name}' placeholder='your remarks' required>
                                    
                                    </div>
                                    </div><hr>";

                                }
                                ?>
                                </div>
                                <!-- /.card body-->
                                <div class="card-footer">
                                    <button type="submit" name="create_report" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">Submit</button>
                                </div>
                                <!-- /.card-footer -->            
                            
                            </form>
                        </div>
                        <!-- ./card -->
                    </div>
                    <!-- peer tab ends -->
                    <div class="tab-pane fade" id="custom-tabs-four-self" role="tabpanel" aria-labelledby="custom-tabs-four-self-tab">
                        <!-- self appraisal -->
                        <div class="card card-info m-2">
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
                                        id="exampleEvaluatorname" value="<?php echo $_SESSION['name']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleEvaluateename" class="col-sm-6 col-form-label">Evaluatee Name</label>
                                        <div class="col-sm-6">
                                        <input type="text" name="evaluatorname" class="form-control" 
                                        id="exampleEvaluateename" value="self" disabled>
                                        </div>
                                    </div>            
                                    <span class="validity"><p>rating must be in range of 1 to 10.</p></span>

                                    <?php
                                    $query = "SELECT * from appraisal_criterias";
                                    $sel_criterias = mysqli_query($connection, $query);
                                    confirm($sel_criterias);
                                    while($row = mysqli_fetch_assoc($sel_criterias)) {
                                        $name = $row['name'];

                                        echo "<div class='form-group row'>
                                        <label for='example{$name}' class='col-sm-6 col-form-label'>{$name}</label>
                                        <div class='col-sm-2'>
                                        <input type='number' name='{$name}' class='form-control' 
                                        id='example{$name}' placeholder='1 to 10' min='1' max='10'  required>
                                        
                                        </div>
                                        <label for='examplefbk{$name}' class='col-sm-6 col-form-label'>Remarks</label>
                                        <div class='col-sm-6'>
                                        <input type='text' name='comment{$name}' class='form-control' 
                                        id='examplefbk{$name}' placeholder='your remarks' required>
                                        
                                        </div>
                                        </div>";

                                    }
                                    ?>  
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                <button type="submit" name="self_report" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">Submit</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                        <!-- ./card -->
                    </div>
                    <!-- self tab ends -->
                </div>
                <!-- tab content -->
            </div>
              <!-- /.card-body -->
        </div>
        <!-- ./card card-primary -->
    </div>
    <!-- ./col-12 -->
<!-- row -->

<!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</div>
<!-- /.content-wrapper -->
<?php
    print_r($_POST);                               
// die();
?>
  
<?php include_once "includes/footer.php"?>

<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>