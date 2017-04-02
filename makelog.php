<?php 
   
    
    
    $clientName = $_POST['clientname'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $clientPhone = $_POST['clientphone'];
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = 'root';
    $db_name = 'worklogs';
   

    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if (mysqli_connect_errno())
        fail('MySQL connect', mysqli_connect_error());
    $sql = "INSERT INTO logs (clientName, description) values ('$clientName', '$date')";
    // ($stmt = $db->prepare('insert into logs (clientName, description, date, clientPhone) values (?, ?, ?, ?)'))
    //     || fail('MySQL prepare', $db->error);
    // $stmt->bind_param('ss', $user, $hash)
    //     || fail('MySQL bind_param', $db->error);
    // $stmt->execute()
    //     || fail ('MySQL execute', $db->error);
    // $stmt->close();
   
    ?>
    <html>
<body>
    <p>Worked</p>
    </body>

        </html>