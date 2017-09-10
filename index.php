<!DOCTYPE html>
<?php

session_start();
?>
<html>
<?php include("includes/head.inc");?>
<body class="body index-body animated" id="index-body">
<div class="container">
  <div class="hero" style="background: #385D8A;">
    <div class="hero-header">&nbsp;</div>
    <div class="hero-body" id="hero-body" >
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
        <span class="control">  <input type='email' class="input" name='email' id='Email' required autofocus/></span>
       </div>
       <div class="field">
       <label class="label label heading light-gray" for='password'>Password</label>
          <span class="control">
          <input class="input"  type='password' name='password' id='password' required/>
        </span>
       </div>
       <?php
      if(!isset($_SESSION['authenticated'])) {
                            echo("<br>");
                        }else{
                            echo $_SESSION['authenticated'];
      }?>
     <div class="field is-fullwidth">
       <label class="subtitle is-6">&nbsp;</label>
       <span class="control">
        <input class="button light-blue is-medium is-fullwidth"  type='submit' name='Submit' value='Login'>
       </span>
     </div>
   </form>
   <div class="card-footer">
   <div class="card-footer-item">
   <a href="register.php" class="button is-link" id="register-link-button">Or register an account</a>
   </div>
   </div>
     
</div>
</div>
    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Privacy Policy</a>
 <footer>
   <a href="https://seal.beyondsecurity.com/vulnerability-scanner-verification/worklogs.io"><img src="https://seal.beyondsecurity.com/verification-images/worklogs.io/vulnerability-scanner-2.gif" alt="Website Security Test" border="0" /></a></footer>
</body>
     <script src="js/scripts.js"></script>
</html>