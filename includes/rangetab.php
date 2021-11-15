<div class="row">
<?php
  if(isset($_POST['create_field'])){
    $fieldName = trim($_POST['field_name']);
    $remarkName = trim($_POST['remark_name']);
    $salaryName = trim($_POST['salary_name']);
    
  $error = [
      'fieldName'=> '',
  ];

  if (strlen($fieldName) < 2) {
    $error['fieldName'] = 'field name cannot be less than 2 characters <hr color="red">';
  }
  if (fieldName_exists($fieldName)) {
    $error['fieldName'] = 'field name already exists, pick another one <hr color="red">';
  }

  foreach ($error as $key => $value) {
      if (empty($value)) {
      unset($error[$key]);
      }
  }

  if (empty($error)) {
      $query = "INSERT INTO fields(name, remark, salary)";
      $query .= "values('$fieldName','$remarkName','$salaryName')";

      $create_criteria_query = mysqli_query($connection, $query);
      $log_action = "new criteria added";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 

      if(!$create_criteria_query) {
        die("QUERY Failed". mysqli_error($connection) );
    }
    header('Location: '.$_SERVER['PHP_SELF']);
    die;
    
  }
}
?>
<?php
$source=null;
if(isset($_GET['source'])) {
    $source = $_GET['source']; 
}
if(!$source=='edit_contact'): ?>               
<style>
input {
    height:10%;
    width:50%;
}
    </style>
<div class="col col-5">
    <form action="" method="post" autocomplete="on">
        <small>
        <div class="card-body">
            <div class="form-group">
                <label for="exampleCriteria">Result Name</label>
                <input type="text" class="form-control" id="exampleCriteria" name="field_name" placeholder="new result name">
                <small><?php echo isset($error['criteriaName']) ? $error['criteriaName'] : '' ?></small>
            </div>
            <i class="text-danger">please set a standard range</i>

            <div class="row" >
            <div class="col-sm-6">
              <input type="number" class="form-control" id="exampleMinimum" name="mini" placeholder="minimum">
            </div>
            <div class="col-sm-6">
                <input type="number" class="form-control" id="exampleMaximum" name="maxi"  placeholder="maximum">
            </div>
        </div>
            <div class="form-group">
                <label for="exampleCriteria">Overall Remark</label>
                <input type="text" class="form-control" id="exampleCriteria" name="remark_name" placeholder="remark for overall result">
                <small><?php echo isset($error['criteriaName']) ? $error['criteriaName'] : '' ?></small>
            </div>
            <div class="form-group">
                <label for="exampleCriteria">Salary (%)</label>
                <input type="number" class="form-control" name="salary_name" min="0" max="100" placeholder="new salary increment">
            </div>
            <button type="submit" id="submit" name="create_field" class="btn btn-sm btn-primary">Add New</button>
            
        </div>
        </small>
    <!-- /.card-body -->
    </form>
    

</div>
<!-- col col-4 border-right ended -->
<?php endif; ?>

<?php
if(isset($_GET['source'])) {
    $source = $_GET['source']; 
} else {
    $source = '';
}
switch($source) {  
    case 'edit_field';
    include "includes/edit_field.php";
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
<div class="col col-sm-7" style="overflow: scroll">
    <table class="table" >
    <thead>
        <tr>
        <th style="width: 10px">S.N.</th>
        <th>Result</th>
        <th>Remark</th>
        <th>Salary</th>
        <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM fields";
        $sel_field = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($sel_field)) {
            $id = $row['id'];
            global $sno;
            ++$sno; 
            $name = ucfirst($row['name']);
            $remark = ucfirst($row['remark']);
            $salary = $row['salary'];
            
            echo"<tr>";
            echo"<td>{$sno}</td>";
            echo"<td>{$name}</td>";
            echo"<td>{$remark}</td>";
            echo"<td>{$salary}%</td>";


            echo "<td><small><a class='bg-primary p-1' href='config1.php?source=edit_field&edit_field={$id}'>Edit</a>
                <a rel='$id' class='del_field_link bg-danger p-1' href='javascript:void(0)'>Delete</a></td> </small>";
            echo"</tr>";

        }?>         
    </tbody>
    </table>
</div>
<!-- /.col col-7 -->
</div>
<!-- /.row ended -->
