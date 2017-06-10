<?php
session_start();
require "config.php";
$clientName = get_post_var('newName');
$clientPhone = preg_replace("/[ )(.-]/","", $_POST['newPhone']);
$clientContact = get_post_var('newContact');
$clientAddress = get_post_var('newAddress');
$db = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if (mysqli_connect_errno()) //connect to server
            fail('MySQL connect', mysqli_connect_error());
($stmt = $db->prepare('INSERT INTO clients (userid, name, phone, address, contact) VALUES (?, ?, ?, ?, ?)'))
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('isiss', $_SESSION['id'], $clientName, $clientPhone, $clientAddress, $clientContact)
        || fail('MySQL bind_param', $db->error);
    $stmt->execute()
        || fail('MySQL execute '. $db->error);
    $stmt->free_result();
    $stmt->close();
    $db->close();
?>