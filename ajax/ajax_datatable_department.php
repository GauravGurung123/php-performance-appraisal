<?php ob_start(); ?>
<?php include "../includes/dbconfig.php"; ?>
<?php session_start(); ?>
<?php include "../includes/functions.php" ?>
<?php
    $query = "SELECT d.name as name, d.id as id, COUNT(staffs.dept_id) AS number FROM `departments` as d LEFT JOIN staffs ON d.id = staffs.dept_id GROUP BY d.name";
    $sel_department = mysqli_query($connection, $query);
    
        while($row = mysqli_fetch_assoc($sel_department)) {
            global $ide;
            ++$ide;
            $id = $row['id'];
            $name = ucwords($row['name']);
        $number = $row['number'];

        echo"<tr>";
        echo"<td>{$ide}</td>";
        echo"<td data-id='{$id}' onClick='showDetails(this)'>{$name}</td>";
        echo"<td>{$number}</td>";
        if (is_superadmin($_SESSION['role_id']) || is_admin($_SESSION['role_id'])){
            
            echo "<td><a class='bg-primary p-1' href='departments.php?source=edit_department&edit_department={$id}'>Edit</a>";
            echo"<a rel='$id' class='del_link bg-danger p-1' href='javascript:void(0)'>Delete</a></small></td>";
        }
            echo"</tr>";
    }
?>

<?php include("/includes/modal_delete.php"); ?>
<script>
$(document).ready(function(){
    $(".del_link").on('click', function(){
        var delId1 = $(this).attr("rel");
        var delUrl1 = "departments.php?delete="+ delId1 +" ";
        
        $(".modal_del_link").attr("href", delUrl1);
        $("#modal-sm").modal('show');
    });
    $(".show_depart").on('click', function(){
            var showIds = $(this).attr("rel");
            var showUrls = "departments.php?retrieve="+ showIds +" ";

            $(".show_depart").attr("href", showUrls);
            $("#modal-lg").modal('show');
        });

});
</script>
<?php
//delete department query
if(isset($_GET['delete'])) {
    $log_action="department deleted";
    $the_id = mysqli_real_escape_string($connection,$_GET['delete']);

    $query = "DELETE FROM departments where id = '{$the_id}'";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 
    $del_report_query = mysqli_query($connection, $query);
    header('Location: '.$_SERVER['PHP_SELF']);
    die;
}
?>
<div class="modal fade" id="modal-lg">

</div>
<!-- /.modal -->

<script>
function showDetails(el) {
    var showIds = el.getAttribute("data-id");
        $.ajax
        ({
            type: "GET",
            url: "includes/modal_department_staff.php/",
            data: "showIds="+showIds,
            success: function(data)
            {
                $("#modal-lg").html(data);
                $("#modal-lg").modal('show');
                console.log(data);
            }
        }); 
    }
</script>