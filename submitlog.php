<?php 
    header('Content-Type: text/plain');
    include 'config.php';
    $debug = true;
    $clientName = $_POST['clientname'];

    $stmt = $db->prepare('insert into clients (customerName) values (?)')
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('s', $clientName)
        || fail('MySQL bind_param', $db->error);
    $stmt->execute()
        || fail('MySQL execute', $db->error);


    $stmt->close();
    $db->close();
    ?>
    