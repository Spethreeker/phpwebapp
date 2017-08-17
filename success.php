<!DOCTYPE html>
<?php
    session_start();
    if (isset($_SESSION['result'])){
        $result = $_SESSION['result'];
    }
?>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
   <?php include('includes/head.inc');?>
<body class="body index-body animated" id="index-body">
   <div class="box animated index-form margin-auto-centered" id="login-form">
    <?php if (isset($result)){
       echo $result;
    }?>
    <h2 class="title">We've sent you an email</h2>
    <p class="subtitle">Please confirm your account to start using Worklogs!</p>
  
     
   
</div>
    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Privacy Policy</a>
 <footer>
   <a href="https://seal.beyondsecurity.com/vulnerability-scanner-verification/worklogs.io"><img src="https://seal.beyondsecurity.com/verification-images/worklogs.io/vulnerability-scanner-2.gif" alt="Website Security Test" border="0" /></a></footer>
</body>
</html>