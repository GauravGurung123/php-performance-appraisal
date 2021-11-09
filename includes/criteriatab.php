<div class="row">
<?php
$source=null;
if(isset($_GET['source'])) {
    $source = $_GET['source']; 
}
if(!$source=='edit_contact'): ?>               

<div class="col col-5 border-right">
    <form action="" method="post" autocomplete="on">
        <div class="card-body">
            <div class="form-group">
                <label for="exampleCriteria">Criteria</label>
                <input type="text" class="form-control" id="exampleCriteria" name="criteria_name" placeholder="add new criteria">
                <small><?php echo isset($error['criteriaName']) ? $error['criteriaName'] : '' ?></small>
            </div>
            <button type="submit" id="submit" name="create_criteria" class="btn btn-sm btn-primary">Add New</button>
            
        </div>
    <!-- /.card-body -->
    </form>
    

</div>
<!-- col col-5 border-right ended -->
<?php endif; ?>

<?php
if(isset($_GET['source'])) {
    $source = $_GET['source']; 
} else {
    $source = '';
}
switch($source) {  
    case 'edit_criteria';
    include "includes/edit_criteria.php";
    break;
    default:
    // include "users.php";
    break;
}

?>
<style>
table, td, th, thead {
    border: 1px solid black !important;
}
</style>
<!-- /.col col-5 -->
<div class="col col-7 pl-4"  style="overflow: scroll">
    <table class="table">
    <thead>
        <tr>
        <th style="width: 10px">S.N.</th>
        <th>Criteria</th>
        <th>Scale</th>
        <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM appraisal_criterias";
        $sel_criteria = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($sel_criteria)) {
            $id = $row['id'];
            global $sn;
            ++$sn; 
            $name = ucfirst($row['name']);
            
            $query = "SELECT * FROM scales";
            $sel_scl = mysqli_query($connection, $query);
            echo"<tr>";
            echo"<td>{$sn}</td>";
            echo"<td>{$name}</td>";
            
            if($row = mysqli_fetch_assoc($sel_scl)) {
                $minimum = $row['minimum'];
                $maximum = $row['maximum'];
                echo"<td>{$minimum} - {$maximum}</td>";
            }  


            echo "<td><small><a class='bg-primary p-1' href='config1.php?source=edit_criteria&edit_criteria={$id}'>Edit</a>
                    <a rel='$id' class='del_link bg-danger p-1' href='javascript:void(0)'>Delete</a></small></td>";
            echo"</tr>";

        }?>         
    </tbody>
    </table>
</div>
<!-- /.col col-7 -->
</div>
<!-- /.row ended -->
