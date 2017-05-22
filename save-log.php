<?php 
    session_start();
    header('Content-Type: text/plain');
    include 'config.php';
    $debug = true;
    function clean_log_form($val)
    {
         $val = strip_tags(trim($_POST[$var]));
         return $val;
    }

    $clientName = clean_log_form('clientname');
     if (!preg_match('/^[a-zA-Z0-9_]{1,60} \'$/', $name))
    $issue = clean_log_form('issue');
    $hours_worked = clean_log_form('hours-worked');
    if (!is_int($_POST['hours_worked']))
        fail('Input Error');
    $description = clean_log_form('description');

    ($stmt = $db->prepare('INSERT INTO clients (userid, name) VALUES (?, ?)'))
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('is', $_SESSION['id'], $clientName)
        || fail('MySQL bind_param', $db->error);
    $stmt->execute()
        || fail('MySQL execute', $db->error);
    $stmt->free_result();
    

    $stmt->close();
    $db->close();
    ?>
    