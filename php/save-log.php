<?php 
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // header('Content-Type: text/plain');
    include 'config.php';
    $debug = true;
    $clientId = get_post_var('client_id');
    $date_occurred = get_post_var('date_occurred');
    $hours_worked = get_post_var('hours_worked');
    $time_started = get_post_var('time_started');
    $time_stopped = get_post_var('time_stopped');
    $issue = get_post_var('issue');
    $details = get_post_var('details');
    $userId= $_SESSION['id'];
   
    ($stmt = $db->prepare('INSERT INTO recordedLogs (clientID, userid, issue, dateOccurred, timeStarted, timeStopped, hoursWorked, details) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'))
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('iissssis', $clientId, $_SESSION['id'], $issue, $date_occurred, $time_started, $time_stopped, $hours_worked, $details)
        || fail('MySQL bind_param', $db->error);
    $stmt->execute()
        || fail('MySQL execute', $db->error);
    $stmt->free_result();
    $query = "SELECT recd.ID FROM recordedLogs recd
              WHERE  recd.userid = $userId
              ORDER BY recd.dateEntered DESC LIMIT  1";
    $result = $db->query($query);
    $row = $result->fetch_row();
    $logID = $row[0];
    $stmt->close();
    $db->close();
    echo $logID;
?>