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
function recordReportCount() {
    global $connection;
    $query = "SELECT * FROM reports GROUP BY report_id" ;
    $sel_all_post = mysqli_query($connection, $query);
    return mysqli_num_rows($sel_all_post);
}
function maxScale() {
    global $connection;
    $query = "SELECT * FROM appraisal_criterias" ;
    $sel_all_post = mysqli_query($connection, $query);
    $nums = mysqli_num_rows($sel_all_post);
    while (!$nums==0) {
        $query2 = "SELECT maximum FROM scales" ;
        $sel_all_post2 = mysqli_query($connection, $query2);
        if ($rows = mysqli_fetch_assoc($sel_all_post2)) {
            $maxScale  = $rows['maximum'];

        }

    }
}

function contactCount($id) {
    global $connection;
    $query = "select * from contacts where contact_user_id=" . $id;
    $sel_all_post = mysqli_query($connection, $query);
    return mysqli_num_rows($sel_all_post);
}


function is_superadmin($userrole) {
    global $connection;
    // global $row;
    $role['role'] = "member"; 
    $query = "SELECT roles.name as role FROM roles INNER JOIN staffs ON roles.id= '$userrole' LIMIT 1";
    $result =  mysqli_query($connection, $query);
    confirm($result);

    $row = mysqli_fetch_array($result);
    if ($row===null){    }
    else if ($row['role'] == 'superadmin') {
        return true;
    }else {
        return false;
    }

}
function is_admin($userrole) {
    global $connection;
    $query = "SELECT roles.name as role FROM roles INNER JOIN staffs ON roles.id= '$userrole'";
    $result =  mysqli_query($connection, $query);
    confirm($result);   

    $row = mysqli_fetch_array($result);
    if ($row===null){    }
    else if ($row['role'] == 'admin') {
        return true;
    }else {
        return false;
    }

}

function username_exists($username) {
    global $connection;
    $query = "select username from staffs where username = '$username'";
    $result =  mysqli_query($connection, $query);
    confirm($result);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }

}

function superuser_exists() {
    global $connection;
    $query = "select role_id from staffs where role_id = '1'";
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
    $query = "select name from departments where name = '$department'";
    $result =  mysqli_query($connection, $query);
    confirm($result);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }

}

function fieldName_exists($name) {
    global $connection;
    $query = "SELECT name from fields where name = '$name'";
    $result =  mysqli_query($connection, $query);
    confirm($result);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }

}


function criteria_exists($criteria) {
    global $connection;
    $query = "select name from appraisal_criterias where name = '$criteria'";
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

function field_exists() {
    global $connection;
    $query="SELECT id,name FROM fields WHERE EXISTS (SELECT field_id FROM fields_range as frange WHERE frange.field_id = fields.id )";
    $field_query = mysqli_query($connection, $query);
    $time1 = mysqli_num_rows($field_query);  
    $query1 = "SELECT * FROM fields";
    $fields_query = mysqli_query($connection, $query1);
    $time2 = mysqli_num_rows($fields_query);
    if($time1==$time2){
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

$action= mysqli_real_escape_string($connection,"new User Registered");

create_log($username, $user_id, $action); 

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

    $query = "SELECT * FROM staffs where username = '{$username}'";
    $sel_username_query = mysqli_query($connection, $query);

    if(!$sel_username_query) {
        die("QUERY Failed". mysqli_error($connection) );
    }
    $db_user_password ='none';
    while ($row = mysqli_fetch_array($sel_username_query)) {
        $db_id = $row['id'];
        $db_username = $row['username'];
        $db_name = $row['name'];
        $db_role_id = $row['role_id'];
        $db_user_password = $row['password'];

    }
    
    if(password_verify($password, $db_user_password)){
        $_SESSION['id'] = $db_id;
        $_SESSION['password'] = $db_user_password;
        $_SESSION['username'] = $db_username;
        $_SESSION['name'] = $db_name;
        $_SESSION['role_id'] = $db_role_id;
               
        $action="loggedin";
        create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $action); 
        header("location: index.php");  
        
    } else {
    // redirect("login.php");
    echo "<div class='text-center text-danger mt-5'>username or password wrong</div>";

    }
}

function checkPermission() {
    if (is_superadmin($_SESSION['role_id']) || is_admin($_SESSION['role_id'])) { 
        return true;
    }
    return false;
}
function isLoggedIn() {
    if (isset($_SESSION['id'])) {
        return true;
    }
    return false;
}

function create_log($ip, $username, $useragent, $action) {
    global $connection;
    $ip = $ip;
    $username = $username;
    $useragent = $useragent;
    $action = escape($action);

    $query = "INSERT INTO logs(ip, username,useragent, action) ";
    $query .= "VALUES('$ip', '$username','$useragent', '$action')";
    $register_log_query = mysqli_query($connection, $query);

}

// debugging functions
function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

function trimWords($string, $limit = 4)
{
    $words = explode(' ', $string);
    return implode(' ', array_slice($words, 0, $limit));

}
?>

