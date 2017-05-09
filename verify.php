<?php
 require 'config.php';
    session_start();

if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['activeHash']) && !empty($_GET['activeHash']) )
    $email = mysql_real_escape_string($_GET['email']);
    $activeHash = mysql_real_escape_string($_GET['activeHash']);
    
}else{}
?>