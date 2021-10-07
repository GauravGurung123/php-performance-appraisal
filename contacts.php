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
            <div class="row text-center mb-2">
                <p class="display-4">All Contact</p>
            </div>
            <button class="btn btn-success"><a class="text-white" href="add_contact.php">add contact</a></button>
<?php
    if(isset($_GET['source'])) {
        $source = $_GET['source']; 
    } else {
        $source = '';
    }
    switch($source) {  
        // case 'add_user';
        // include "includes/add_user.php";
        // break;
        case 'edit_contact';
        include "includes/edit_contact.php";
        break;
        case '200';
        echo "nice 200";
        break;
        default:
        // include "users.php";
        break;
    }

?>
<!-- /.row -->
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Show 

                        <select name="page_no" id="">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select> Entries
                        </h3>   

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                            <form action="" method="post">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                <span><button type="submit" name="submitSearch" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button></span>
                                </div>
                            </form>
                            </div>
                        </div>
                        
                    </div>
                     <!-- /.card-header -->
                    <div class="card-body">

                    <?php 
                        if(isset($_POST['submitSearch'])) {
                            $search = $_POST['table_search'];
                        
                            $query = "SELECT * FROM contacts WHERE contact_name || contact_email like '$search' ";
                            $search_query = mysqli_query($connection, $query);
                        
                            if(!$search_query){
                                die("query failed" . mysqli_error($connection));
                            }
                        
                            $count = mysqli_num_rows($search_query);
                            if($count == 0) {
                                echo "result not found <span> <a href='contacts.php'>Back</a>;";
                            } else {
                                echo"
                                <table id='example2' class='table table-bordered table-hover'>
                                <thead>
                                <tr>
                                    <th>Contact ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address1</th>
                                    <th>Address2</th>
                                    <th>Primary Phone</th>
                                    <th>Secondary Phone</th>
                                    <th>Type</th>
                                    <th>Company Name</th>
                                    <th>Comapny Address</th>
                                    <th>Company Website</th>
                                    <th>Company Logo</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>";
                                echo"<a href='contacts.php'>Go Back</a>";
                                while($row = mysqli_fetch_assoc($search_query)) {
                                    $contact_id = $row['contact_id'];
                                    $contact_name = $row['contact_name'];
                                    $contact_email = $row['contact_email'];
                                    $contact_address1 = $row['contact_address1'];
                                    $contact_address2 = $row['contact_address2'];
                                    $contact_primary = $row['contact_primary'];
                                    $contact_secondary = $row['contact_secondary'];
                                    $contact_type = $row['contact_type'];
                                    $contact_company_name = $row['contact_company_name'];
                                    $contact_company_address = $row['contact_company_address'];
                                    $contact_company_website = $row['contact_company_website'];
                                    $contact_company_logo = $row['contact_company_logo'];
    
                                    echo"<tr>";
                                    echo"<td>{$contact_id}</td>";
                                    echo"<td>{$contact_name}</td>";
                                    echo"<td>{$contact_email}</td>";
                                    echo"<td>{$contact_address1}</td>";
                                    echo"<td>{$contact_address2}</td>";
                                    echo"<td>{$contact_primary}</td>";
                                    echo"<td>{$contact_secondary}</td>";
                                    echo"<td>{$contact_type}</td>";
                                    echo"<td>{$contact_company_name}</td>";
                                    echo"<td>{$contact_company_address}</td>";
                                    echo"<td>{$contact_company_website}</td>";
                                    echo"<td>{$contact_company_logo}</td>";
                                    echo "<td><a href='contacts.php?source=edit_contact&edit_contact={$contact_id}'>Edit</a>
                                    <a href='contacts.php?delete={$contact_id}'>Delete</a></td>";
                                    echo"</tr>";
                                
                                }

                                
                            }
                        }
                      ?>

                    <!-- contact default view -->
                     <?php if(!isset($_POST['submitSearch'])): ?>

                        <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Contact ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address1</th>
                            <th>Address2</th>
                            <th>Primary Phone</th>
                            <th>Secondary Phone</th>
                            <th>Type</th>
                            <th>Company Name</th>
                            <th>Comapny Address</th>
                            <th>Company Website</th>
                            <th>Company Logo</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $per_page = 4;
                            if (isset($_GET['page'])) {
                                $page = $_GET['page'];
                            } else { $page = ""; }
                            
                            if ($page == "" || $page == 1) {
                                $page_1 = 0;
                            } else {
                                $page_1 = ($page * $per_page) - $per_page;
                            }
                            
                            $contact_query_count = "SELECT * FROM contacts";
                            $do_count = mysqli_query($connection, $contact_query_count);
                            $count = mysqli_num_rows($do_count);
                            $count = ceil($count / $per_page);

                            $query = "SELECT * FROM contacts ORDER BY contact_name LIMIT $page_1, $per_page";
                            $sel_contacts = mysqli_query($connection, $query);

                            while($row = mysqli_fetch_assoc($sel_contacts)) {
                                $contact_id = $row['contact_id'];
                                $contact_name = $row['contact_name'];
                                $contact_email = $row['contact_email'];
                                $contact_address1 = $row['contact_address1'];
                                $contact_address2 = $row['contact_address2'];
                                $contact_primary = $row['contact_primary'];
                                $contact_secondary = $row['contact_secondary'];
                                $contact_type = $row['contact_type'];
                                $contact_company_name = $row['contact_company_name'];
                                $contact_company_address = $row['contact_company_address'];
                                $contact_company_website = $row['contact_company_website'];
                                $contact_company_logo = $row['contact_company_logo'];

                                echo"<tr>";
                                echo"<td>{$contact_id}</td>";
                                echo"<td>{$contact_name}</td>";
                                echo"<td>{$contact_email}</td>";
                                echo"<td>{$contact_address1}</td>";
                                echo"<td>{$contact_address2}</td>";
                                echo"<td>{$contact_primary}</td>";
                                echo"<td>{$contact_secondary}</td>";
                                echo"<td>{$contact_type}</td>";
                                echo"<td>{$contact_company_name}</td>";
                                echo"<td>{$contact_company_address}</td>";
                                echo"<td>{$contact_company_website}</td>";
                                echo"<td>{$contact_company_logo}</td>";
                                echo "<td><a href='contacts.php?source=edit_contact&edit_contact={$contact_id}'>Edit</a>
                                <a href='contacts.php?delete={$contact_id}'>Delete</a></td>";
                                echo"</tr>";
                        }
                        ?>
                        
                        </tbody>
                        
                        
                        </table>
                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                    Showing 1 to 4 of 15 entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">

                                    <ul class="pagination">

<?php
    for ($i=1; $i<=$count; $i++) {
        if ($i == $page ){
        echo "<li class='paginate_button page-item active'><a class='page-link active' href='contacts.php?page={$i}'>{$i}</a>";
        } else {
        echo "<li class='paginate_button page-item'><a class='page-link' href='contacts.php?page={$i}'>{$i}</a>";
       
        }
    }
?>
                                    </ul>
                                </div>
                            </div>
                        </div> 
                        <?php endif; ?>
            
                    </div>
                    
                    <!-- /.card-body -->
                </div><!-- / card closed -->

            </div><!-- /col-12 -->

        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
        <!-- /.content-header -->

</div>
<!-- /.content-wrapper -->

<?php include "includes/footer.php" ?>

<?php
//delete contact query
if(isset($_GET['delete'])) {
    $log_action="contact deleted";
    $the_contact_id = mysqli_real_escape_string($connection,$_GET['delete']);

    $query = "DELETE FROM contacts where contact_id = {$the_contact_id} ";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 
    $del_contact_query = mysqli_query($connection, $query);
    header('Location: '.$_SERVER['PHP_SELF']);
    die;

}

?>
<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>