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
            <button class="btn btn-success"><a class="text-white" href="add_staff.php">Perform Evaluation</a></button>
            <?php
// if(isset($_GET['source'])) {
//     $source = $_GET['source']; 
// } else {
//     $source = '';
// }
// switch($source) {  
    // case 'add_user';
    // include "includes/add_user.php";
    // break;
//     case 'edit_user';
//     include "includes/edit_staff.php";
//     break;
//     case '200';
//     echo "nice 200";
//     break;
//     default:
//     // include "users.php";
//     break;
// }

?>
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
                    <th>DateTime</th>
                    <th>Evaluator Name</th>
                    <th>Evaluatee Name</th>
                    <th>Punctuality</th>
                    <th>Attendance</th>
                    <th>Accuracy</th>
                    <th>Teamwork</th>
                    <th>Leadership</th>
                    <th>Communication</th>
                    <th>Creativity</th>
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

            $report_query_count = "SELECT * FROM eval_reports";
            $do_count = mysqli_query($connection, $report_query_count);
            $count = mysqli_num_rows($do_count);
            $count = ceil($count / $per_page);

            $query = "SELECT * FROM eval_reports ORDER BY eval_datetime LIMIT $page_1, $per_page";
            $sel_reports = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($sel_reports)) {
                $eval_id = $row['eval_id'];
                $eval_datetime = $row['eval_datetime'];
                $evaluator_name = ucwords($row['evaluator_name']);
                $evaluatee_name = ucfirst($row['evaluatee_name']);
                $eval_punctuality = $row['eval_punctuality'];
                $eval_accuracy = $row['eval_accuracy'];
                $eval_teamwork = $row['eval_teamwork'];
                $eval_leadership = $row['eval_leadership'];
                $eval_communication = $row['eval_communication'];
                $eval_creativity = $row['eval_creativity'];
                $eval_total_score = $row['eval_total_score'];
                $eval_score = $row['eval_score'];
                $eval_remarks = $row['eval_remarks'];

                echo"<tr>";
                echo"<td>{$eval_id}</td>";
                echo"<td>{$eval_datetime}</td>";
                echo"<td>{$evaluator_name}</td>";
                echo"<td>{$evaluatee_name}</td>";
                echo"<td>{$eval_punctuality}</td>";
                echo"<td>{$eval_accuracy}</td>";
                echo"<td>{$eval_teamwork}</td>";
                echo"<td>{$eval_leadership}</td>";
                echo"<td>{$eval_communication}</td>";
                echo"<td>{$eval_creativity}</td>";
                echo"<td>{$eval_total_score}</td>";
                echo"<td>{$eval_score}</td>";
                echo"<td>{$eval_remarks}</td>";
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