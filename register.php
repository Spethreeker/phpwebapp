<html>
    <head>
        <link rel="stylesheet" href="css/bulma.css">
        <link rel="stylesheet" href="css/style.css">
       <script language="JavaScript" src="gen_validatorv4.js"
    type="text/javascript" xml:space="preserve"></script>
    </head>
</html>
<body>
<div class="container notification">
  <div class="columns">
            <div class="column is-half">
            <form id='register' name="register" class="notification" action='adduser.php' method='post' accept-charset='UTF-8'>
                <legend>Register</legend>
                <input type='hidden' name='submitted' id='submitted' value='1'/>
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
  <script type="text/javascript" xml:space="preserve">
var frmvalidator  = new Validator("register");
    frmvalidator.addValidation("FirstName","req","Please enter your First Name");
  frmvalidator.addValidation("FirstName","maxlen=20",	"Max length for FirstName is 20");
  frmvalidator.addValidation("FirstName","alpha","Alphabetic chars only");
  
  frmvalidator.addValidation("LastName","req","Please enter your Last Name");
  frmvalidator.addValidation("LastName","maxlen=20","Max length is 20");
  
  frmvalidator.addValidation("Email","maxlen=50");
  frmvalidator.addValidation("Email","req");
  frmvalidator.addValidation("Email","email");
</script>


</body>

</html>