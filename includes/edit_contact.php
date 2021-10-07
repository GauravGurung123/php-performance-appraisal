<?php
    if(isset($_GET['edit_contact'])) {
        $the_contact_id = $_GET['edit_contact'];

        $query = "SELECT * FROM contacts where contact_id = $the_contact_id ";
        $sel_contacts_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($sel_contacts_query)) {
        $contact_id = $row['contact_id'];
        $contact_name = $row['contact_name'];
        $contact_email = $row['contact_email'];
        $contact_address1 = $row['contact_address1'];
        $contact_address2 = $row['contact_address2'];
        $contact_primary = $row['contact_primary'];
        $contact_secondary = $row['contact_secondary'];
        $contact_type = $row['contact_type'];
        $contact_company_name = $row['contact_company_name'];
        $contact_company_address = $row['contact_company_address'];
        $contact_company_website = $row['contact_company_website'];
        $contact_company_logo = $row['contact_company_logo'];
    }

    }
    if(isset($_POST['edit_contact'])) {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $addressOne = $_POST['addressOne'];
        $addressTwo = $_POST['addressTwo'];
        $primaryPhone = $_POST['primaryPhone'];
        $secondaryPhone = $_POST['secondaryPhone'];
        $type = $_POST['type'];
        $companyAddress = $_POST['companyAddress'];
        $companyWebsite = $_POST['companyWebsite'];
        $logo = $_POST['logo'];

        $query = "UPDATE contacts SET ";
        $query .="contact_name = '{$fullname}', ";
        $query .="contact_email = '{$user_email}', ";
        $query .="contact_address1 = '{$addressOne}', ";
        $query .="contact_address2 = '{$addressTwo}', ";
        $query .="contact_primary = '{$primaryPhone}', ";
        $query .="contact_secondary = '{$secondaryPhone}', ";
        $query .="contact_type = '{$type}', ";
        $query .="contact_company_name = '{$companyName}', ";
        $query .="contact_company_address = '{$companyAddress}', ";
        $query .="contact_company_website = '{$companyWebsite}', ";
        $query .="contact_company_logo = '{$logo}' ";
        $query .="WHERE contact_id = {$the_contact_id} ";
        $log_action="contact profile updated";
        create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action);

        $update_contact_query = mysqli_query($connection, $query);
        confirm($update_contact_query);
        echo "contact Updated Succesfully";

    }

?>
<hr>
<form action="" method="post" enctype="multipart/form-data"> 
    <div class="card-body">
        <div class="form-group">
        <label for="exfullname">Full Name</label>
        <input type="text" class="form-control" id="exfullname" name="fullname" value="<?php echo $contact_name; ?>">
        </div>
        <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="<?php echo $contact_email; ?>">
        </div>
        <div class="form-group">
        <label for="Address">Address 1</label>
        <input type="text" class="form-control" id="Address" name="addressOne" value="<?php echo $contact_address1; ?>">
        </div>
        <div class="form-group">
        <label for="exampleUsername">Address 2</label>
        <input type="text" class="form-control" id="exampleUsername" name="addressTwo" value="<?php echo $contact_address2; ?>">
        </div>
        <div class="form-group">
        <label for="examplePrimary">Primary phone</label>
        <input type="text" class="form-control" id="examplePrimary" name="primaryPhone" value="<?php echo $contact_primary; ?>">
        </div>
        <div class="form-group">
        <label for="exampleSecondary">Secondary phone</label>
        <input type="text" class="form-control" id="exampleSecondary" name="secondaryPhone" value="<?php echo $contact_secondary; ?>">
        </div>
        <div class="form-group">
        <label>Select</label>
            <select id="selCompany" name="type" class="form-control">
                <option value="<?php echo $contact_type; ?>" selected><?php echo $contact_type; ?></option>
                <?php 
                if($contact_type == 'company'){
                echo"<option value='individual'>Individual</option>";
                } else {
                echo"<option value='company'>Company</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group company_dropdown">
        <label for="companyname">Company Name</label>
        <input type="text" class="form-control" name="companyName" 
        value="<?php echo $contact_company_name; ?>">
        </div>
        <div class="form-group company_dropdown">
        <label for="companyaddress">Company Address</label>
        <input type="text" class="form-control" name="companyAddress" 
        value="<?php echo $contact_company_address; ?>">
        </div>
        <div class="form-group company_dropdown">
        <label for="companywebsite">Company website</label>
        <input type="text" class="form-control" name="companyWebsite" 
        value="<?php echo $contact_company_website; ?>">
        </div>
        <div class="form-group company_dropdown">
        <label for="exampleInputFile">Company Logo</label>
        <div class="input-group">
            <div class="custom-file">
            <input type="file" class="form-control" id="inputFiles" name="logo">
            </div>
            <div class="input-group-append">
            <span class="input-group-text">Upload</span><?php echo $contact_company_logo; ?>
            </div>
        </div>
        </div>

        <button type="submit" name="create_contact" class="btn btn-primary">Submit</button>
        
    </div>
        
    </div>
    <!-- /.card-body -->

</form>

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