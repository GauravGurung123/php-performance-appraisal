<?php
    $query = "SELECT * FROM appraisal_criterias";
    $sel_criteria = mysqli_query($connection, $query);
    $query_scale = "SELECT * FROM scales";
    $sel_scl = mysqli_query($connection, $query_scale);
    if($row = mysqli_fetch_assoc($sel_scl)) {
        $minimum = $row['minimum']; 
        $maximum = $row['maximum'];
    }   
?>
<div class="row">
<script>
    $(document).on('focusout','.form-control',function() {
    // var delay = 2000;
    // $('.btn-primary').click(function(e){
        // e.preventDefault();
        var idCriteria = $('#idCriteria').val();
        if(idCriteria == ''){
            $('.message_box').html(
            '<span style="color:red;">field cannot be blank!</span>'
            );
            $('#idCriteria').focus();
            return false;
            }
            $('#myForm')[0].reset();
            $.ajax
            ({
                type: "POST",
                url: "ajax/ajax_criteria.php",
                data: "idCriteria="+idCriteria,
                // beforeSend: function() {
                // $('.message_box').html(
                // '<>'
                // );
                // },		 
                success: function(data)
                {
                    $('.message_box').html(data);
                    getdata();

                }
            });
            function getdata(){
                $.ajax({
                    url: 'ajax/ajax_datatable.php',
                    success: function(response)
                    {
                        $('#getdata').html(response);
                    }
                })
            }
    // });            
});

</script>
<?php
$source=null;
if(isset($_GET['source'])) {
    $source = $_GET['source']; 
}
if(!$source=='edit_contact'): ?>               

<div class="col col-5 border-right">
    <form action="" method="post" id="myForm" name="criteriaForm">
        <div class="card-body">
            <div class="form-group">
                <label for="exampleCriteria">Criteria</label>
                <input type="text" class="form-control" id="idCriteria" name="criteria_name" placeholder="add new criteria">
                <small><?php echo isset($error['criteriaName']) ? $error['criteriaName'] : '' ?></small>
            </div>
            <!-- <button type="submit" name="create_criteria" class="btn btn-sm btn-primary">Add New</button> -->
            <p style="color:green;"><i>criteria will be added when you leave the input field !!!</i></p>
        </div>
        <!-- /.card-body -->
    </form>
    <div class="message_box" style="margin:2px 0px;">
    </div>


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
.table td,th{
    padding: .40rem;    
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
    <tbody id='getdata'>
        <?php
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

        }?>         
    </tbody>
    </table>
</div>
<!-- /.col col-7 -->
</div>
<!-- /.row ended -->
