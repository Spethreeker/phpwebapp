<?php 
    header('Content-Type: text/plain');
    require 'PasswordHash.php';
    //$fail function
    function fail($pub, $pvt = '')
    {
        $msg = $pub;
        if ($pvt !== '')
            $msg .= ": $pvt";
        exit("An error occurred ($msg.\n");
    }
    $hash_cost_log2 = 8;
    $hash_portable = FALSE;
    
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $hasher = new PasswordHash($hash_cost_log2, $hash_portable);
    $hash = $hasher->HashPassword($pass);
    if (strlen($hash) < 20)
        fail('Failed to has new password');
    unset($hasher);

    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = 'root';
    $db_name = 'myapp';
   

    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if (mysqli_connect_errno())
        fail('MySQL connect', mysqli_connect_error());
    
    ($stmt = $db->prepare('insert into users (user, pass) values (?, ?)'))
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('ss', $user, $hash)
        || fail('MySQL bind_param', $db->error);
    $stmt->execute()
        || fail ('MySQL execute', $db->error);
    $stmt->close();
    $db->close();
    ?>