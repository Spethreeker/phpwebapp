<!DOCTYPE html>
<!--<?php
  // session_start();

  // $email = "email";
  // $password = "password";

  // if (isset($_SESSION['loggedin']) && $session['loggedin'] == true) {
  //   header("Location: home.php");
  // }

  // if (isset ($_POST['email']) && isset($_POST['password'])){
  //   if($_POST['email'] == $email && $_POST['password'] == $password){
  //     $_SESSION['loggedin'] = true;
  //     header("Location: home.php");
  //   }

  // }
?>
-->

<html>
    <head>
        <link rel="stylesheet" href="css/bulma.css">
        <link rel="stylesheet" href="css/style.css">
      

  
    </head>
</html>
<body>
<div class="container notification">
  <form id='login' class="notification" name="loginform" action='user-login.php' method='post' accept-charset='UTF-8'>
    <input type="hidden" name="op" value="login">
    <label for='email' class="label heading light-gray" >Email Address</label>
    <input type='email' class="input" name='email' id='Email' maxlength="50" required/>
    <label class="label heading light-gray"  for='password' >Password</label>
    <input class="input"  type='password' name='password' id='password' maxlength="50" required/>
    <br><br>
    <input class="button light-blue"  type='submit' name='Submit' value='Login'>
   
  </form>
   <h3 class="title light-gray">Or, if you don't have an account:</h3>
    <a class="button light-blue" href="register.php">Register</a>
    </div>
</div>

</body>

</html>