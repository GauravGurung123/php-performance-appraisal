<?php ob_start(); ?>
<?php include "dbconfig.php"; ?>
<?php include "functions.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>AdminLTE 3 | Dashboard</title>

<!-- Google Font: Source Sans Pro -->
<link
rel="stylesheet"
href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
/>
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
<!-- Ionicons -->
<link
rel="stylesheet"
href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"
/>
<!-- Tempusdominus Bootstrap 4 -->
<link
rel="stylesheet"
href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"
/>
<!-- iCheck -->
<link
rel="stylesheet"
href="../plugins/icheck-bootstrap/icheck-boo../plugins/jqvmap/jqvmap.min.css" />
<!-- Theme style -->
<link rel="stylesheet" href="../dist/css/adminlte.min.css" />


</head>

<body>
    <div class="container">
        <?php
        if(isset($_GET['report_detail'])) {
            
            $the_rep_id = mysqli_real_escape_string($connection,$_GET['report_detail']);
            
            
            $query = "SELECT *, SUM(score) as sc, AVG(score) AS avg, SUM(MAX_SCALE) AS mxscale FROM reports where report_id='{$the_rep_id}'";
            $sel_reports = mysqli_query($connection, $query);

            if($row = mysqli_fetch_assoc($sel_reports)) {   
                global $sn;
                $reportId = $row['report_id'];
                $payRaise = $row['pay_raise'];
                $total = $row['sc'];
                $avg  = round($row['avg']);
                $result = $row['result'];
                $maxScale = $row['mxscale'];
                $reportId = trimWords($reportId);
                $a1 = $row['evaluator_id'];
                $a2 = $row['evaluatee_id'];
                $created_at = $row['created_at'];
                $created_at_date = date("M j, Y", strtotime($created_at));

            }
        }
        ?>
        <div class="card p-3 mt-5">
            <div class="card-header">
                    <h4 class="card-title">Performance Appraisal Report <small>of &nbsp;<?php echo $created_at; ?></small></h4>
            </div>
            <div class="card-body">
                <?php
                    for($i=1;$i<3;$i++){
                        $var = "a".$i;
                        $q3 ="select username, name from staffs where id='".${$var}."'";
                        $results = mysqli_query($connection,$q3);
                        if($rows1=mysqli_fetch_assoc($results)){
                            $name1 = ucwords($rows1['name']); 
                            $username = $rows1['username'];
                            if ($i==1){  
                            echo'<dl class="row">
                            <dt>Evaluator Name:</dt>
                            <dd class="col-sm-2">'.$name1.'<small>('.$username.')</small></dd>
                            ';} else {
                                echo'
                                <dt >Evaluatee Name:</dt>
                                <dd class="col-sm-2">'.$name1.'<small>('.$username.')</small></dd>
                                </dl>';
                            }
                        }
                    }
                ?>
                <hr>
                <dl class='row'>
                    <dt class="col col-1">S/N</dt>
                    <dt class="col col-3">Appraisal Criterias </dt>
                    <dt class="col col-4">Score: </dt>
                </dl>
                <?php
                $query = "SELECT DISTINCT(criteria_id) as crit_id from reports";
                $criterias = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($criterias)) {
                    $critId = $row['crit_id'];
                    ++$sn;
                    $query = "SELECT * from appraisal_criterias WHERE id = '$critId'";
                    $col_crit = mysqli_query($connection, $query);
                    if($row = mysqli_fetch_assoc($col_crit)) {
                        $ac_id= $row['id'];
                        $names = ucwords($row['name']);
                        echo "<dl class='row'><dt class='col col-1'>{$sn}</dt><dt class='col col-3'>{$names}&nbsp:</dt>";
                    }
                    $q2 = "SELECT criteria_id, remark,score, field_name FROM reports WHERE report_id = '$reportId'";
                    $val= mysqli_query($connection,$q2);
                    while($rows=mysqli_fetch_assoc($val)){
                        $score= $rows['score'];
                        $c_id = $rows['criteria_id'];
                        $remark = $rows['remark'];
                        if($ac_id==$c_id){
                            echo"<dd class='col-sm-2'>{$score}<span>(<small>{$remark}</small> )</dd></dl>";
                        }
                    }
                }
                ?>
                <hr>
                <dl class='row'>
                    <dt>Total Obtained Score: </dt>
                        <dd class='col-sm-2'><?php echo $total. " out of " . $maxScale; ?></dd>
                    <dt>Average Score: </dt>
                        <dd class='col-sm-2'><?php echo $avg; ?></dd>
                    <dt>Pay Raise: </dt>
                        <dd class='col-sm-2'><?php echo $payRaise; ?></dd>
                </dl>
                <p class="pr-4" style="float: right;"><u>Signature</u><br><small>
                <?php 
                $sign = "SELECT * FROM staffs WHERE id = '{$a1}'";
                $staff_info= mysqli_query($connection,$sign);
                if($rows=mysqli_fetch_assoc($staff_info)){
                    $staffName = $rows['name'];
                    $designation = $rows['designation'];
                    echo $staffName.'<br>('.$designation.')';
                }
                ?></small>
            </p>
        </div>
        <div class="card-footer justify-content-between">
            <a href="../reports.php" class="btn btn-danger">Cancel</button>
            <a href="" class="btn btn-default modal_download_rep" style="float: right;">Download report</button>
        </div>
    </div>
        <!-- /.card -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

    </body>
</html>
