<!DOCTYPE html>
<?php
session_start();
$_SESSION['message'] = '';
?>

<html>
    <head>
        <link rel="stylesheet" href="css/bulma.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
</html>
<body>
<div class="container notification">
  <div class="columns">
            <div class="column is-half">
            <form id='register' name="register" class="notification" action='user-man.php' method='post' accept-charset='UTF-8'>
                <legend>Register</legend>
                <input type="hidden" name="op" value="new">
                <label for='FirstName' class="label heading">First Name</label>
                    <input type='text' class="input is-block" name='name' id='name' maxlength="50" required/>
                <label for='Email' class="label heading" >Email Address</label>
                    <input type='email' class="input" name='email' id='Email' maxlength="50" required/>
                <label class="label heading"  for='password' >Password</label>
                  <input class="input"  type='password' name='password' id='password' maxlength="50" required/>
                    <input class="button blue"  type='submit' name='Submit' value='Submit'>

            
  </form>
  <a class="button blue" href="home.html">Home</a>
     </div>

    
  </div>
  


</body>

</html>