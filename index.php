<!DOCTYPE html>

<?php
  session_start();
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("Location: home.php");
  }
?>
<html>
  <head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/bulma.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
</html>
<body>
<div class="container notification">
  <div class="hero">
    <div class="hero-body">
      <span><img class="image is-128x128" src="hammerpen.png"/>
      <h2 class="title">Worklogs</h2></span>
      <p class="subtitle">A work journal on the Internet</p>
    </div>
  </div>
  <div class="columns">
    <div  class="column">
     <form id='login' class="notification" name="loginform" action='user-login.php' method='post' accept-charset='UTF-8'>
     <input type="hidden" name="op" value="login">
     <div class="field">
       <label for='email' class="label heading light-gray" >Email Address</label>
     <span class="control">  <input type='email' class="input" name='email' id='Email'  required/></span>
     </div>
     <div class="field">
       <label class="label heading light-gray"  for='password' >Password</label>
       <input class="input"  type='password' name='password' id='password' required/>
     </div>
    
     <input class="button light-blue"  type='submit' name='Submit' value='Login'>
   <?php
   //echo($_SESSION['result']);
   ?>
   </form>
  </div>
   <div class="column">
    <h3 class="title light-gray">Or, if you don't have an account:</h3>
    <button class="button light-blue" href="register.php">Register</button>
   </div>
 </div>
</div>
</body>

</html>