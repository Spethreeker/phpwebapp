<?php
session_start();
require "config.php";
if (!is_int($_SESSION['id']))
        fail('Input Error');
else
$user_id = $_SESSION['id'];
$client_array = array();
 $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if (mysqli_connect_errno()) //connect to server
            fail('MySQL connect', mysqli_connect_error());

($stmt = $db->prepare('SELECT id, name FROM clients WHERE userid = ?'))
        || fail("query error".$db->errno);
$stmt->bind_param("i", $user_id);
$stmt->execute();   
$result = $stmt->get_result();

while ($row = $result->fetch_assoc() ){
echo ($row['id']. $row['name']);
//      $client_array[] = ($row['id'], $row['name'];
// }       echo json_encode($client_array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}
print_r($client_array);


?>