<?php 
    // header('Content-Type: text/plain');
    require 'PasswordHash.php';
    require 'config.php';
    
    session_start();
    $debug = true;
    //Post Variables and normalizing them
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
    $hash = '*'; //in case the user is not found
    $name = '*';
    $hash='*';
    $id = '*';
    ($stmt = $db->prepare('select id, name, password from users where email=?'))
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('s', $email)
        || fail('MySQL bind_param', $db->error);
    $stmt->execute()
        || fail('MySQL execute', $db->error);
    $stmt->bind_result($id, $name, $hash)
        || fail('MySQL bind_result', $db->error);
    if(!$stmt->fetch() && $db->errno)
        fail('MySQL fetch', $db->error);
        if ($hasher->CheckPassword($pass, $hash)) {
        $_SESSION['id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['loggedin'] = true;
         header("Location: ../home.php");
       }else{
           $_SESSION['result'] = 'Authentication Failed :(';
        header("Location: ../index.php");
         
        }
    unset($hasher);
    $stmt->close();
    $db->close();
    ?>