<?php
Header("Location: index.php");
session_unset($_SESSION['loggedin']);
session_destroy($_SESSION['loggedin']);
?>
