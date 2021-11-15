<?php
  $per_page = 6;
  if (isset($_GET['page'])) {
      $page = $_GET['page'];
  } else { $page = ""; }

  if ($page == "" || $page == 1) {
      $page_1 = 0;
  } else {
      $page_1 = ($page * $per_page) - $per_page;
  }

  $query_count = "SELECT * FROM departments";
  $do_count = mysqli_query($connection, $query_count);
  $count = mysqli_num_rows($do_count);
  $count = ceil($count / $per_page);

  $query = "SELECT d.name as name, d.id as id, COUNT(staffs.dept_id) AS number FROM `departments` as d LEFT JOIN staffs ON d.id = staffs.dept_id GROUP BY d.name LIMIT $page_1, $per_page";
  $sel_depts = mysqli_query($connection, $query);

if(isset($_GET['source'])) {
    $source = $_GET['source']; 
} else {
    $source = '';
}
switch($source) {  
    case 'edit_department';
    include "includes/edit_department.php";
    break;
    default:
    // include "users.php";
    break;
}?>
<script>
    $(document).on('focusout','.form-control',function() {
        var idDepartment = $('#idDepartment').val();
        if(idDepartment == ''){
            $('.message_box').html('<span style="color:red;">field cannot be blank!</span>');
            $('#idDepartment').focus();
            return false;
        }
        $('#myForm')[0].reset();
        $.ajax({
            type: "POST",
            url: "ajax/ajax_department.php",
            data: "idDepartment="+idDepartment,
            
            success: function(data)
            {
                $('.message_box').html(data);
                getTableData();
            }
        });
        function getTableData(){
            $.ajax({
                url: 'ajax/ajax_datatable_department.php',
                success: function(response)
                {
                    $("#newdepart").hide('slow');
                    $('#getTableData').html(response);
                }
            })
        }
    });
</script>   

    <?php
    $source=null;
    if(isset($_GET['source'])) {
        $source = $_GET['source']; 
    }
    if(!$source=='edit_contact'): ?>
    <div class="col-6 col-sm-6" id="newdepart">
        <form action="" method="post" id="myForm">
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleDepartment">Department Name&nbsp;</label>
                    <input type="text" class="form-control" id="idDepartment" name="name" placeholder="Enter department name">
                    <small><?php echo isset($error['departmentName']) ? $error['departmentName'] : '' ?></small> 
                </div>
                <!-- <button type="submit" id="submit" name="create_department" class="btn btn-primary">Submit</button> -->
                <span class="message_box"></span>
                <p style="color:green;"><i>Department will be added when you leave the input field !!!</i></p>
            </div>
        <!-- /.card-body -->
        
        </form>

    </div>
    <?php endif; ?>
    <?php
    if(isset($_GET['source'])) {
    $source = $_GET['source']; 
    } else {
    $source = '';
    }
    switch($source) {  
    case 'edit_department';
    include "includes/edit_department.php";
    break;
    default:
    // include "users.php";
    break;
    }

    ?>

</div>