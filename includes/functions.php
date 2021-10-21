<?php

function redirect($location) {
    return header("location:" . $location);
}

function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function confirm($result) {
    global $connection;
if(!$result) {
    die ("Query Failed. " . mysqli_error($connection));
    }
}

function recordCount($table) {
    global $connection;
    $query = "SELECT * FROM " . $table;
    $sel_all_post = mysqli_query($connection, $query);
    return mysqli_num_rows($sel_all_post);
}

function contactCount($id) {
    global $connection;
    $query = "select * from contacts where contact_user_id=" . $id;
    $sel_all_post = mysqli_query($connection, $query);
    return mysqli_num_rows($sel_all_post);
}


function is_admin($username) {
    global $connection;
    $query = "select user_role from users where username = '$username'";
    $result =  mysqli_query($connection, $query);
    confirm($result);

    $row = mysqli_fetch_array($result);
    if ($row['user_role'] == 'admin') {
        return true;
    }else {
        return false;
    }

}

function username_exists($username) {
    global $connection;
    $query = "select staff_username from staffs where staff_username = '$username'";
    $result =  mysqli_query($connection, $query);
    confirm($result);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }

}

function department_exists($department) {
    global $connection;
    $query = "select dept_name from departments where dept_name = '$department'";
    $result =  mysqli_query($connection, $query);
    confirm($result);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }

}

function email_exists($user_email) {
    global $connection;
    $query = "select user_email from users where user_email = '$user_email'";
    $result =  mysqli_query($connection, $query);
    confirm($result);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }

}

function register_user($username, $user_firstname, $user_lastname, $user_email, $password,$user_address) {
global $connection;
$username = $_POST['username'];
$user_firstname = $_POST['firstname'];
$user_lastname = $_POST['lastname'];
$user_email = $_POST['email'];
$password = $_POST['password'];
$user_address = $_POST['address'];
// $user_contact_no = $_POST['contact'];

$username      = escape($username);
$user_firstname = escape($user_firstname);
$user_lastname  = escape($user_lastname);
$user_email    = escape($user_email);
$password      = escape($password);
$user_address      = escape($user_address);
// $user_contact_no      = mysqli_real_escape_string($connection, $user_contact_no);
$password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

$query = "INSERT INTO users(username, user_firstname, user_lastname, user_email, user_password, user_address) ";
$query .= "VALUES('$username', '$user_firstname', '$user_lastname', '$user_email', '$password','$user_address' )";
$register_user_query = mysqli_query($connection, $query);

$query = "select user_id from users where username = '{$username}' ";
$sel_userid_query = mysqli_query($connection, $query);
while ($row = mysqli_fetch_array($sel_userid_query)) {
    $user_id = $row['user_id'];
}

$log_action= mysqli_real_escape_string($connection,"new User Registered");

create_log($username, $user_id, $log_action); 

confirm($register_user_query);
if (mysqli_affected_rows($register_user_query = 1)) {
    login_user($username, $password);
    redirect("index.php");
}

}

function login_user($username, $password) {
    global $connection;
    $username = trim($username);
    $password = trim($password);
    $username = escape($username);
    $password = escape($password);

    $query = "SELECT * FROM staffs where staff_username = '{$username}'";
    $sel_username_query = mysqli_query($connection, $query);

    if(!$sel_username_query) {
        die("QUERY Failed". mysqli_error($connection) );
    }
    // $db_user_password ='none';
    while ($row = mysqli_fetch_array($sel_username_query)) {
        $db_staff_id = $row['staff_id'];
        $db_username = $row['staff_username'];
        $db_name = $row['staff_name'];
        $db_user_password = $row['staff_password'];

    }
    
    if(password_verify($password, $db_user_password)){
        $_SESSION['staff_id'] = $db_staff_id;
        $_SESSION['staff_password'] = $db_user_password;
        $_SESSION['staff_username'] = $db_username;
        $_SESSION['staff_name'] = $db_name;
        $log_action="loggedin";
        create_log($_SERVER['REMOTE_ADDR'], $_SESSION['staff_username'], $_SERVER['HTTP_USER_AGENT'], $log_action); 
        header("location: index.php");  
        
    } else {
    // redirect("login.php");
    echo "<div class='text-center text-danger mt-5'>username or password wrong</div>";

    }
}

function isLoggedIn() {
    if (isset($_SESSION['staff_id'])) {
        return true;
    }
    return false;
}

function create_log($log_ip, $log_username, $log_useragent, $log_action) {
    global $connection;
    $log_ip = $log_ip;
    $log_username = $log_username;
    $log_useragent = $log_useragent;
    $log_action = escape($log_action);

    $query = "INSERT INTO logs(log_ip, log_username,log_useragent, log_action) ";
    $query .= "VALUES('$log_ip', '$log_username','$log_useragent', '$log_action')";
    $register_log_query = mysqli_query($connection, $query);

}

// debugging functions
function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}


?>