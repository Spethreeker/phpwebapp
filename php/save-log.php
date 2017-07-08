<?php 
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // header('Content-Type: text/plain');
    include 'config.php';
    $debug = true;
    function clean_log_form($var)
    {
        $val = strip_tags(trim($_POST[$var]));
        return $val;
    }
    // $clientId = clean_log_form('client_id');
    // $issue = clean_log_form('issue');
    // $date_occurred = clean_log_form('date_occurred');
    // $hours_worked = clean_log_form('hours_worked');
    // $description = clean_log_form('description');
    // $time_started = clean_log_form('time_started');
    // $time_stopped = clean_log_form('time_stopped');
    $clientId = 64;
    $issue = "asdf";
    $date_occurred = "2017-07-04";
    $hours_worked = 1;
    $description = "asdfasdfasdfg";
    $time_started = "1:15";
    $time_stopped = "3:16";
    $userId= $_SESSION['id'];
   
    ($stmt = $db->prepare('INSERT INTO recordedLogs (clientID, userid, issue, dateOccurred, timeStarted, timeStopped, hoursWorked, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'))
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('iissssis', $clientId, $_SESSION['id'], $issue, $date_occurred, $time_started, $time_stopped, $hours_worked, $description)
        || fail('MySQL bind_param', $db->error);
    $stmt->execute()
        || fail('MySQL execute', $db->error);
    $stmt->free_result();
    $query = "SELECT recd.ID, recd.clientID, clients.name FROM recordedLogs recd
              JOIN clients ON recd.clientID = clients.id 
              WHERE  recd.userid = $userId
              ORDER BY recd.dateEntered DESC LIMIT  1";
    $result = $db->query($query);
    $row = $result->fetch_row();
    $clientName = $row[2];
    $logID = $row[0];
    $stmt->close();
    $db->close();
     echo  <<<EOT
        <div class="media log" data-log-id="{$logID}" data-log-clicked="false">
        <div class="log-overlay">
            <div class="media-content">
               <div class="">
                <h3 class="title client-name two_point_four">{$clientName}</h3>
                <p class="subtitle issue one_point_five">{$issue}</p>
                <div class="down-arrow" onclick="showLogDetails({$logID})">
                  <div class="icon is-large">
                    <i class="fa fa-arrow-down" aria-hidden="true" id="down-arrow"></i>
                  </div>
                </div>
               </div>
                <div class="box desc-container animated is-hidden">
                  <div class="media-left grey time-started-container">
                    <h1 class="subtitle white-font">{$time_started}</h1>
                  </div>
                </div>
            </div>
            
            </div>
              
        </div>
EOT;
?>
    