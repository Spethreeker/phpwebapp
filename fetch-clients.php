<?php
session_start();
require "config.php";
$id = get_post_var('id');
$clientarray = array();
 $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if (mysqli_connect_errno()) //connect to server
            fail('MySQL connect', mysqli_connect_error());

($stmt = $db->prepare('SELECT name FROM clients WHERE userid = ?'))
        || fail("query error".$db->errno);
$stmt->bind_param("i", $id);
$stmt->execute();   
$stmt->bind_result($results)
        || fail("bind error".$db->errno);
while ($stmt->fetch() ){
    $clientarray[] = $results;
}
echo json_encode($clientarray);
?>