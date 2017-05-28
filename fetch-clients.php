<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
session_start();
// error_reporting(0);
// $debug = true;
// header('Content-Type: text/plain');
require "config.php";
if (!is_int($_SESSION['id']))
        fail('Input Error');
else
$user_id = $_SESSION['id'];

$client_array = array();
 $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if (mysqli_connect_errno()) //connect to server
            fail('MySQL connect error', mysqli_connect_error());

$query = "SELECT `id`,`name` FROM `clients` WHERE `userid` = ?";
($stmt = $db->prepare($query))
        || fail("query error".$db->errno);
$stmt->bind_param("i", $user_id)
        || fail("bind_param:".$db->errno);
$stmt->execute()
        ||fail("execute:".$db->errno);   
// $stmt->bind_result($id, $name)
        // ||fail("bind_result error: ".$db->errno);
$results = $stmt->get_result();
        // ||fail($db->errno);

for ($row_no = ($results->num_rows - 1); $row_no >= 0; $row_no-- ) {
       $results->data_seek($row_no);
        $client_array[] = ($results->fetch_assoc() );
}
$stmt->free_result();
$db->close();
echo( json_encode($client_array) );
?>


