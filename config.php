<?php 

function fail($pub, $pvt = '')
    {
        global $debug;
        $msg = $pub;
        if ($debug && $pvt !== '')
            $msg .= ": $pvt";
        exit("An error occurred: $msg.\n");
    }

    $db_host = '45.56.100.209';
    $db_port = '3306';
    $db_user = 'spencer';
    $db_pass = 'spenther97';
    $db_name = 'worklogs';
    // $db = new mysqli($db_host, $db_port, $db_user, $db_pass, $db_name);
    // if (mysqli_connect_errno())
    //     fail('MySQL connect', mysqli_connect_error());
    ?>