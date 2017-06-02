<!DOCTYPE html>
<?php
session_start();
?>
<html class="oxy-font">
    <head>
     <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="stylesheet" href="css/bulma.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/animations.css">
         <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  <script src="js/parsley.min.js"></script>
        <style> #login-link-button:hover{ background: #eee; }</style>
    </head>
</html>
<body class="index-body animated" id="index-body">
    <div class="hero">
    <div class="hero-header">&nbsp;</div>
    <div class="hero-body animated" id="hero-body">
      <img class="image is-128x128 margin-auto-centered" src="images/hammerpen.png" alt="Worklogs" id="logo"/>
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
    <form id='register' name="register" class="card-content" action='testing.php' method='post' accept-charset='UTF-8' data-parsely-validate>
      <input type="hidden" name="op" value="new">
      <div class="field">
      <label for='FirstName' class="label heading">First Name</label>
        <div class="control">
          <input type='text' class="input is-block" name='name' id='name' maxlength="50" value="Spencer" required/>
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
        <input type="number" data-parsley-type="number"/>
        <div class="field is-fullwidth">
          <label class="subtitle is-6">&nbsp;</label>
          <div class="control">
            <input class="button blue is-medium is-fullwidth"  type='button' onclick="throwUpMessage()"name='Submit' value='Register'>
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
  
</body>
 <script src="js/scripts.js"></script>
     <script>

      var index = document.getElementById('index-body');
      if ('addEventListener' in document) {  
        document.addEventListener('DOMContentLoaded', 
        function() { 
         index.classList.add('fadeIn');
        }, false);
      };</script>
      <script>
      $(function () {
        var registerForm = $('#register').parsley();
      });
    </script>
    <script>
    function throwUpMessage() {
      alert(
        "Thanks for your interest, but we're still not ready to go public yet. Come back soon though!"
      );
    }
    </script>
</html>