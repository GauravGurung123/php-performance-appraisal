<?php include_once "includes/header.php" ?>
<?php if(isLoggedIn()): ?>

<!-- Navigation -->
<?php include_once "includes/nav.php" ?>
<!-- /.Navigation -->
<!-- Sidebar -->
<?php include_once "includes/sidebar.php" ?>
<!-- /.sidebar -->
<?php
if(isset($_GET['search'])) {
                $orderDate = $_GET['order_date'];
                $orderResult = $_GET['order_result'];
                
                $toFrom = explode(' - ',$orderDate);
                $from = $toFrom['0'];
                $to = $toFrom['1'];
}?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
            <div class="row">
                <p>Searched Result &nbsp; <a href="reports.php" class="bg-warning">back</a></p>
                <?php include("includes/modal_delete.php"); ?>
            </div>
            <!-- Date range -->
            <form action="search_category.php" method="post">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label>Date range:</label>
                        <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" value="<?php echo $orderDate; ?>" name = "order_date" class="form-control float-right" id="reservation">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label>Sort Result:</label>
                        <div class="input-group">
                        <select name="order_result" class="form-control select2" style="width: 100%;">
                        <?php 
                                $res_query = "SELECT * FROM remarks";    
                                $value= mysqli_query($connection,$res_query);
                                if ($row = mysqli_fetch_assoc($value)) {
                                    $twenty = $row['twenty'];
                                    $fourty = $row['fourty'];
                                    $sixty = $row['sixty'];
                                    $eighty = $row['eighty'];
                                    $hundred = $row['hundred'];
                                    ?>
                                    <option ><?php echo $orderResult; ?></option>';
                                    <option value="<?php echo $twenty; ?>" ><?php echo $twenty; ?></option>';
                                    <option value="<?php echo $fourty; ?>" ><?php echo $fourty; ?></option>';
                                    <option value="<?php echo $sixty; ?>" ><?php echo $sixty; ?></option>';
                                    <option value="<?php echo $eighty; ?>" ><?php echo $eighty; ?></option>';
                                    <option value="<?php echo $hundred; ?>" ><?php echo $hundred; ?></option>';
                                    <?php
                                }
                            ?>    
                        </select>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <label></label><br>
                    <button type="submit" name="search" class="btn btn-sm btn-primary mt-2">Search</button>
                </div>
            </div>
            <!-- row ended -->

            </form>



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
            <div class="card-body" id="date_order"  style="overflow: scroll">
                <table id="myTable" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Created At</th>
                    <th>Evaluator</th>
                    <th>Evaluatee</th>
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
                    <th>Result</th>
                    
                </tr>
                </thead>
                <tbody>
        <?php

            if(isset($_GET['search'])) {
                $orderDate = $_GET['order_date'];
                $orderResult = $_GET['order_result'];
                
                $toFrom = explode(' - ',$orderDate);
                $from = $toFrom['0'];
                $to = $toFrom['1'];
                if(!$orderResult=='-- select result --'){
                $date_query = "SELECT * FROM reports WHERE ((DATE(created_at) >= '$from' AND DATE(created_at)) <= '$to') AND (result = '$orderResult')  GROUP BY report_id";
                } else {
                $date_query = "SELECT * FROM reports WHERE DATE(created_at) >= '$from' AND DATE(created_at) <= '$to' GROUP BY report_id";
                }
                $search_query = mysqli_query($connection, $date_query);

                if(!$search_query){
                    die("query failed" . mysqli_error($connection));
                }
            }

            while($row = mysqli_fetch_assoc($search_query)) { 
                global $sn;
                ++$sn;            
                $reportId = $row['report_id'];
                $reportId = trimWords($reportId);
                $a1 = $row['evaluator_id'];
                $a2 = $row['evaluatee_id'];
                
                $created_at = $row['created_at'];
                $created_at = date("M j, Y", strtotime($created_at));
                echo"<tr>";
                ?>
                <td class='text-center'><?php echo $sn; ?>
                <?php if (is_superadmin($_SESSION['username']) || is_admin($_SESSION['username'])): ?>
                <br><small>
                <a rel='<?php echo $reportId?>' class='del_link bg-danger p-1' href='javascript:void(0)'>del</a></small> 
                <?php endif; ?></td>
                <?php
                echo"<td>{$created_at}</td>";
                for($i=1;$i<3;$i++){
                    $var = "a".$i;
                    $q3 ="select username, name from staffs where id='".${$var}."'";
                    $results = mysqli_query($connection,$q3);
                    while($rows1=mysqli_fetch_assoc($results)){
                        $name1 = ucwords($rows1['name']);   
                        echo"<td>{$name1}<br> <small>({$rows1['username']})</small></td>";

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
                                $r = trimWords($r);
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
                $q3 = "SELECT SUM(score) AS total, AVG(score) AS avg, SUM(max_scale) AS scaleScore FROM reports WHERE report_id = '$reportId'";
                $val2= mysqli_query($connection,$q3);
                
                if ($rows = mysqli_fetch_assoc($val2)) {
                    $total  = $rows['total'];
                    $avg  = round($rows['avg']);
                    $scaleScore = $rows['scaleScore'];

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
$(document).ready(function(){
    $(".del_link").on('click', function(){
        var delIds = $(this).attr("rel");
        var delUrls = "reports.php?delete="+ delIds +" ";

        $(".modal_del_link").attr("href", delUrls);

        $("#modal-sm").modal('show');
        
    });
});

  $(function () {
    //Date range picker
    $('#reservation').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }    
    })
  });
    const searchFun = ()=>{
        let filter = document.getElementById('myInput').value.toUpperCase();
        let myTable = document.getElementById('myTable');
        let tr = myTable.getElementsByTagName('tr');
        var colCount = document.getElementById("myTable").rows[0].cells.length;


        for(var ite=0; ite<tr.length; ite++){
            let td = tr[ite].getElementsByTagName('td')[2];
            let td2 = tr[ite].getElementsByTagName('td')[3];
            let td3 = tr[ite].getElementsByTagName('td')[colCount - 1];

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