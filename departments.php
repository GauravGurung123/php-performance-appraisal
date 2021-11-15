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
            <div class="row">
                <?php if (checkPermission()): ?>
                    <button id="button">Add New</button>
                    <style>
                        #newdepart { display: none; }
                    </style>
                <script>
                $("#button").click(function() { 
                    $("#newdepart").toggle('slow');
                });
                </script>
            </div>
            <!-- row ended -->
            <div class="row">
                <?php include "includes/add_dept_tab.php"; ?>
            </div>
                <?php endif; ?>
            
            <?php  include "includes/dept_list_tab.php"; ?>      
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</div>
<!-- /.content-wrapper -->

<?php include "includes/footer.php" ?>
<?php include("includes/modal_delete.php"); ?>
<?php include ("includes/modal_department_staff.php"); ?>


<script>
  $(document).ready(function(){
        $(".del_link").on('click', function(){
            var delId1 = $( this).attr("rel");
            var delUrl1 = "departments.php?delete="+ delId1 +" ";

            $(".modal_del_link").attr("href", delUrl1);
            $("#modal-sm").modal('show');
            
        });
    
        // $(".show_depart").on('click', function(){
            // var showIds = ;
            // var showIds = $(this).data("id");
            // $.ajax
            // ({
            //     type: "POST",
            //     url: "includes/modal_department_staff.php",
            //     data: showIds,
            //     success: function(data)
            //     {
            //         // $("#modal-lg").html('data');
            //         $("#modal-lg").modal('show');

            //         console.log(data);
            //     }
            // });
            // function getdata(){
            //     $.ajax({
            //         url: 'includes/modal_department_staff.php',
            //         success: function(response)
            //         {
            //             $('#getdata').html(response);
            //         }
            //     })
            // }
            // $(".show_depart").attr("href", showUrls);
        });

  });
  
$(function() {
    $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
    localStorage.setItem('lastTab', $(this).attr('href'));
    });
    var lastTab = localStorage.getItem('lastTab');

    if (lastTab) {
    $('[href="' + lastTab + '"]').tab('show');
    }  
});
</script>
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