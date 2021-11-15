<?php
  if(isset($_POST['create_user'])){
  $username = trim($_POST['username']);
  $fullname = trim($_POST['fullname']);    
  $designation = trim($_POST['designation']);    
  $roleId = $_POST['user_role'];  
  $department = $_POST['department'];  
  $user_password = trim($_POST['password']);
  $user_confirm_password = trim($_POST['confirm_password']);
  $password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
  $error = [
  'username'=> '',
  'password'=> ''
  ];

  if (strlen($username) < 4) {
  $error['username'] = 'username cannot be less than 4 characters <hr color="red">';
  }
  if (username_exists($username)) {
  $error['username'] = 'username already exists, pick another one <hr color="red">';

  }

  if(!$user_password==$user_confirm_password) {
  $error['password'] = 'password not matched';
  }

  foreach ($error as $key => $value) {
  if (empty($value)) {
  unset($error[$key]);
  }
  }

  if (empty($error)) {

  $query = "INSERT INTO staffs(username, name, role_id, dept_id, designation, password)";
  $query .= "VALUES('$username', '$fullname', '$roleId','$department', '$designation', '$password')";

  $create_user_query = mysqli_query($connection, $query);
  $log_action = "new user added";
  create_log($_SERVER['REMOTE_ADDR'], $username, $_SERVER['HTTP_USER_AGENT'], $log_action); 

  if(!$create_user_query) {
  die("QUERY Failed". mysqli_error($connection) );
  }


  }
  header("location: staffs.php");
  }
?>
<script>
var check = function() {
var pass = document.getElementById('password').value == '';
var cpass = document.getElementById('confirm_password').value =='';
if ( pass || cpass){
document.getElementById('message').innerHTML = '';
}else{
if (document.getElementById('password').value ==
document.getElementById('confirm_password').value) {
document.getElementById('message').style.color = 'green';
document.getElementById('message').innerHTML = 'matching';
} else {
document.getElementById('message').style.color = 'red';
document.getElementById('message').innerHTML = 'not matching';
}
}
}
</script>
<div id="newpost" style="background-color: white; padding: 10px;">
<form action="" method="post" autocomplete="on">
    <div class="card-body">
        <div class="row">
          <div class="form-group col-sm-6">
          <label for="exampleUsername">Username</label>
          <input type="text" class="form-control" id="exampleUsername" name="username" placeholder="Enter username">
          <small><?php echo isset($error['username']) ? $error['username'] : '' ?></small> 
          </div>
          <div class="form-group col-sm-6">
          <label for="examplefullname">Full Name</label>
          <input type="text" class="form-control" id="examplefullname" name="fullname" placeholder="Enter staff fullname">
          <small><?php echo isset($error['username']) ? $error['username'] : '' ?></small> 
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-6">
          <label for="exampleDesignation">Department</label>
          <select name="department" class="form-control">
            <option value="N/A">---  &nbsp;  select department  &nbsp;  ---</option>';
              <?php
              $query_role1 = "SELECT * FROM departments ";
              $sel_role1 = mysqli_query($connection, $query_role1);
              while($row = mysqli_fetch_assoc($sel_role1)) {
                  $id = $row['id'];
                  $deptName = $row['name'];?>
                <option value="<?php echo $id; ?>"><?php echo $deptName;?></option>';
                  <?php
              }
              ?> 
            </select>
          </div>
          <div class="form-group col-sm-6">
          <label for="exampleDesignation">Designation</label>
          <input type="text" class="form-control" id="exampleDesignation" name="designation" placeholder="assign designation">
          </div>
        </div>
        <div class="form-group col-sm-6">
            <label for="exampleEvaluateename" class="col-form-label">User Roles</label>
            <select name="user_role" class="form-control">
                <?php
                $query_role1 = "SELECT * FROM roles WHERE name <> 'superadmin' ";
                $sel_role1 = mysqli_query($connection, $query_role1);
                while($row = mysqli_fetch_assoc($sel_role1)) {
                    $id = $row['id'];
                    $role = $row['name'];?>
                  <option value="<?php echo $id; ?>"><?php echo $role;?></option>';
                    <?php
                }
                ?> 
            </select>
        </div>
        
        <div class="form-group col-sm-6">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="password" 
        onkeyup='check();' name="password" placeholder="Password">
        </div>
        <div class="form-group col-sm-6">
        <label for="exampleInputPassword1">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" 
        onkeyup='check();' name="confirm_password" placeholder="Password">
        <span id='message'></span>
        </div>
        <button type="submit" id="submit" name="create_user" class="btn btn-primary ml-2">Submit</button>
        
    </div>
        
    </div>
    <!-- /.card-body -->
</form>
</div>