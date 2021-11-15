<?php ob_start(); ?>
<?php include "../includes/dbconfig.php"; ?>
<?php include "../includes/functions.php" ?>
<?php
    $query = "SELECT * FROM appraisal_criterias";
    $sel_criteria = mysqli_query($connection, $query);
    $query_scale = "SELECT * FROM scales";
    $sel_scl = mysqli_query($connection, $query_scale);
    if($row = mysqli_fetch_assoc($sel_scl)) {
        $minimum = $row['minimum'];
        $maximum = $row['maximum'];
    }
    while($row = mysqli_fetch_assoc($sel_criteria)) {
        $id = $row['id'];
        global $sn;
        ++$sn; 
        $name = ucfirst($row['name']);
        
        
        echo"<tr>";
        echo"<td>{$sn}</td>";
        echo"<td>{$name}</td>";
        
        
        echo"<td>{$minimum} - {$maximum}</td>";
          


        echo "<td><small><a class='bg-primary p-1' href='config1.php?source=edit_criteria&edit_criteria={$id}'>Edit</a>
                <a rel='$id' class='del_link bg-danger p-1' href='javascript:void(0)'>Delete</a></small></td>";
        echo"</tr>";

    }
?>
<?php include("/includes/modal_delete.php"); ?>
<script>
$(document).ready(function(){
    $(".del_link").on('click', function(){
        var delId1 = $(this).attr("rel");
        var delUrl1 = "config1.php?delete="+ delId1 +" ";
        
        $(".modal_del_link").attr("href", delUrl1);
        $("#modal-sm").modal('show');
    });
});
</script>
<?php
//delete criteria query
if(isset($_GET['delete'])) {
    $log_action="criteria deleted";
    $the_id = mysqli_real_escape_string($connection,$_GET['delete']);

    $query = "DELETE FROM appraisal_criterias where id = '{$the_id}'";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 
    $del_report_query = mysqli_query($connection, $query);
    header('Location: '.$_SERVER['PHP_SELF']);
    die;
}
?>