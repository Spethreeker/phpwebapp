<!DOCTYPE html>
<?php
session_start();
$_SESSION['message'] = '';
?>

<html class="blue">
    <head>
        <link rel="stylesheet" href="css/bulma.css">
        <link rel="stylesheet" href="css/style.css">
        <style> #login-link-button:hover{ background: #eee; }</style>
    </head>
</html>
<body class="index-body animated" id="index-body">
    <div class="hero">
    <div class="hero-header">&nbsp;</div>
    <div class="hero-body animated" id="hero-body">
      <img class="image is-128x128 margin-auto-centered" src="hammerpen.png" alt="Worklogs" id="logo"/>
      <div class="has-text-centered">
        <h1 class="title is-2 white-font">Worklogs</h1>
        <p class="subtitle is-4 off-white-font">A work journal I hope you'll like</p>
      </div>
    </div>
    <div class="hero-foot">&nbsp;</div>
</div>
<div class="container">
  <div class="card animated index-form" id="register-form">
    <h1 class="card-header-title">Register</h1>
    <form id='register' name="register" class="card-content" action='user-man.php' method='post' accept-charset='UTF-8'>
      <input type="hidden" name="op" value="new">
      <div class="field">
      <label for='FirstName' class="label heading">First Name</label>
        <div class="control">
          <input type='text' class="input is-block" name='name' id='name' maxlength="50" required/>
        </div>
      </div>
      <div class="field">
      <label for='Email' class="label heading" >Email Address</label>
          <div class="control">
            <input type='email' class="input" name='email' id='Email' maxlength="50"/>
            </div>
          </div>
          <div class="field">
            <label class="label heading"  for='password' >Password</label>
          <div class="control">
            <input class="input"  type='password' name='password' id='password' maxlength="50"/>

          </div>
        </div>
        <div class="field is-fullwidth">
          <label class="subtitle is-6">&nbsp;</label>
          <div class="control">
            <input class="button blue is-medium is-fullwidth"  type='submit' name='Submit' value='Register'>
          </div>
        </div>
  </form>
<div class="card-footer">
     <div class="card-footer-item">
     <a href="index.php" class="button is-link" id="login-link-button">Back to the login page</a>
     </div>
  </div>
</div>
  </div>
  <footer class="footer blue"></footer>
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