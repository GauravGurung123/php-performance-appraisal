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
            <form action="search_category.php" method="get">
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
                                $res_query = "SELECT * FROM fields";    
                                $value= mysqli_query($connection,$res_query);
                                echo '<option>'.$orderResult.'</option>';
                                while ($row = mysqli_fetch_assoc($value)) {
                                    $remark = $row['name'];
                                    ?>
                                    <option value="<?php echo $remark; ?>" ><?php echo $remark; ?></option>';
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
                    <th>Pay Raise</th>
                    <th>Total Score</th>
                    <th>Avg Score</th>
                    <th>Result</th>
                    <th>Remark</th>
                    <th>Action</th>
                    
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
                // if(!$orderResult=='-- select result --'){
                $date_query = "SELECT * FROM reports WHERE ((DATE(created_at) >= '$from' AND DATE(created_at)) <= '$to') AND (field_name = '$orderResult')  GROUP BY report_id";
                // } else {
                // $date_query1 = "SELECT * FROM reports WHERE DATE(created_at) >= '$from' AND DATE(created_at) <= '$to' GROUP BY report_id";
                // }
                $search_query = mysqli_query($connection, $date_query);

                if(!$search_query){
                    die("query failed" . mysqli_error($connection));
                }
            }

            while($row = mysqli_fetch_assoc($search_query)) { 
                global $sno;
                ++$sno;            
                $reportId = $row['report_id'];
                $reportId = trimWords($reportId);
                $a1 = $row['evaluator_id'];
                $a2 = $row['evaluatee_id'];
                $payRaise = $row['pay_raise'];
                $remark_r = $row['field_name'];
                $result = $row['result'];
                $created_at = $row['created_at'];
                $created_at = date("M j, Y", strtotime($created_at));
                echo"<tr>";
                ?>
                <td><?php echo $sno; ?></td>
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
                echo"<td>{$payRaise}%</td>";
               
                $q3 = "SELECT SUM(score) AS total, AVG(score) AS avg, SUM(max_scale) AS scaleScore FROM reports WHERE report_id = '$reportId'";
                $val2= mysqli_query($connection,$q3);
                
                if ($rows = mysqli_fetch_assoc($val2)) {
                    $total  = $rows['total'];
                    $avg  = round($rows['avg']);
                    $scaleScore = $rows['scaleScore'];
                    echo"<td>{$total}</td>";
                    echo"<td>{$avg}</td>";
                    echo"<td>{$remark_r}</td>";
                    echo"<td>{$result}</td>";
                }
                ?>
                <td><small>
                <a class='bg-success p-1' target="_blank" href="includes/report_detail.php?report_detail=<?php echo $reportId; ?>">view</a>
                <?php if (checkPermission()): ?>
                <a rel='<?php echo $reportId?>' class='del_link bg-danger p-1' href='javascript:void(0)'>del</a></small> 
                <?php endif; ?></td>
                <?php 
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