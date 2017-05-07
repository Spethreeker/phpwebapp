<?php 
    header('Content-Type: text/plain');
    require 'PasswordHash.php';
    require 'config.php';
    session_start();
    $debug = false;
    function get_post_var($var)
    {
        $val = $_POST[$var];
        if (get_magic_quotes_gpc())
            $val = stripslashes($val);
        return $val;
    }
 
    
    //Post Variables and normalizing them
    $name = get_post_var('name');
    if (!preg_match('/^[a-zA-Z0-9_]{1,60}$/', $name))
        fail('Invalid First Name. Please use alphanumeric characters');
    $email = get_post_var('email');
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        fail('Invalid email. Please use alphanumeric characters');}
    $pass = get_post_var('password');
    if(strlen($pass) > 21)
         fail('Password is too long. Please use less than 18 characters');
    //
     $hash_cost_log2 = 8;
        $hash_portable = FALSE;
        $hasher = new PasswordHash($hash_cost_log2, $hash_portable);
        $hash = $hasher->HashPassword($pass);
        if (strlen($hash) < 20)
            fail('Failed to has new password');
        unset($hasher);
    $op = $_POST['op'];
    if ($op !== 'new' && $op !=='login')
        fail('Unknown Request');
       
    if ($op === 'new'){
      
    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if (mysqli_connect_errno()) //connect to server
        fail('MySQL connect', mysqli_connect_error());
    
    
    ($stmt = $db->prepare('insert into users (name, email, password) values (?, ?, ?)'))
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('sss', $name, $email, $hash)
        || fail('MySQL bind_param', $db->error);
    if (!$stmt->execute()) {
        if ($db->errno === 1062 /*er_dump_entry*/)
            fail('This email address is already in use.');
        else
            fail ('MySQL execute', $db->error);
    }
    $_SESSION['result'] = 'User Created!';
    }
    header("Location: success.php");
    $_GET['userFirstName'] = $name;
    unset($hasher);
    
    $stmt->close();
    $db->close();





    
    ?>