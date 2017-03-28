<html>
    <body>
        <?php
    //    $servername = "localhost";
    //    $username = "root";
    //    $password = "root"
    //    $dbname = "users"

    //    $conn = new mysqli($servername, $username, $password, $dbname);
    $user = 'root';
    $password = 'root';
    $db = 'timelogs';
    $host = 'localhost';
    $port = 8889;

   
    $con = mysqli_connect(
    $host, 
    $user, 
    $password, 
    $db,
    $port
    );
       if (mysqli_connect_errno())
        {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
       
        $sql = "INSERT INTO users (name, email, password) VALUES ('$_POST[name]', '$_POST[email]', '$_POST[password]')";

       

        if (!mysqli_query($con,$sql))
        {
            die('Error: ' . mysqli_error($con));
        }
        echo "1 record added";
        mysql_close($con);
        ?>

<p>Test</p>
</body>
        </html>