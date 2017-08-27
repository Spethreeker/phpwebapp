<?php
 require 'config.php';
 session_start();

if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['activeHash']) && !empty($_GET['activeHash'])){
    $email = mysql_real_escape_string($_GET['email']);
    $activeHash = mysql_real_escape_string($_GET['activeHash']);
    ($stmt = $db->prepare('UPDATE `users` set `active` = `1` WHERE `activeHash` = ?' ));
    $stmt->bind_param('s', $activehash)
    || fail('MySQL bind_param', $db->error);
    $stmt->execute()
    || fail('MySQL execute', $db->error);
    $_SESSION['authenticated'] = 'Account Authenticated';
    header('Location: index.html');
} else { 
    echo('Wait, how\'d you get here?');
}
?>