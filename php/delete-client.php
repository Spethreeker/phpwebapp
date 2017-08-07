<?php
session_start();
require "config.php";
$clientID = get_post_var('clientID');
if (!is_int($_SESSION['id']))
        fail('Input Error');
else
$user_id = $_SESSION['id'];
($stmt = $db->prepare('UPDATE clients SET `active` = 0 WHERE `id` = ? AND `userid` = ?'))
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('ii', $clientID, $_SESSION['id'])
        || fail('MySQL bind_param', $db->error);
    $stmt->execute()
        || fail('MySQL execute '. $db->error);
    $stmt->free_result();
    $stmt->close();
    $db->close();
?>