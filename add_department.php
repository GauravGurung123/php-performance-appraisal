<?php include_once "includes/header.php" ?>
<?php if(isLoggedIn()): ?>

<!-- Navigation -->
<?php include_once "includes/nav.php" ?>
<!-- /.Navigation -->
<!-- Sidebar -->
<?php include_once "includes/sidebar.php" ?>
<!-- /.sidebar -->  

<?php
  if(isset($_POST['create_department'])){
    $departmentName = trim($_POST['department_name']);
    
  $error = [
      'departmentName'=> '',
  ];

  if (strlen($departmentName) < 2) {
    $error['departmentName'] = 'department name cannot be less than 2 characters <hr color="red">';
  }
  if (department_exists($departmentName)) {
    $error['departmentName'] = 'department name already exists, pick another one <hr color="red">';

  }

  foreach ($error as $key => $value) {
      if (empty($value)) {
      unset($error[$key]);
      }
  }

  if (empty($error)) {
    
      $query = "INSERT INTO departments(dept_name)";
      $query .= "values('$departmentName')";

      $create_department_query = mysqli_query($connection, $query);
      $log_action = "new department added";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['staff_username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 

      if(!$create_department_query) {
        die("QUERY Failed". mysqli_error($connection) );
    }

    
  }
}
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row text-center mb-2">
              <p class="display-4">Add Department</p>   
            </div>
            <!-- /.row -->
            <div class="row">
            <?php
            $source=null;
            if(isset($_GET['source'])) {
                $source = $_GET['source']; 
            }
            if(!$source=='edit_contact'): ?>
            <div class="col col-6 border-right">
                <form action="" method="post" autocomplete="on">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleDepartment">Department Name</label>
                            <input type="text" class="form-control" id="exampleDepartment" name="department_name" placeholder="Enter department name">
                            <small><?php echo isset($error['departmentName']) ? $error['departmentName'] : '' ?></small> 
                        </div>
                        <button type="submit" id="submit" name="create_department" class="btn btn-primary">Submit</button>
                        
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
        case '200';
        echo "nice 200";
        break;
        default:
        // include "users.php";
        break;
    }

?>
              <!-- /.col col-6 -->
            <div class="col col-6 mt-4 pl-4">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">S.N.</th>
                      <th>Department</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                       $query = "SELECT * FROM departments";
                       $sel_departments = mysqli_query($connection, $query);
           
                       while($row = mysqli_fetch_assoc($sel_departments)) {
                           $dept_id = $row['dept_id'];
                           $dept_name = ucfirst($row['dept_name']);
                      
                    echo"<tr>";
                      echo"<td>{$dept_id}</td>";
                      echo"<td>{$dept_name}</td>";
                      echo "<td><a class='bg-primary p-1' href='add_department.php?source=edit_department&edit_department={$dept_id}'>Edit</a>
                                <a class='bg-danger p-1' href='add_department.php?delete={$dept_id}'>Delete</a></td>";
                    echo"</tr>";
           
                    }?>         
                  </tbody>
                </table>
            </div>
            <!-- /.col col-6 -->
          </div>
            <!-- /.row -->

          </div>
        

          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

  
<?php include_once "includes/footer.php"?>
<?php
//delete contact query
if(isset($_GET['delete'])) {
    $log_action="department deleted";
    $the_dept_id = mysqli_real_escape_string($connection,$_GET['delete']);

    $query = "DELETE FROM departments where dept_id = {$the_dept_id} ";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 
    $del_contact_query = mysqli_query($connection, $query);
    header('Location: '.$_SERVER['PHP_SELF']);
    die;

}

?>

<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>