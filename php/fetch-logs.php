<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
session_start();
require "config.php";
if (!is_int($_SESSION['id']))
        fail('Input Error');
else
$user_id = $_SESSION['id'];
$log_array = array();
$query = "SELECT recd.clientID, recd.issue, recd.hoursWorked, recd.dateOccurred, clients.name
          FROM recordedLogs recd
          JOIN clients ON recd.clientID = clients.id
          WHERE recd.userid = $user_id AND recd.dateOccurred <= NOW() LIMIT 10";
($stmt = $db->query($query))
        || fail("query error".$db->error);
for ($row_no = ($stmt->num_rows - 1); $row_no >= 0; $row_no-- ) {
       $stmt->data_seek($row_no);
        $log_array[] = ($stmt->fetch_assoc() );
}
echo(json_encode($log_array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
$stmt->free_result();
$db->close();
?>


