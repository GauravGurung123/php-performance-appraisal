<?php  session_start(); ?>
<?php include "includes/dbconfig.php"; ?>
<?php include "includes/functions.php"; ?>
<?php
if(isset($_POST['login'])) {
    login_user($_POST['username'], $_POST['password']);
}

?>

<link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    />

<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css" />

<div class="container mt-4">
  <div class="card card-info">
    <div class="card-header">
      <h3 class="card-title">Login Form</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
      <form class="form-horizontal" action="" method="post">
        <div class="card-body">
          <div class="form-group row">
            <label for="emailusername" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
              <input type="text" name="username" class="form-control" id="emailusername" placeholder="Username" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
              <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" required>
            </div>
          </div>
          <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck2">
                <label class="form-check-label" for="exampleCheck2">Remember me</label>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" name="login" class="btn btn-info">Sign in</button>
        </div>
        <!-- /.card-footer -->
      </form>
  </div>

</div>