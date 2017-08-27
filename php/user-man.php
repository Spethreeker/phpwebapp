<?php 
    header('Content-Type: text/plain');
    require 'PasswordHash.php';
   ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "config.php";
    session_start();
    $debug = false;
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
    
    $activeHash = md5( rand(0, 1000));
      
    
    ($stmt = $db->prepare('insert into users (name, email, password, activeHash) values (?, ?, ?, ?)'))
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('ssss', $name, $email, $hash, $activeHash)
        || fail('MySQL bind_param', $db->error);
    if (!$stmt->execute()) {
        if ($db->errno === 1062 /*er_dump_entry*/)
            fail('This email address is already in use.');
        else
            fail ('MySQL execute', $db->error);
    }
    $stmt->close();
    $db->close();
    $_SESSION['result'] = 'Account Created';
    $to = $email; // Send email to our user
$subject = 'Confirm your Worklogs account'; // Give the email a subject 
$message = '
<h1>Thanks for signing up!</h1>
Your account has been created, you can login with the following credentials after you have activated your account by clicking the url below.
Please click this link to activate your account:
http://worklogs.io/verify.php?email='.$email.'&activeHash='.$activeHash.'
'; // Our message above including the link      
$headers = 'From:noreply@worklogs.io' . "\r\n"; // Set from headers
$success = mail($to, $subject, $message, $headers); // Send our email
    if (!$success){
        $errorMessage = error_get_last()['message'];
        print_r($errorMessage);
    }
header("Location:../success.php");
$_GET['userFirstName'] = $name;
unset($hasher);
    ?>