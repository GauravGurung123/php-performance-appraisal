<?php include_once "includes/header.php" ?>
<?php if(isLoggedIn() && checkPermission()): ?>

<!-- Navigation -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            <div class="row text-center mb-2">
                <p class="display-4">All Logs</p>
            </div>
<!-- /.row -->
    <?php
    global $count;
    global $per_page;

    if(isset($_GET['submitEntry'])){
        $per_page = $_GET['show_entry'];
    }else{ $per_page = 6;}
    $query_count = "SELECT * FROM logs";
    $do_count = mysqli_query($connection, $query_count);
    $count = mysqli_num_rows($do_count);
    ?>
        <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                <form method="get" action="">
                Show <select id="selEntry" name="show_entry">
                    <option value="<?php echo $per_page ?>"><?php echo $per_page ?></option>
                        <option value="6">6</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="<?php echo $count ?>">all</option>
                    </select><button type="submit" name="submitEntry">Entries</submit>
                </form>

    
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
                    <th>Created At</th>
                    <th>Username</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                    <th>Log Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
              
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } else { $page = ""; }

                    if ($page == "" || $page == 1) {
                        $page_1 = 0;
                    } else {
                        $page_1 = ($page * $per_page) - $per_page;
                    }

                   
                   
                    $count = ceil($count / $per_page);
                     
                    $query = "SELECT * FROM logs ORDER BY created_at DESC LIMIT $page_1, $per_page";
                    $sel_logs = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($sel_logs)) {

                    $createdAt = $row['created_at'];
                    $ip = $row['ip'];
                    $username = $row['username'];
                    $action = $row['action'];
                    $useragent = $row['useragent'];

                    echo "<tr>";
                    echo "<td>$createdAt</td>";
                    echo "<td>$username</td>";
                    echo "<td>$ip</td>";
                    echo "<td>$useragent</td>";  
                    echo "<td>$action</td>";
                    }
            ?>
            </table>
            <div class="row mt-3">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                    Showing 1 to 6 of <?php echo $count ?> entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">

                                    <ul class="pagination">

<?php
    for ($i=1; $i<=$count; $i++) {
        if ($i == $page ){
        echo "<li class='paginate_button page-item active'><a class='page-link active' href='logs.php?page={$i}'>{$i}</a>";
        } else {
        echo "<li class='paginate_button page-item'><a class='page-link' href='logs.php?page={$i}'>{$i}</a>";
       
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
