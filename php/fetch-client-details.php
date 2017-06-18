<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "config.php";
session_start();
if (!is_int($_SESSION['id']))
        fail('Input Error');
else
$user_id = $_SESSION['id'];
$client_id = clean_id('client_id');
$query = "SELECT `phone`, `address`, `contact` FROM `clients` WHERE `id` = ? AND `userid` = $user_id";
($stmt = $db->prepare($query))
        || fail("query error".$db->errno);
$stmt->bind_param("i", $client_id)
        || fail("bind_param:".$db->errno);
$stmt->execute()
        ||fail("execute:".$db->errno);   
$result = $stmt->get_result();
$description = $result->fetch_assoc();
$data = json_encode($description);
echo $data;
?>