<!DOCTYPE html>
<?php
  session_start();
?>
<html class="blue">
  <head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/bulma.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
     <script src="js/jquery-3.2.0.min.js"></script>
     <script src="js/parsley.min.js"></script>
     <style>
    #register-link-button:hover{
      background: #eee;
    }
       </style>
  </head>
</html>
<body class="index-body animated" id="index-body">
<div class="container">
  <div class="hero">
    <div class="hero-header">&nbsp;</div>
    <div class="hero-body animated" id="hero-body">
      <img class="image is-128x128 margin-auto-centered" src="hammerpen.png" alt="Worklogs" id="logo"/>
      <div class="has-text-centered">
        <h1 class="title is-2 white-font">Worklogs</h1>
        <p class="subtitle is-4 off-white-font">A work journal on the Internet</p>
      </div>
    </div>
    <div class="hero-foot">&nbsp;</div>
</div>
   <div class="card animated index-form margin-auto-centered" id="login-form">
       <h1 class="card-header-title">Login</h1>
     <form id='login' action="user-login.php" class="card-content" name="loginform" method='post' accept-charset='UTF-8' data-parsley-validate>
       <input type="hidden" name="op" value="login">
       <div class="field">
       <label for='email' class="label heading light-gray" >Email Address</label>
        <span class="control">  <input type='email' class="input" name='email' id='Email'  required/></span>
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
   <a href="register.php" class="button is-link" id="register-link-button">Or register an account!<i class="em em-ok_hand"></i></a>
   </div>
   </div>
</div>
     <?php
      if(!isset($_SESSION['result'])) {
                            echo("<br>");
                        }else{
                            echo $_SESSION['result']."<br>";
      }?>

</div>
  <footer class="footer blue">
    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Privacy Policy</a>
  </footer>
</body>
     <script src="js/scripts.js"></script>
     <script>
    
      var index = document.getElementById('index-body');
      window.addEventListener('load', 
        function() { 
         index.classList.add('fadeIn');
        }, false);
    
    </script>
</html>