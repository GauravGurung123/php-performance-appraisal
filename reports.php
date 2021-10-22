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
                    <th>DateTime</th>
                    <th>Evaluator Name</th>
                    <th>Evaluatee Name</th>
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
                $eval_total_score = $row['eval_total_score'];
                $eval_score = $row['eval_score'];
                $eval_remarks = $row['eval_remarks'];

                echo"<tr>";
                echo"<td>{$eval_id}</td>";
                echo"<td>{$eval_datetime}</td>";
                echo"<td>{$evaluator_name}</td>";
                echo"<td>{$evaluatee_name}</td>";
                echo"<td><form method='get' id='myform' action='reports.php'>
                <input type='hidden' name='show' value='{$eval_id}' />
                <button type='submit' id='showdata' class='btn btn-sm btn-info' data-toggle='modal' 
                data-target='#modal-lg'>{$eval_total_score}</button>
                </form>
                </td>";
                echo"<td>{$eval_score}</td>";
                echo"<td>{$eval_remarks}</td>";
                }
                echo"</tr>";
        ?>
        <div class="modal fade" id="modal-lg"  tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
            <?php
             
                $id = $_GET['show'];
                $query = "SELECT * FROM eval_reports WHERE eval_id = '$id' ";
            $sel_report = mysqli_query($connection, $query);
            confirm($sel_report);
            if($row = mysqli_fetch_assoc($sel_report)) {
                $eval_id = $row['eval_id'];
                $eval_datetime = $row['eval_datetime'];
                $evaluator_name = ucwords($row['evaluator_name']);
                $evaluatee_name = ucwords($row['evaluatee_name']);
                $eval_punctuality = $row['eval_punctuality'];
                $eval_attendance = $row['eval_attendance'];
                $eval_accuracy = $row['eval_accuracy'];
                $eval_teamwork = $row['eval_teamwork'];
                $eval_leadership = $row['eval_leadership'];
                $eval_communication = $row['eval_communication'];
                $eval_creativity = $row['eval_creativity'];
                $eval_total_score = $row['eval_total_score'];
                $eval_score = $row['eval_score'];
                $eval_remarks = $row['eval_remarks'];
            echo "
              <h4 class='modal-title'>Performance Appraisal Report <span><small>Report ID : 00{$eval_id} || DateTime : {$eval_datetime} </small> </span></h4>
              <button  type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body'>";
                echo "
                <p>Evaluator : {$evaluator_name} || Evaluatee : {$evaluatee_name} </p>
                <hr>
                <p>Punctuality : {$eval_punctuality} </p>
                <p>Attendance : {$eval_attendance} </p>
                <p>Accuracy : {$eval_accuracy} </p>
                <p>Teamwork : {$eval_teamwork} </p>
                <p>Leadership : {$eval_leadership} </p>
                <p>Communication : {$eval_communication} </p>
                <p>Creativity : {$eval_creativity} </p>
                <hr>
                <p>Total Score : {$eval_total_score} || Average Score : {$eval_score} </p>
                <hr>
                <p>Remarks: {$eval_remarks} </P> 
                ";

                } 
            
            ?>
<script>
    window.onpageshow = function() {
        if (typeof window.performance != "undefined"
            && window.performance.navigation.type === 0) {
            $('#modal-lg').modal('show');
        }
    }
</script>
                
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

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