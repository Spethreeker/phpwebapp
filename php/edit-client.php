<?php
session_start();
require "config.php";
$clientID = get_post_var('clientID');
$clientName = get_post_var('newName');
$clientPhone = preg_replace("/[ )(.-]/","", $_POST['newPhone']);
$clientContact = get_post_var('newContact');
$clientAddress = get_post_var('newAddress');
if (!is_int($_SESSION['id']))
        fail('Input Error');
else
$user_id = $_SESSION['id'];
($stmt = $db->prepare('UPDATE clients SET `name`=?, `phone`=?, `address`=?, `contact`=? WHERE `userid` = ? AND `id` = ?'))
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('sissii', $clientName, $clientPhone, $clientAddress, $clientContact, $_SESSION['id'], $clientID)
        || fail('MySQL bind_param', $db->error);
    $stmt->execute()
        || fail('MySQL execute '. $db->error);
    $stmt->free_result();
    $stmt->close();
    $db->close();
?>