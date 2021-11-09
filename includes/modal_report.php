<div class="modal fade" style="margin-top: -10px;" id="modal-xl">
<?php
//get reports query
if(isset($_GET['retrieve'])) {
    
    $the_rep_id = mysqli_real_escape_string($connection,$_GET['retrieve']);
    ?><script>
    $(document).ready(function(){
        $("#modal-xl").modal('show');
    });
    </script>
    <?php
    
    $query = "SELECT *, SUM(score) as sc, AVG(score) AS avg, SUM(MAX_SCALE) AS mxscale FROM reports where report_id='{$the_rep_id}'";
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content p-4">
        <div class="modal-header">
            <h4 class="modal-title">Performance Appraisal Report <small>of &nbsp;<?php echo $created_at; ?></small></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
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
                        <dd class="col-sm-2">'.$name1.'<small>('.$username.')</small></dd>
                        ';} else {
                            echo'
                            <dt >Evaluatee Name:</dt>
                            <dd class="col-sm-2">'.$name1.'<small>('.$username.')</small></dd>
                            </dl>';
                        }
                    }
                }
                $department ="select name from departments where id='".$deptId."'";
                $results_dept = mysqli_query($connection,$department);
                if($rows2=mysqli_fetch_assoc($results_dept)){
                    $departName = ucwords($rows2['name']); 
                }
                echo'<dl class="row">
                    <dt >Designation:</dt>
                    <dd class="col-sm-4">'.$designation.'</dd>
                    <dt >Department:</dt>
                    <dd class="col-sm-4">'.$departName.'</dd>
                    </dl>';
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
        <div class="modal-footer justify-content-between">
            <a href="reports.php" class="btn btn-danger">Cancel</a>
            <a href="" class="btn btn-default modal_download_rep" style="float: right;">Download report</a>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->