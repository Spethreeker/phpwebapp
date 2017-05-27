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
    $dateOcurred = "2017-05-23";
    $hours_worked = clean_log_form('hours_worked');
    $description = clean_log_form('description');
    echo("Variables Sent!");


    ($stmt = $db->prepare('INSERT INTO recordedLogs (clientID, userid, issue, dateOccurred, hoursWorked, description) VALUES (?, ?, ?, ?, ?, ?)'))
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('iissis', $clientId, $_SESSION['id'], $issue, $dateOcurred, $hours_worked, $description)
        || fail('MySQL bind_param', $db->error);
    $stmt->execute()
        || fail('MySQL execute', $db->error);
    $stmt->free_result();
    $stmt->close();
    $db->close();
?>
    