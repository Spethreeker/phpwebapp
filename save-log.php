<?php 
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    header('Content-Type: text/plain');
    include 'config.php';
    $debug = true;
    function clean_log_form($var)
    {
         $val = strip_tags(trim($_POST[$var]));
         return $val;
    }
  
    $clientId = clean_log_form('client_id');
    $issue = clean_log_form('issue');
    $date_occurred = "2017-05-28";
    $hours_worked = clean_log_form('hours_worked');
    $description = clean_log_form('description');
    $time_started = "9:25:00";
    $time_stopped = "10:30:00";
    ($stmt = $db->prepare('INSERT INTO recordedLogs (clientID, userid, issue, dateOccurred, timeStarted, timeStopped, hoursWorked, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'))
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('iissssis', $clientId, $_SESSION['id'], $issue, $date_occurred, $time_started, $time_stopped, $hours_worked, $description)
        || fail('MySQL bind_param', $db->error);
    $stmt->execute()
        || fail('MySQL execute', $db->error);
    $stmt->free_result();
    $stmt->close();
    $db->close();
?>
    