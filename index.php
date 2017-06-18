<!DOCTYPE html>
<?php
  session_start();
?>
<html>
  <head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/bulma.css">
    <link rel="stylesheet" href="css/style.css">
  <link rel="apple-touch-icon" sizes="57x57" href="images/favicons/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="images/favicons/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="images/favicons/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="images/favicons/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="images/favicons/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="images/favicons/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="images/favicons/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="images/favicons/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="images/favicons/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="images/favicons/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="images/favicons/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicons/favicon-16x16.png">
  <link rel="manifest" href="/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="images/favicons/ms-icon-144x144.png">
  <meta name="theme-color" content="#025D8C">
   <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
     <script src="js/parsley.min.js"></script>
     <style>
        .button.is-link:hover{
          background: #eee;
        }
       </style>
  </head>
<body class="body index-body animated" id="index-body">
<div class="container">
  <div class="hero">
    <div class="hero-header">&nbsp;</div>
    <div class="hero-body animated" id="hero-body">
      <img class="image is-128x128 margin-auto-centered" src="images/hammerpen.png" alt="Worklogs" id="logo"/>
      <div class="has-text-centered">
        <h1 class="title is-2 white-font">Worklogs</h1>
        <p class="subtitle is-4 off-white-font">A work journal on the Internet</p>
      </div>
    </div>
    <div class="hero-foot">&nbsp;</div>
</div>
   <div class="card animated index-form margin-auto-centered" id="login-form">
       <h1 class="card-header-title">Login</h1>
     <form id='login' action="php/user-login.php" class="card-content" name="loginform" method='post' accept-charset='UTF-8' data-parsley-validate>
       <input type="hidden" name="op" value="login">
       <div class="field">
       <label for='email' class="label heading light-gray" >Email Address</label>
        <span class="control">  <input type='email' class="input" name='email' id='Email'  required autofocus/></span>
       </div>
       <div class="field">
       <label class="field-label label heading light-gray"  for='password' >Password</label>
          <span class="control">
          <input class="input"  type='password' name='password' id='password' required/>
        </span>
       </div>
     <div class="field is-fullwidth">
       <label class="subtitle is-6">&nbsp;</label>
       <span class="control">
        <input class="button blue is-medium is-fullwidth"  type='submit' name='Submit' value='Login'>
       </span>
     </div>
   </form>
   <div class="card-footer">
   <div class="card-footer-item">
   <a href="register.php" class="button is-link" id="register-link-button">Or register an account</a>
   </div>
   </div>
     <?php
      if(!isset($_SESSION['result'])) {
                            echo("<br>");
                        }else{
                            echo $_SESSION['result']."<br>";
      }?>
</div>
</div>
    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Privacy Policy</a>
 <footer>
   <a href="https://seal.beyondsecurity.com/vulnerability-scanner-verification/worklogs.io"><img src="https://seal.beyondsecurity.com/verification-images/worklogs.io/vulnerability-scanner-2.gif" alt="Website Security Test" border="0" /></a></footer>
</body>
     <script src="js/scripts.js"></script>
</html>