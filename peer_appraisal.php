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
    
    if(isset($_POST['create_report'])){
        $evaluatorname = $_SESSION['name'];
        $evaluatorId = $_SESSION['id'];
        $evaluateeId = trim($_POST['evaluateename']);
        
        $query = "SELECT * FROM appraisal_criterias";
        $criterias = mysqli_query($connection, $query);
        $nums = mysqli_num_rows($criterias);
        $query2 = "SELECT * FROM scales" ;
        $sel_all_post2 = mysqli_query($connection, $query2);
        if ($rows = mysqli_fetch_assoc($sel_all_post2)) {
            $maxScale  = $rows['maximum'];
            $maxScale = $maxScale;
            $minScale  = $rows['minimum'];
            $minScale = $minScale;
            $maxScale = $maxScale-$minScale;
        }
        $rep_id = hexdec(uniqid()); 
        while($row = mysqli_fetch_assoc($criterias)) {
            $id = $row['id'];
            
            $names = ucwords($row['name']);
            $comment = 'comment'.$names;
                
            $score= intval($_POST[$names]);
            $remark= trim($_POST[$comment]);
            
            $query = "INSERT INTO reports(report_id, criteria_id, evaluator_id, evaluatee_id, score, remark, max_scale)";
            $query .= "VALUES('$rep_id', '$id', '$evaluatorId', '$evaluateeId', '$score', '$remark', '$maxScale')";
        
            $add_report_query = mysqli_query($connection, $query);
        }   
        
        $q3 = "SELECT SUM(score) AS total, AVG(score) AS avg, SUM(max_scale) AS scaleScore FROM reports where report_id = '$rep_id'";
        $val2= mysqli_query($connection,$q3);
        
    


        if ($rows = mysqli_fetch_assoc($val2)) {
            $total  = $rows['total'];
            $avg  = round($rows['avg']);
            $scaleScore = $rows['scaleScore'];
            // $scaleScore = $scaleScore * $nums;
            global $result;
            $percentage = ($total/$scaleScore)*100;
            $remarK_query = "SELECT * FROM remarks";    
            $val3= mysqli_query($connection,$remarK_query);
            if ($rows = mysqli_fetch_assoc($val3)) {
                $twenty  = $rows['twenty'];
                $fourty  = $rows['fourty'];
                $sixty  = $rows['sixty'];   
                $eighty  = $rows['eighty'];
                $hundred  = $rows['hundred'];
                
                switch($percentage) {
                    case ($percentage<20):
                        $result = $twenty;
                        break;
                    case ($percentage>=20 && $percentage <40 ):
                        $result = $fourty;
                        break;
                    case ($percentage>=40 && $percentage <60 ):
                        $result = $sixty;
                        break;
                    case ($percentage>=60 && $percentage <80 ):
                        $result = $eighty;
                        break;
                    default:
                        $result = $hundred;
                        break;

                }   
                
            }
        }

        $query1 = "UPDATE reports SET ";
        $query1 .="result = '{$result}' ";
        $query1 .="WHERE report_id = {$rep_id} ";
        $add_result_query = mysqli_query($connection, $query1);
        if(!$add_result_query) {
            die("QUERY Failed". mysqli_error($connection) );
        }
        if(!$add_report_query) {
            die("QUERY Failed". mysqli_error($connection) );
        }
        $report_action = "new report added";
        create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $report_action); 
       
        header('Location: reports.php');
        

    } 
?>
<!-- self appraiasl form -->
<?php
    if(isset($_POST['self_report'])){
        $evaluatorname = $_SESSION['name'];
        $evaluatorId = $_SESSION['id'];
        $evaluateeId = $_SESSION['id'];;
        
        $query = "SELECT * FROM appraisal_criterias";
        $criterias = mysqli_query($connection, $query);
        $nums = mysqli_num_rows($criterias);
        $query2 = "SELECT * FROM scales" ;
        $sel_all_post2 = mysqli_query($connection, $query2);
        if ($rows = mysqli_fetch_assoc($sel_all_post2)) {
            $maxScale  = $rows['maximum'];
            $maxScale = $maxScale;
            $minScale  = $rows['minimum'];
            $minScale = $minScale;
            $maxScale = $maxScale-$minScale;
        }
        $rep_id = hexdec(uniqid()); 
        while($row = mysqli_fetch_assoc($criterias)) {
            $id = $row['id'];
            
            $names = ucwords($row['name']);
            $comment = 'comment'.$names;
                
            $score= intval($_POST[$names]);
            $remark= trim($_POST[$comment]);
            
            $query = "INSERT INTO reports(report_id, criteria_id, evaluator_id, evaluatee_id, score, remark, max_scale)";
            $query .= "VALUES('$rep_id', '$id', '$evaluatorId', '$evaluateeId', '$score', '$remark', '$maxScale')";
        
            $add_report_query = mysqli_query($connection, $query);
        }   
        
        $q3 = "SELECT SUM(score) AS total, AVG(score) AS avg, SUM(max_scale) AS scaleScore FROM reports where report_id = '$rep_id'";
        $val2= mysqli_query($connection,$q3);
        
    


        if ($rows = mysqli_fetch_assoc($val2)) {
            $total  = $rows['total'];
            $avg  = round($rows['avg']);
            $scaleScore = $rows['scaleScore'];
            // $scaleScore = $scaleScore * $nums;
            global $result;
            $percentage = ($total/$scaleScore)*100;
            $remarK_query = "SELECT * FROM remarks";    
            $val3= mysqli_query($connection,$remarK_query);
            if ($rows = mysqli_fetch_assoc($val3)) {
                $twenty  = $rows['twenty'];
                $fourty  = $rows['fourty'];
                $sixty  = $rows['sixty'];   
                $eighty  = $rows['eighty'];
                $hundred  = $rows['hundred'];
                
                switch($percentage) {
                    case ($percentage<20):
                        $result = $twenty;
                        break;
                    case ($percentage>=20 && $percentage <40 ):
                        $result = $fourty;
                        break;
                    case ($percentage>=40 && $percentage <60 ):
                        $result = $sixty;
                        break;
                    case ($percentage>=60 && $percentage <80 ):
                        $result = $eighty;
                        break;
                    default:
                        $result = $hundred;
                        break;

                }   
                
            }
        }

        $query1 = "UPDATE reports SET ";
        $query1 .="result = '{$result}' ";
        $query1 .="WHERE report_id = {$rep_id} ";
        $add_result_query = mysqli_query($connection, $query1);
        if(!$add_result_query) {
            die("QUERY Failed". mysqli_error($connection) );
        }
        if(!$add_report_query) {
            die("QUERY Failed". mysqli_error($connection) );
        }
        $report_action = "new report added";
        create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $report_action); 
       
        header('Location: reports.php');
        die;

    } 
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
                        <?php include "includes/peertab.php" ?>
                    </div>
                    <!-- peer tab ends -->
                    <div class="tab-pane fade" id="custom-tabs-four-self" role="tabpanel" aria-labelledby="custom-tabs-four-self-tab">
                        <!-- self appraisal -->
                        <?php include "includes/selftab.php" ?>
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

<script>
    
    function handleValue(e, minimum, maximum, demo){
        if (e.value < minimum || e.value > maximum){ 
        e.style.borderColor = 'red';
        // document.getElementById("demo").innerHTML = "You wrote: ";   

        } else {
            e.style.borderColor = 'green'; 
        }
    }

    function handleFocus(ev) {
        ev.style.borderColor = 'green';
    }
</script>  
<?php include_once "includes/footer.php"?>

<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>