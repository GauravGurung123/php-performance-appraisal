<?php ob_start(); ?>
<?php include "../includes/dbconfig.php"; ?>
<?php include "../includes/functions.php" ?>
<?php session_start(); ?>

<?php
  // if(isset($_POST['create_criteria'])){
if ($_POST['idCriteria']!=""){
    $criteriaName = trim($_POST['idCriteria']);
    
  $error = [
      'criteriaName'=> '',
  ];

  if (strlen($criteriaName) < 2) {
    $error['criteriaName'] = 'criteria name cannot be less than 2 characters <hr color="red">';
  }
  if (criteria_exists($criteriaName)) {
    $error['criteriaName'] = 'criteria name already exists, pick another one <hr color="red">';
  }

  foreach ($error as $key => $value) {
      if (empty($value)) {
      unset($error[$key]);
      }
  }

  if (empty($error)) {
      
    $query = "INSERT INTO appraisal_criterias(name)";
    $query .= "values('$criteriaName')";

    $create_criteria_query = mysqli_query($connection, $query);
    $log_action = "new criteria added";
    create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 

    if(!$create_criteria_query) {
        die("QUERY Failed". mysqli_error($connection) );
    }
    if($criteriaName){
      echo "<span style='color:green; font-weight:bold;'>
      criteria added
      </span>";
    }
    else{
      echo "<span style='color:red; font-weight:bold;'>
      Sorry! Your form submission is failed.
      </span>";
      } 
  }
}
?>
<small><?php echo isset($error['criteriaName']) ? $error['criteriaName'] : '' ?></small>