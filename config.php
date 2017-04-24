<?php 

function fail($pub, $pvt = '')
    {
        global $debug;
        $msg = $pub;
        if ($debug && $pvt !== '')
            $msg .= ": $pvt";
        exit("An error occurred: $msg.\n");
    }

    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = 'root';
    $db_name = 'worklogs';
    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if (mysqli_connect_errno())
        fail('MySQL connect', mysqli_connect_error());
    ?>