<?php include_once "includes/header.php" ?>
<?php if(isLoggedIn()): ?>

<!-- Navigation -->
<?php include_once "includes/nav.php" ?>
<!-- /.Navigation -->
<!-- Sidebar -->
<?php include_once "includes/sidebar.php" ?>
<!-- /.sidebar -->  

<?php
if(isset($_POST['create_user'])){
    $username = trim($_POST['username']);
    $user_email = trim($_POST['email']);
    $user_password = trim($_POST['password']);
    $user_confirm_password = trim($_POST['confirm_password']);
    $password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
  $error = [
      'username'=> '',
      'email'=> '',
      'password'=> ''
  ];

  if (strlen($username) < 4) {
    $error['username'] = 'username cannot be less than 4 characters <hr color="red">';
  }
  if (username_exists($username)) {
    $error['username'] = 'username already exists, pick another one <hr color="red">';

  }
  if (email_exists($user_email)) {
    $error['email'] = 'Email already exists, pick another one <hr color="red">';
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
    
      $query = "INSERT INTO users(username, user_email, user_password)";
      $query .= "values('$username', '$user_email','$password')";

      // $log_action="User added";
      // create_log($_SESSION['username'], $_SESSION['user_id'], $log_action);
      $create_user_query = mysqli_query($connection, $query);
      $log_action = "new user added";
create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 

      if(!$create_user_query) {
        die("QUERY Failed". mysqli_error($connection) );
    }

      // login_user($username, $password);
      
  }
}
?>
<script>
var check = function() {
  if (document.getElementById('password').value ==
    document.getElementById('confirm_password').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'matching';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'not matching';
  }
}
</script>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row text-center mb-2">
              <p class="display-4">Add User</p>
            </div>
            <!-- /.row -->

            <form action="" method="post" autocomplete="on">
                <div class="card-body">
                    <div class="form-group">
                    <label for="exampleUsername">Username</label>
                    <input type="text" class="form-control" id="exampleUsername" name="username" placeholder="Enter username">
                    <small><?php echo isset($error['username']) ? $error['username'] : '' ?></small> 
                  </div>
                    <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email">
                    <small style="font-size: small; color: #e94e02"><?php echo isset($error['email']) ? $error['email'] : '' ?></small>  
                  </div>
                    <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="password" 
                    onkeyup='check();' name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" 
                    onkeyup='check();' name="confirm_password" placeholder="Password">
                    <span id='message'></span>
                    </div>
                    <button type="submit" id="submit" name="create_user" class="btn btn-primary">Submit</button>
                    
                </div>
                    
                </div>
                <!-- /.card-body -->

            </form>
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

<?php include_once "includes/footer.php"?>
<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>