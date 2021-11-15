<?php include_once "../includes/dbconfig.php"; ?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
<?php
    if ($_GET['showIds']!=""){
        $showIds = trim($_GET['showIds']);
        $query="SELECT s.name AS name, s.designation as designation, d.name AS department FROM `staffs` AS s INNER JOIN departments AS d ON s.dept_id = $showIds GROUP BY s.name;";
        $sel_department = mysqli_query($connection, $query);
        if (mysqli_num_rows($sel_department) > 0) {
            while($row = mysqli_fetch_assoc($sel_department)) {
                global $ide;
                ++$ide;
                // $id = $row['id'];
                $name = ucwords($row['name']);
                $department = ucwords($row['department']);

                if($ide===1){    
                ?>
                <h4 class="modal-title">Department: <?php  echo $department; ?> </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div> <!-- modal header ended -->
                    <div class="modal-body">
                        <div class="row">
                            
                    <?php } ?>
                    
                            <div class="col-3 dep-staff">
                            <?php echo $name; ?>
                            </div>
                <?php
            }   //loop ended
        } 
// if there is no employee in department
$query_name="SELECT name AS department FROM `staffs` WHERE id = $showIds;";
$sel_name = mysqli_query($connection, $query_name);
if($row = mysqli_fetch_assoc($sel_name)) { ?>
    <h4 class="modal-title">Department: <?php  echo $department; ?> </h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>  
    </button>
    </div> <!-- modal header ended -->
    <div class="modal-body">
    <div class="col-3 dep-staff">
        <h2>No staff is assigned in this department </h2>                                            
    </div>   
    <?php
    }
}
?>
        </div>
        </div><!-- modal body ended -->
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<style>
.dep-staff{
    background-color: gray;
    color: green;
    margin: 2px;
    padding: 4px;
}
</style>