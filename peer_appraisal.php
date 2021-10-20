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
            <div class="row mb-2">
            <p class="display-4">Perform Evaluation</p>   
            </div>
            <!-- /.row -->
            <div class="row mb-2">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Peer Evaluation Form</h3>
                </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                <form class="form-horizontal" action="" method="post">
        <div class="card-body">
            <div class="form-group row">
                <label for="exampleEvaluatorname" class="col-sm-6 col-form-label">Evaluator Name</label>
                <div class="col-sm-6">
                <input type="text" name="evaluatorname" class="form-control" 
                id="exampleEvaluatorname" value="<?php echo $_SESSION['staff_username']; ?>" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="exampleEvaluateename" class="col-sm-6 col-form-label">Evaluatee Name</label>
                <div class="col-sm-6">
                <select class="form-control select2" style="width: 100%;">
                <?php

                    $query = "SELECT * from staffs";
                    $sel_staffs = mysqli_query($connection, $query);
                    confirm($sel_staffs);
                    while($row = mysqli_fetch_assoc($sel_staffs)) {
                        $staff_id = $row['staff_id'];
                        $staff_name = $row['staff_name'];
                        $staff_username = $row['staff_username'];

                        echo '<option value="'. $staff_id .'"' . ($_SESSION['staff_username']=='' . $staff_username . ''  ? 'disabled="disabled"' : ''). '>' . $staff_name .'</option>';

                    }

                    ?>
                    
                  </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="examplePunctuality" class="col-sm-6 col-form-label">Punctuality</label>
                <div class="col-sm-6">
                <input type="number" name="evaluatorname" class="form-control" 
                id="examplePunctuality" placeholder="1 to 10">
                </div>
            </div>
            
  
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" name="submitscore" class="btn btn-info">Submit</button>
        </div>
        <!-- /.card-footer -->
      </form>
  </div>
   
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</div>
<!-- /.content-wrapper -->

  
<?php include_once "includes/footer.php"?>

<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>