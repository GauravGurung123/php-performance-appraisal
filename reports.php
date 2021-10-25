<?php include_once "includes/header.php" ?>
<?php if(isLoggedIn()): ?>

<!-- Navigation -->
<?php include_once "includes/nav.php" ?>
<!-- /.Navigation -->
<!-- Sidebar -->
<?php include_once "includes/sidebar.php" ?>
<!-- /.sidebar -->


<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
            <div class="row">
                <p class="display-4">Performance Appraisal Reports</p>
            </div>
            <button class="btn btn-success"><a class="text-white" href="peer_appraisal.php">Perform Evaluation</a></button>
            


            <!-- /.row -->
        <div class="row mt-2">
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Show 
    <select name="page_no" id="">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select> Entries
</h3> 

                <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" id="myInput" name="table_search" class="form-control float-right" placeholder="Search"
                    onkeyup="searchFun()">                    

                    <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                    </div>
                </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="myTable" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Created At</th>
                    <th>Evaluator UserName</th>
                    <th>Evaluatee UserName</th>
                    <?php
                    $query = "SELECT DISTINCT(criteria_id) as crit_id from reports";
                    $criterias = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($criterias)) {
                        $critId = $row['crit_id'];

                        $query = "SELECT * from appraisal_criterias WHERE id = '$critId'";
                        $col_crit = mysqli_query($connection, $query);
                        if($row = mysqli_fetch_assoc($col_crit)) {
                            $names = ucwords($row['name']);
                            echo "<th>{$names}</th>";
                        }
                    }
            ?>
                    <th>Total Score</th>
                    <th>Average Score</th>
                    <th>Remarks</th>
                    
                </tr>
                </thead>
                <tbody>
        <?php
            $per_page = 5;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else { $page = ""; }

            if ($page == "" || $page == 1) {
                $page_1 = 0;
            } else {
                $page_1 = ($page * $per_page) - $per_page;
            }

            $report_query_count = "SELECT DISTINCT report_id FROM reports";
            $do_count = mysqli_query($connection, $report_query_count);
            $count = mysqli_num_rows($do_count);
            $count = ceil($count / $per_page);

            $query = "SELECT  report_id,evaluator_id, evaluatee_id, created_at FROM reports GROUP BY report_id";
            $sel_reports = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($sel_reports)) {             
                $reportId = $row['report_id'];
                $a1 = $row['evaluator_id'];
                $a2 = $row['evaluatee_id'];
                $created_at = $row['created_at'];
           
                echo"<tr>";
                echo"<td class='text-center'>{$reportId}<br><small>
                <a class='bg-danger p-1' href='reports.php?delete={$reportId}'>del</a></small></td>";
                echo"<td>{$created_at}</td>";
                for($i=1;$i<3;$i++){
                    $var = "a".$i;
                    $q3 ="select username, name from staffs where id='".${$var}."'";
                    $results = mysqli_query($connection,$q3);
                    while($rows1=mysqli_fetch_assoc($results)){

                        echo"<td>{$rows1['username']}<br>({$rows1['name']})</td>";

                    }
                }
                $addCol = "SELECT COUNT(DISTINCT(criteria_id)) AS count FROM reports";
                $res = mysqli_query($connection,$addCol);
                while($rows=mysqli_fetch_assoc($res)){
                    $tc =  $rows['count'];
                    $tc1= $tc;
                    while($tc>=1){
                
                        $q2 = "SELECT criteria_id, remark,score FROM reports WHERE report_id = '$reportId'";
                        $val= mysqli_query($connection,$q2);
                        $c1=0;
                        $c2=0;
                            while($rows=mysqli_fetch_assoc($val)){
                                $c1=$c1+1; 
                                $q= $rows['score'];
                                $r = $rows['remark'];
                                global $g;
                                if($g){ break; }
                                $c2=$c2+1;
                                
                                echo"<td>{$q}<br>(<small>{$r}</small> )</td>";
                                
                            }
                                
                            $g=true;
                            $tc = $tc - 1 - $c2;
                            if(!($tc1==$c1)){
                            echo "<td>N/A</td>";
                            }
                    }
                    $g=false;
                      
                }
                $q3 = "SELECT SUM(score) AS total, AVG(score) AS avg, SUM(max_scale) AS scaleScore, overall_remark FROM reports WHERE report_id = '$reportId'";
                $val2= mysqli_query($connection,$q3);
                
                if ($rows = mysqli_fetch_assoc($val2)) {
                    $total  = $rows['total'];
                    $avg  = round($rows['avg']);
                    $scaleScore = $rows['scaleScore'];
                    $overallRemark  = $rows['overall_remark'];

                    $percentage = ($total/$scaleScore)*100;
                    echo"<td>{$total}</td>";
                    echo"<td>{$avg}</td>";
                    
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
                                echo"<td>{$twenty}</td>";
                                break;
                            case ($percentage>=20 && $percentage <40 ):
                                echo"<td>{$fourty}</td>";
                                break;
                            case ($percentage>=40 && $percentage <60 ):
                                echo"<td>{$sixty}</td>";
                                break;
                            case ($percentage>=60 && $percentage <80 ):
                                echo"<td>{$eighty}</td>";
                                break;
                            default:
                                echo"<td>{$hundred}</td>";
                                break;

                        }   
                        
                    }
                }
            }
                echo"</tr>";
        ?>
        
                </table>
            

                <div class="row mt-3">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                    Showing 1 to 4 of 15 entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">

                                    <ul class="pagination">

<?php
    for ($i=1; $i<=$count; $i++) {
        if ($i == $page ){
        echo "<li class='paginate_button page-item active'><a class='page-link active' href='reports.php?page={$i}'>{$i}</a>";
        } else {
        echo "<li class='paginate_button page-item'><a class='page-link' href='reports.php?page={$i}'>{$i}</a>";
       
        }
    }
?>
  </ul>
                                </div>
                            </div>
                        </div> 
<!-- ./row mt-3 -->


            </div>
            <!-- /.card-body -->
        </div>
        </div>
        <!-- /.card -->
        </div>
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->


        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<script>
    const searchFun = ()=>{
        let filter = document.getElementById('myInput').value.toUpperCase();
        let myTable = document.getElementById('myTable');
        let tr = myTable.getElementsByTagName('tr');
        var colCount = document.getElementById("myTable").rows[0].cells.length;


        for(var ite=0; ite<tr.length; ite++){
            let td = tr[ite].getElementsByTagName('td')[3];
            let td2 = tr[ite].getElementsByTagName('td')[colCount - 1];
            let td3 = tr[ite].getElementsByTagName('td')[colCount - 2];

            if(td || td2 || td3) {
                let textvalue = td.textContent || td.innerHTML;
                let textvalue2 = td2.textContent || td2.innerHTML;
                let textvalue3 = td3.textContent || td3.innerHTML;
                if((textvalue.toUpperCase().indexOf(filter) > -1) || (textvalue2.toUpperCase().indexOf(filter) > -1) || (textvalue3.toUpperCase().indexOf(filter) > -1)){
                    tr[ite].style.display ="";
                }else {
                    tr[ite].style.display = "none"
                }
            }
        }
    }
</script>

<?php include "includes/footer.php" ?>
<?php
//delete reports query
if(isset($_GET['delete'])) {
    $log_action="report deleted";
    $the_id = mysqli_real_escape_string($connection,$_GET['delete']);

    $query = "DELETE FROM reports where report_id = '{$the_id}'";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 
    $del_report_query = mysqli_query($connection, $query);
    header('Location: '.$_SERVER['PHP_SELF']);
    die;

}

?>


<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>