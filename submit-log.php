<?php 
    session_start();
    header('Content-Type: text/plain');
    include 'config.php';
    $debug = true;
    // $issue = get_post_var('issue');
    // $hours_worked = get_post_var('hours_worked');
    // $description = get_post_var('description');
    $clientName = get_post_var('clientname');
    
    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if (mysqli_connect_errno()) //connect to server
            fail('MySQL connect', mysqli_connect_error());

            

    ($stmt = $db->prepare("insert into clients (userid, name) values (?, ?)"))
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('is', $_SESSION['id'], $clientName)
        || fail('MySQL bind_param', $db->error);
    $stmt->execute()
        || fail('MySQL execute', $db->error);
    $stmt->free_result();
    

    $stmt->close();
    $db->close();
    ?>
    