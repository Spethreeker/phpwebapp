<?php 

   function fail($pub, $pvt = '')
    {
        $msg = $pub;
        if ($pvt !== '')
            $msg .= ": $pvt";
        exit("An error occurred $msg.\n");
    }
    
    
    
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = 'root';
    $db_name = 'worklogs';
   

    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if (mysqli_connect_errno())
        fail('MySQL connect', mysqli_connect_error());

    $clientName = $_POST['clientname'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $clientPhone = $_POST['clientphone'];
    echo($clientName);
    // $sql = "INSERT INTO logs (clientName, description) VALUES ('$clientName', '$date')";
    ($stmt = $db->prepare('insert into logs (clientName, description) values (?, ?)'))
        || fail('MySQL prepare', $db->error);
    $stmt->bind_param('ss', $clientName, $description)
        || fail('MySQL bind_param', $db->error);
    $stmt->execute()
        || fail ('MySQL execute', $db->error);
    $stmt->close();
   echo('Done!');
    ?>
  <a href="home.html">Go Back</a>