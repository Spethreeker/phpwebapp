<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html');
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
          WHERE recd.userid = $user_id AND recd.dateOccurred <= NOW() ORDER BY recd.dateOccurred ASC LIMIT 15";
($stmt = $db->query($query))
        || fail("query error".$db->error);



for ($row_no = ($stmt->num_rows - 1); $row_no >= 0; $row_no-- ) {
        $stmt->data_seek($row_no);
        $log_array[] = ($stmt->fetch_assoc());
}
$stmt->free_result();
$db->close();
?>

<?php
       
       $dateChecker = 0;
        foreach ( $log_array as $log ) {
                
                if ($dateChecker !== strtotime($log['dateOccurred'])) {
                        echo "<br>"."A date changed"."<br>".$log['name']."<br>".$log['issue']."<br>".$log['dateOccurred']."<br>";
                        $dateChecker = strtotime($log['dateOccurred']);
                        var_dump($dateChecker);
                        echo "<hr>";
                }else{
                        echo $log['name']."<br>".$log['issue']."<br>".$log['dateOccurred']."<br>";
                        $dateChecker = strtotime($log['dateOccurred']);
                        var_dump($dateChecker);
                        echo "<br><br>";
    
                }
                
       }
?>
