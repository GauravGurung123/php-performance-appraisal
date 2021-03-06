
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
    <div class="container p-4">
        <?php 

        if(isset($_GET['report_detail'])) {
            
            $the_rep_id = mysqli_real_escape_string($connection,$_GET['report_detail']);
            
            
            $query = "SELECT *, SUM(score) as sc, AVG(score) AS avg, SUM(MAX_SCALE) AS mxscale FROM reports where report_id='{$the_rep_id}' ";
            $sel_reports = mysqli_query($connection, $query);

            if($row = mysqli_fetch_assoc($sel_reports)) {   
                global $sn;
                $reportId = $row['report_id'];
                $payRaise = $row['pay_raise'];
                $total = $row['sc'];
                $avg  = round($row['avg']);
                $remark = $row['field_name'];
                $maxScale = $row['mxscale'];
                $reportId = trimWords($reportId);
                $a1 = $row['evaluator_id'];
                $a2 = $row['evaluatee_id'];
                $created_at = $row['created_at'];
                $created_at_date = date("M j, Y", strtotime($created_at));

            }
        }
        ?>
        <div class="card-footer p-0 justify-content-between" style="background-color:transparent;" id="hide-save">
            <a href="javascript:window.open('','_self').close();" class="btn btn-default mr-2">Close</a>
            <a href="" onclick="document.getElementById('hide-save').style.visibility= 'hidden';window.print();" class="btn btn-default" id="save-btn">Download | Print</a>
        </div>

        <div class="card p-3" id="card">
        
            <div class="card-header">
                    <h5 class="card-title" style="margin-left: -5px">Performance Appraisal Report <small>of &nbsp;<?php echo $created_at; ?></small></h5>
            </div>
            <div class="card-body">
                <?php
                    for($i=1;$i<3;$i++){
                        $var = "a".$i;
                        $q3 ="select * from staffs where id='".${$var}."'";
                        $results = mysqli_query($connection,$q3);
                        if($rows1=mysqli_fetch_assoc($results)){
                            $name1 = ucwords($rows1['name']); 
                            $designation = ucwords($rows1['designation']); 
                            $username = $rows1['username'];
                            $deptId = $rows1['dept_id'];
                            if ($i==1){  
                            echo'<dl class="row">
                            <dt>Evaluator Name:</dt>
                            <dd class="col-sm-4">'.$name1.'<small>('.$username.')</small></dd>
                            ';} else {
                                echo'
                                <dt >Evaluatee Name:</dt>
                                <dd class="col-sm-4">'.$name1.'<small>('.$username.')</small></dd>
                                </dl>';
                            }
                        }
                    }
                        $department ="select name from departments where id='".$deptId."'";
                        $results_dept = mysqli_query($connection,$department);
                        if($rows2=mysqli_fetch_assoc($results_dept)){
                            $departName = ucwords($rows2['name']); 
                        }
                    echo'       <dl class="row">
                                <dt >Designation:</dt>
                                <dd class="col-sm-4">'.$designation.'</dd>
                                <dt >Department:</dt>
                                <dd class="col-sm-4">'.$departName.'</dd>
                                </dl>';

                ?>
                <hr>
                <dl class='row'>
                    <dt class="col col-1">S/N</dt>
                    <dt class="col col-3">Appraisal Criteria </dt>
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
                        echo "<dl class='row'><dt class='col col-1'>{$sn}</dt><dt class='col col-3'>{$names}</dt>";
                    }
                    $q2 = "SELECT criteria_id, remark,score, field_name FROM reports WHERE report_id = '$reportId'";
                    $val= mysqli_query($connection,$q2);
                    while($rows=mysqli_fetch_assoc($val)){
                        $score= $rows['score'];
                        $c_id = $rows['criteria_id'];
                        $result = $rows['field_name'];
                        $remark = $rows['remark'];
                        if($ac_id==$c_id){
                            echo"<dd class='col-sm-2'>{$score}<span>&nbsp;(<small>{$remark}</small> )</span></dd></dl>";
                        }
                    }
                }
                ?>
                <hr>
                <dl class='row'>
                    <dt>Total Score: </dt>
                        <dd class='col-sm-2'><?php echo $total. " out of " . $maxScale; ?></dd>
                    <dt>Average Score: </dt>
                        <dd class='col-sm-2'><?php echo $avg; ?></dd>
                    <dt>Result: </dt>
                        <dd class='col-sm-2'><?php echo $result; ?></dd>
                </dl>
                <dl class='row'>
                    <dt>Pay Raise: </dt>
                        <dd class='col-sm-2'><?php echo $payRaise; ?>%</dd>
                    
                </dl>
                <p class="pr-4" style="float: right;"><u>Signature</u><br><small>
                <?php 
                $sign = "SELECT * FROM staffs WHERE id = '{$a1}'";
                $staff_info= mysqli_query($connection,$sign);
                if($rows=mysqli_fetch_assoc($staff_info)){
                    $staffName = $rows['name'];
                    $designation = $rows['designation'];
                    echo $staffName.'<br>'.$designation.'('.$departName.')';
                }
                ?></small>
            </p>
        </div>
    
        
    </div>
        <!-- /.card -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

    </body>
</html>
<style>
    @page
    {
        size: A4;
        margin: 0;
    }
    #card {
        /* Add shadows to create the "card" effect */
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
    }
</style>

