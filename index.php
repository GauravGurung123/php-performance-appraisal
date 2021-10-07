<?php ob_start() ?>
<?php include "includes/header.php"; ?>
<?php if(isLoggedIn()): ?>
<!-- Navbar -->
<?php include "includes/nav.php" ?>
<!-- /.navbar -->

<!-- Sidebar -->
<?php include "includes/sidebar.php" ?>
  <!-- /.sidebar -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row text-center mb-2">
              <p class="display-4">Welcome Admin</p>
            </div>
            <div class="row">

              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php echo $user_counts = recordCount('users') ?></h3>
                    <p>User Registrations</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3><?php echo $contact_counts = recordCount('contacts') ?></h3>
                    <p>Contact Info</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="contacts.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><?php echo $log_counts = recordCount('logs') ?></h3>
                    <p>Logs Record</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="logs.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->

        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
   
      <?php include "includes/footer.php" ?>
      <?php else: ?>
      <?php header("location: login.php") ?>
      <?php endif ?>