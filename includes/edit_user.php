    <?php
    if(isset($_GET['edit_user'])) {
        $the_user_id = $_GET['edit_user'];

        $query = "SELECT * FROM users where user_id = $the_user_id ";
        $sel_users_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($sel_users_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_email = $row['user_email'];
    }

    }
    if(isset($_POST['edit_user'])) {
        $username = $_POST['username'];
        $user_email = $_POST['user_email'];


        $query = "UPDATE users SET ";
        $query .="username = '{$username}', ";
        $query .="user_email = '{$user_email}' ";
        $query .="WHERE user_id = {$the_user_id} ";
        $log_action="User profile updated";
        create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action);

        $update_user_query = mysqli_query($connection, $query);
        confirm($update_user_query);
        echo "USER Updated Succesfully";

    }

?>

<form action="" method="post" enctype="multipart/form-data">
<hr>
<div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
</div>
<div class="form-group">
    <label for="post_content">Email</label>
    <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
</div>

<div class="form-group">
    <input type="submit" class="btn btn-primary mt-2" name="edit_user" value="Update User">
    <button class="btn btn-danger mt-2"><a class="text-white" href="users.php">Cancel</a></button>
</div>

</form>