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
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

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
                <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Created At</th>
                    <th>Evaluator Name</th>
                    <th>Evaluatee Name</th>
                    <?php
                    global $head_id;
                    $query = "SELECT * from appraisal_criterias";
                    $criterias = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($criterias)) {
                        $head_id = $row['id'];
                        $names = ucwords($row['name']);
                        echo "<th>{$names}</th>";
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
            $group_count = "SELECT COUNT(report_id) FROM `reports` GROUP BY report_id LIMIT 1";
            $group_count = mysqli_query($connection, $group_count);
            $do_count = mysqli_query($connection, $report_query_count);
            $count = mysqli_num_rows($do_count);
            $count = ceil($count / $per_page);

            $query = "SELECT  report_id,evaluator_id, evaluatee_id, created_at FROM reports GROUP BY report_id";
            $sel_reports = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($sel_reports)) {
                
                // $id = $row['id'];
                $reportId = $row['report_id'];
         

                $a1 = $row['evaluator_id'];
                $a2 = $row['evaluatee_id'];

               
                // $score = $row['score'];
                // $remark = $row['remark'];
                $created_at = $row['created_at'];

                

                echo"<tr>";
                echo"<td>{$reportId}</td>";
                // echo"<td>{$count}</td>";

                echo"<td>{$created_at}</td>";

                 for($i=1;$i<3;$i++){
                $var = "a".$i;
                $q3 ="select username from staffs where id='".${$var}."'";
                $results = mysqli_query($connection,$q3);
                while($rows1=mysqli_fetch_assoc($results)){

                    echo"<td>{$rows1['username']}</td>";

                }
            }

                $q2 = "select remark,score from reports where report_id = '$reportId' ";
                $val= mysqli_query($connection,$q2);
                while($rows=mysqli_fetch_assoc($val)){
                    // $p = $rows['criteria_id'];
                    $q= $rows['score'];
                    $r = $rows['remark'];

                    ?>

                    <td><?php echo $q ;?><br>(<small> <?php echo $r ;?> </small> )</td>
                    

                    
                    <?php
                }
                
                $q3 = "select sum(score) as total, AVG(score) as avg from reports where report_id = '$reportId' ";
                $val2= mysqli_query($connection,$q3);
                
                if ($rows = mysqli_fetch_assoc($val2)) {
                    $total  = $rows['total'];
                    $avg  = round($rows['avg']);
                echo"<td><form method='get' id='myform' action='reports.php'>
                <input type='hidden' name='show' value='id' />
                <button type='submit' id='showdata' class='btn btn-sm btn-info' data-toggle='modal' 
                data-target='#modal-lg'>{$total}</button>
                </form>
                </td>";
                echo"<td>{$avg}</td>";
                echo"<td>{remark}</td>";
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

<?php include "includes/footer.php" ?>

<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>