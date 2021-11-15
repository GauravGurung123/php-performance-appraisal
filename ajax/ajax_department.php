<?php ob_start(); ?>
<?php include "../includes/dbconfig.php"; ?>
<?php include "../includes/functions.php" ?>
<?php session_start(); ?>

<?php
if ($_POST['idDepartment']!=""){
    $departmentName = trim($_POST['idDepartment']);
    
  $error = [
      'departmentName'=> '',
  ];

  if (strlen($departmentName) < 2) {
    $error['departmentName'] = 'name cannot be less than 2 characters <hr color="red">';
  }
  if (department_exists($departmentName)) {
    $error['departmentName'] = 'name already exists, pick another one <hr color="red">';
  }

  foreach ($error as $key => $value) {
      if (empty($value)) {
      unset($error[$key]);
      }
  }

  if (empty($error)) {
      
    $query = "INSERT INTO departments(name)";
    $query .= "VALUES('$departmentName')";

    $create_department_query = mysqli_query($connection, $query);
    $log_action = "new department added";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 

    if(!$create_department_query) {
        die("QUERY Failed". mysqli_error($connection) );
    }
    if($departmentName){
      echo "<span style='color:green; font-weight:bold;'>
      department added
      </span>";
    }
    else{
      echo "<span style='color:red; font-weight:bold;'>
      Sorry! Your form submission is failed.
      </span>";
      } 
  }
}else{
  echo "<span style='color:red; font-weight:bold;'>
  Sorry! Your form submission is failed.
  </span>";
  }
?>
<small><?php echo isset($error['departmentName']) ? $error['departmentName'] : '' ?></small>