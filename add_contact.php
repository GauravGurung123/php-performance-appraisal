<?php include_once "includes/header.php" ?>
<?php if(isLoggedIn()): ?>

<!-- Navigation -->
<?php include_once "includes/nav.php" ?>
<!-- /.Navigation -->
<!-- Sidebar -->
<?php include_once "includes/sidebar.php" ?>
<!-- /.sidebar -->  
<?php
  if(isset($_POST['create_contact'])){
      $contact_fullname = $_POST['fullname'];
      $contact_email = escape($_POST['email']);
      $contact_addressOne = escape($_POST['addressOne']);
      $contact_addressTwo = escape($_POST['addressTwo']);
      $conatact_primaryPhone = escape($_POST['primaryPhone']);
      $conatact_secondaryPhone = escape($_POST['secondaryPhone']);
      $company_type = escape($_POST['type']);
      $contact_company_name = escape($_POST['companyName']);
      $contact_company_address = escape($_POST['companyAddress']);
      $contact_company_website = escape($_POST['companyWebsite']);

      $contact_company_logo = $_FILES['logo']['name'];
      // $contact_logo_temp = $_FILES['logo']['tmp_name'];
  
      // move_uploaded_file($contact_logo_temp, "logo/$contact_company_logo");
  
      // $allowed_extension = array('jpeg', 'jpg', 'png');
      // $filename = $_FILES['document']['name'];
      // $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
  
      // if(!in_array($file_extension, $allowed_extension)){
      //   echo "only jpg, jpeg, png allowed";
      // }
      // else {

      $query = "INSERT INTO contacts(contact_name,contact_email,contact_address1,contact_address2,contact_primary,contact_secondary,
      contact_type,contact_company_name, contact_company_address, contact_company_website, contact_company_logo)
      VALUES('{$contact_fullname}','{$contact_email}','{$contact_addressOne}','{$contact_addressTwo}','{$conatact_primaryPhone}','{$conatact_secondaryPhone}','{$company_type}','{$contact_company_name}','{$contact_company_address}','{$contact_company_website}','{$contact_company_logo}')";

      $create_contact_query = mysqli_query($connection, $query);
      $log_action = "new contact added";
      create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 

      confirm($create_contact_query);
      echo "<p>Contact Created Successfully!</p>";

      // }
  }
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row text-center mb-2">
              <p class="display-4">Add New Contact</p>
            </div>
            <!-- /.row -->

            <form action="" method="post" enctype="multipart/form-data"> 
                <div class="card-body">
                    <div class="form-group">
                    <label for="exfullname">FullName</label>
                    <input type="text" class="form-control" id="exfullname" name="fullname" placeholder="Enter your fullname" req>
                    </div>
                    <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                    <label for="Address">Address 1</label>
                    <input type="text" class="form-control" id="Address" name="addressOne" placeholder="Enter your address1">
                    </div>
                    <div class="form-group">
                    <label for="exampleUsername">Address 2</label>
                    <input type="text" class="form-control" id="exampleUsername" name="addressTwo" placeholder="Enter your address2">
                    </div>
                    <div class="form-group">
                    <label for="examplePrimary">Primary phone</label>
                    <input type="text" class="form-control" id="examplePrimary" name="primaryPhone" placeholder="Enter your primary phone">
                    </div>
                    <div class="form-group">
                    <label for="exampleSecondary">Secondary phone</label>
                    <input type="text" class="form-control" id="exampleSecondary" name="secondaryPhone" placeholder="Enter your secondary phone">
                    </div>
                    <div class="form-group">
                    <label>Select</label>
                        <select id="selCompany" name="type" class="form-control">
                          <option>Individual</option>
                          <option value="company">Company</option>
                        </select>
                    </div>
                    <div class="form-group company_dropdown">
                    <label for="companyname">Company Name</label>
                    <input type="text" class="form-control" name="companyName" 
                    placeholder="Enter your company name">
                    </div>
                    <div class="form-group company_dropdown">
                    <label for="companyaddress">Company Address</label>
                    <input type="text" class="form-control" name="companyAddress" 
                    placeholder="Enter your company address">
                    </div>
                    <div class="form-group company_dropdown">
                    <label for="companywebsite">Company website</label>
                    <input type="text" class="form-control" name="companyWebsite" 
                    placeholder="Enter your company website">
                    </div>
                    <div class="form-group company_dropdown">
                    <label for="exampleInputFile">Company Logo</label>
                    <div class="input-group">
                      <div class="custom-file">
                      <input type="file" class="form-control" id="inputFiles" name="logo">
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div>

                    <button type="submit" name="create_contact" class="btn btn-primary">Submit</button>
                    
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(function() {
    $('.company_dropdown').hide(); 
    $('#selCompany').change(function(){
        if($('#selCompany').val() == 'company') {
            $('.company_dropdown').show(1000); 
        } else {
            $('.company_dropdown').hide(); 
        } 
    });
});
</script>
<?php else: ?>
<?php header("location: login.php") ?>
<?php endif ?>