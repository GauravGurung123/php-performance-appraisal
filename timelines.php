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
                <!-- The time line -->
                <div class="timeline">
                    <?php
                        $query = "SELECT *, sum(score) as sc FROM reports  GROUP BY report_id ORDER BY created_at DESC";
                        $sel_reports = mysqli_query($connection, $query);

                        while($row = mysqli_fetch_assoc($sel_reports)) {
                            $a1 = $row['evaluator_id'];
                            $a2 = $row['evaluatee_id'];
                            $score = $row['sc'];
                            $max = $row['max_scale'];
                            $created_at = $row['created_at'];

                           ?> 
                            <!-- timeline time label -->
                            <div class="time-label">
                                <span class="bg-red"><?php echo date("Y M jS(D) h:i:s a", strtotime($created_at)); ?></span>
                            </div>
                            <!-- /.timeline-label -->
                            <div>
                            <i class="fas fa-user bg-green"></i>
                            <!-- timeline item -->  
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                                <h3 class='timeline-header no-border'>
                                <?php for($i=1;$i<3;$i++){
                                    $var = "a".$i;
                                    $q3 ="select username, name from staffs where id='".${$var}."'";
                                    $results = mysqli_query($connection,$q3);
                                    if($rows1=mysqli_fetch_assoc($results)){
                                        $n = ucwords($rows1['name']);
                                        echo "<a href='#'>{$n}</a>";
                                        if($i==2){
                                            break;
                                        }
                                        echo " rated ";
                                    }else { echo "{user removed}";}
                                }
                                echo " as " . "$score" . " out of ". "$max"; 
                                ?>&nbsp; </h3>
                            </div>
                            <!-- END timeline item -->
                        </div>

                        <?php
                        }
                    ?>  
                        
                </div>
                <!-- END timeline  -->

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    </div>
    <!-- /.content-wrapper -->

<?php include "includes/footer.php" ?>
<?php
//delete department query
if(isset($_GET['delete'])) {
    $log_action="department deleted";
    $the_id = mysqli_real_escape_string($connection,$_GET['delete']);

    $query = "DELETE FROM departments where id = {$the_id} ";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 
    $del_query = mysqli_query($connection, $query);
    header('Location: '.$_SERVER['PHP_SELF']);
    die;

}

?>
<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>