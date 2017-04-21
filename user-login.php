<?php 
    header('Content-Type: text/plain');
    require 'PasswordHash.php';
    //$fail function
    session_start();
    $debug = TRUE;

    function fail($pub, $pvt = '')
    {
        global $debug;
        $msg = $pub;
        if ($debug && $pvt !== '')
            $msg .= ": $pvt";
        exit("An error occurred: $msg.\n");
    }
    function get_post_var($var)
    {
        $val = $_POST[$var];
        if (get_magic_quotes_gpc())
            $val = stripslashes($val);
        return $val;
    }
 
    
    //Post Variables and normalizing them
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = 'root';
    $db_name = 'worklogs';

    
    $email = get_post_var('email');
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        fail('Invalid email. Please use alphanumeric characters');}
    $pass = get_post_var('password');
    if(strlen($pass) > 21)
         fail('Password is too long. Please use less than 18 characters');
    
    $hash_cost_log2 = 8;
    $hash_portable = FALSE;
    $hasher = new PasswordHash($hash_cost_log2, $hash_portable);
    $hash = $hasher->HashPassword($pass);
    if (strlen($hash) < 20)
        fail('Failed to has new password');
    
   
     $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if (mysqli_connect_errno()) //connect to server
        fail('MySQL connect', mysqli_connect_error());

    $hash = '*'; //in case the user is not found
    ($stmt = $db->prepare('select password from users where email=?'))
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('s', $email)
        || fail('MySQL bind_param', $db->error);
    $stmt->execute()
        || fail('MySQL execute', $db->error);
    $stmt->bind_result($hash)
        || fail('MySQL bind_result', $db->error);
    if($stmt->fetch() && $db->errno)
        fail('MySQL fetch', $db->error);

        if ($hasher->CheckPassword($pass, $hash)) {
           $userFirstName = $db->query('SELECT name FROM users WHERE email=$email');
            setcookie($userFirstName, time() +(86400*30), "/"); //86400 = 1 day
            $_SESSION['loggedin'] = true;
            header("Location: home.php");
           
        }
        else{
           $_SESSION['result'] = 'Authentication Failed :(';
           header("Location: index.php");
        }
    unset($hasher);
    
    $stmt->close();
    $db->close();
    







    
    ?>