<?php ob_start(); ?>
<?php include "dbconfig.php"; ?>
<?php include "functions.php" ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AdminLTE 3 | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
    <!-- Ionicons -->
    <link
      rel="stylesheet"
      href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"
    />
    <!-- Tempusdominus Bootstrap 4 -->
    <link
      rel="stylesheet"
      href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"
    />
    <!-- iCheck -->
    <link
      rel="stylesheet"
      href="../plugins/icheck-bootstrap/icheck-boo../plugins/jqvmap/jqvmap.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css" />
   

  </head>

<?php

if(isset($_POST['create_user'])){
    $username = trim($_POST['username']);
    $fullname = trim($_POST['fullname']);    
    // $user_role = trim($_POST['user_role']);
    // $user_role = 'superadmin';    
    $user_password = trim($_POST['password']);
    $user_confirm_password = trim($_POST['confirm_password']);
    $password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
  $error = [
      'username'=> '',
      // 'role'=> '',
      'password'=> ''
  ];

  if (strlen($username) < 4) {
    $error['username'] = 'username cannot be less than 4 characters <hr color="red">';
  }
  if (username_exists($username)) {
    $error['username'] = 'username already exists, pick another one <hr color="red">';

  }
  // if (superuser_exists($user_role)) {
  //   $error['role'] = 'SuperAdmin already exists, <hr color="red">';

  // }

  if(!$user_password==$user_confirm_password) {
    $error['password'] = 'password not matched';
  }

  foreach ($error as $key => $value) {
      if (empty($value)) {
      unset($error[$key]);
      }
  }

  if (empty($error)) {
    $role_query = "INSERT INTO roles(name)";
    $role_query .= "VALUES('superadmin'),('admin'),('member')";
    $create_role_query = mysqli_query($connection, $role_query);
    
    $scale_query = "INSERT INTO scales(minimum, maximum)";
    $scale_query .= "VALUES(0, 10)";
    $create_scale_query = mysqli_query($connection, $scale_query);

    $query = "INSERT INTO staffs(username, name, role_id, designation, password)";
    $query .= "VALUES('$username', '$fullname', '1', 'superadmin', '$password')";

    $create_user_query = mysqli_query($connection, $query);
    $log_action = "Role updated";
    create_log($_SERVER['REMOTE_ADDR'], $username, $_SERVER['HTTP_USER_AGENT'], $log_action);

    $log_action = "new user added";
    create_log($_SERVER['REMOTE_ADDR'], $username, $_SERVER['HTTP_USER_AGENT'], $log_action); 

    if(!$create_user_query) {
      die("QUERY Failed". mysqli_error($connection) );
    }
    header('Location: ../index.php');
    die;
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
          <div class="d-flex justify-content-center">
            <div class="col col-4 mt-5 p-4 border border-dark">
            <?php if(!superuser_exists()):?>
            <div class="row text-center ">
              <p class="display-4">Add SuperAdmin</p>
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
                        <label for="examplefullname">Full Name</label>
                        <input type="text" class="form-control" id="examplefullname" name="fullname" placeholder="Enter staff fullname">
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
            <?php else: ?>
            <p class="display-4">Please Contact Super Admin</p>

          </div>
          <!-- /.col col-4 -->
          </div>
          <!-- /.d-flex justify content center-->
              <?php endif; ?>
      

</body>
</html>
