<?php 
function fail($pub, $pvt = '')
    {
        global $debug;
        $msg = $pub;
        if ($debug && $pvt !== '')
            $msg .= ": $pvt";
        exit("An error occurred: $msg.\n");
    }
    function get_post_var($var)
    {
        $val = $_POST[$var];
        if (get_magic_quotes_gpc())
            $val = stripslashes($val);
        return $val;
    }
     function get_get_var($var)
    {
        $val = $_GET[$var];
        if (get_magic_quotes_gpc())
            $val = stripslashes($val);
        return $val;
    }
    $db_host = '45.56.100.209';
    $db_port = '3306';
    $db_user = 'spencer';
    $db_pass = 'spenther97';
    $db_name = 'worklogs';
    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if (mysqli_connect_errno()) //connect to server
            fail('MySQL connect', mysqli_connect_error());
    ?>