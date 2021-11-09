<?php  session_start(); ?>
<?php include "includes/dbconfig.php"; ?>
<?php include "includes/functions.php"; ?>

<?php
if(isLoggedIn()) {
  header("location: index.php");
}
if(isset($_POST['login'])) {
    login_user($_POST['username'], $_POST['password']);
}

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    />

<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css" />
<style>
  form i {
    margin-left: -30px;
    cursor: pointer;
}
input {
  height: 100%;
  padding: 5px;
  border: none;
  box-sizing: border-box;
  background-color: whitesmoke;
}
input:focus {
  outline: none;
  background-color: transparent;
  transition: background-color 1s;
  border-bottom: 1px solid rgb(211, 211, 211);
  font-size: 15px;
  font-weight: 500;
  letter-spacing: 1px;
  padding: 8px 0px 0px 5px;
}
</style>
<div class="d-flex justify-content-center">
  <div class="card card-info col-4 mt-5">
    <div class="card-header">
      <h3 class="card-title">Login Form</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
      <form class="form-horizontal" action="" method="post">
        <div class="card-body ">
          <div class="form-group row">
            <label for="emailusername" class="col-sm-4 col-form-label">Username</label>
            <div class="col-sm-4">
              <input type="text" name="username" placeholder="Username" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-4 col-form-label">Password</label>
            <div class="col-sm-6">
              <input type="password" name="password" id="password" placeholder="Password" required><span>
              <i class="bi bi-eye-slash" id="togglePassword"></i></span>
            </div>
          </div>
          <!-- <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck2">
                <label class="form-check-label" for="exampleCheck2">Remember me</label>
              </div>
            </div>
          </div> -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" name="login" class="btn btn-info">Sign in</button>
        </div>
        <!-- /.card-footer -->
      </form>
  </div>

</div>
<script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');
  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('bi-eye');
  });
  </script>