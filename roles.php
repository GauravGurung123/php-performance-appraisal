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
                <form>
                    <div class="col col-4">
                        <div class="form-group row">
                            <label for="exampleEvaluateename" class="col-form-label">User Name</label>
                            <select name="username" id="username" class="form-control">
                                <option value="">Select a Username:</option>;
                            </select>
                        </div>
                    </div>
            
                    <div class="col col-4">
                        <div class="form-group row">
                        
                            <label for="exampleEvaluateename" class="col-form-label">User Roles</label>
                            <select name="username" id="txtHint" class="form-control">
                                <option value="">Select a user role:</option>;
                            </select>
                        </div>
                    </div>
                    
                </form>
            </div>
        <!-- Container fluid ended -->
    </div>
    <!-- Content header ended -->
</div>
<!-- Content wrapper ended -->
<script type="text/javascript">
$(document).ready(function()){
    function loadData(type, cat_id)
    {
        $('#txtHint').html(data)
        $.ajax({
            url: 'ajax_role.php',
            type: 'POST',
            data:{type: type, id: cat_id},
            success: function(data){
                if(type == "roleData") {
                    $('#txtHint').html(data);
                } 
                $('#username').append(data);
            }
        });
    }

    loadData();
    $("#username").on("change", function(){
        var username = $("#username").val();

        loadData("roleData", username);
    })
}

</script>

<?php include "includes/footer.php" ?>

<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>