<!DOCTYPE html>
<?php
session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
        header("Location: index.php");
    }
    $greetings_array = array("Hello, ", "Howdy, ", "What's up, ", "Bonjour, ", "Hola, ");
    $greeting = $greetings_array[array_rand($greetings_array)];
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="css/bulma.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/awesomplete.base.css">
        <script src="js/jquery-3.2.0.min.js"></script>
        <script src="js/parsley.min.js"></script>
        <script src="js/jquery.autocomplete.js"></script>
        <script src="js/awesomplete.js"></script>
        <script src="js/handlebars-v4.0.5.js"></script>
        <script src="js/scripts.js"></script>
        <!--<script src="js/SmoothScroll.js"></script>-->
        <script src="js/easing.js"></script>
        <script src="https://use.fontawesome.com/a9de8a2dbb.js"></script>
        <script>
            var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
            var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var todaysdate = new Date();
            jQuery.easing.def = 'easeOutQuad';
            $(document).ready(function () {
                document.getElementById("today").innerHTML = days[todaysdate.getDay()] + ", " + months[todaysdate.getMonth()] + " " + todaysdate.getDate();
                var form = $('#newlog');
            });
        </script>
        <script>
            function logout(){
            $.post('logout.php',function(data){window.open(data);});
            };
        </script>
        <style>
        
        </style>
    </head>
    <body>
        <nav class="nav grey has-shadow">
            <div class="nav-left">
                <div class="nav-item is-hidden-touch">
                    <img src="hammerpen.png" alt="logo" />
                </div>
                <div class="nav-item">
                    <p class="white-font title">WorkLogs</p>
                </div>
            </div>
            <div class="nav-right">
                <div class="nav-item">
                    <p class="title white-font">
                        <?php
                        if(isset($_SESSION['name'])) {
                            echo $greeting.$_SESSION['name'];
                        }
                        ?>
                    </p>
                    </div>
                     <div class="nav-item"><button class="button light-blue" onclick="logout();">Log out</button>
                </div>
            </div>           
        </nav>
        <div class="container" id="whole-thing">            
            <div id="saved-logs">
            <article class="day">
            <div class="">
            <div>
             <div class="is-pulled-right">
                <button class=" button light-blue" onclick="showlog()" id="add-log-button">+ Add Log</button>
                <button class=" button light-blue">* Edit Log</button>
            </div>
              <p class="title is-3 day-date-title" id="today"></p>
              <h3 class="subtitle black-font">There's no logs for today :(</h3>
            </div>

            </div>
            <div id="log-form" class="log-form">
                <form class="notification" id="newlog" name="newlog" method="POST" class="log" >
                    <div class="tile is-ancestor">
                           <div class="tile is-parent is-3" >
                            <div class="tile is-child">
                                <label class="label" for="clientname">Client Name</label> <br>
                                <input type="text" class="input" id="clientName" name="clientname" placeholder="Client name" /><br>
                               
                                <button class="button is-link is-small light-blue" type="button" onclick="toggleClientDetails()">+ Client Details</button>
                            </div>
                            <div class="tile is-child" id="client-details">
                                 <label class="label" for="clientphone">Phone Number</label><br>
                                <input type="tel" class="input" name="clientphone" placeholder="" /><br>
                                <label class="label" for="clientcontact">Contact Name</label><br>
                                <input type="text" class="input" name="clientcontact"/><br>
                                <label class="label" for="clientadress">Address</label><br>
                                <input type="text" class="input" name="clientaddress" /><br>
                                <button type="button" class="submit-button button is-small green"  onclick="saveClientDetails()">Save Details</button>
                            </div>
                        </div>
                        <div class="tile is-parent">
                            <div class="tile is-child">
                                <label class="label" for="workdescription">Issue</label><br>
                                <input type="text" class="input" name="issue" id="issue" placeholder="What was wrong" />
                            </div>
                            <div class="tile is-child" id="work-description">
                                <label class="label" for="workdescription">Hours Worked</label><br>
                                <input type="number" class="" id="hoursWorked" placeholder="in hours" maxlength="4"  size="4"/><br/>
                                <label class="label" for="longDescription">Work Description</label>
                                <textarea type="textarea" class="textarea" id="description" placeholder="Describe"></textarea>
                            </div>
                        </div>
                     
                    </div>
                    <div class="tile is-ancestor">
                        
                        <fieldset class="tile is-child is-3" style="border: none;">
                            <button class="button green control has-icon" type="submit" id="submitbutton" onclick="go()" name='Submit'>
                               <span class="icon"> <i class="fa fa-check" aria-hidden="true"></i></span>Submit
                            </button>
                            <button class="button red control has-icon" type="button" onclick="showlog()">
                                <span class="icon"><i class="fa fa-times" aria-hidden="true"></i></span> Cancel</button>
                        </fieldset>
                    </div>
                </form>
            </div><br>
            <div id="log-container">
            </div>
            </article>
            <article class="media day">
                    <p class="subtitle day-date-title" id="wed-mar-22">Wednesday, March 22</p>
                <div class="media log">
                 <div class="media-content">
                     <h3 class="title customer-name">Adam's Apple Farm</h3>
                    <p class="subtitle work-description">Ran cleaning tools</p>
                    <div class="work-duration">
                    <p class="work-start-time">9:25 A.M.</p> <p>&nbsp-&nbsp</p>
                    <p class="work-end-time">10:00 A.M.</p>
                </div>
                </div>
            </div>
            <div class="media log">
                <div class="media-content">
                    <h3 class="title customer-name">Doug's Dog Pound</h3>
                    <p class="subtitle work-description">Reinstalled Doggy software</p>
                    <div class="work-duration">
                        <p class="work-start-time">9:25 A.M.</p> <p>&nbsp-&nbsp</p>
                        <p class="work-end-time">10:00 A.M.</p>
                    </div>
                </div>
            </div>
       </article>
            </div>
        </div>
    </body>
    <script>
        var userid = <?php echo $_SESSION['id'];?>;
  
        var listofClients = "";
        var input = document.getElementById("clientName");
    
    $.post("fetch-clients.php",{id: userid}, function(data){  
          listofClients = JSON.parse(data);
          var awesomplete = new Awesomplete(input);
          awesomplete.list = listofClients;
    });
    </script>
    <script id="log-template" type="text/x-handlebars-template">
       <div class="media log">
                <div class="media-content">
                    <h3 class="title customer-name">{{name}}</h3>
                    <p class="subtitle work-description">{{issue}}</p>
                    <div class="work-duration">
                        <p class="work-start-time">9:25 A.M.</p> <p>&nbsp-&nbsp</p>
                        <p class="work-end-time">10:00 A.M.</p>
                    </div>
                </div>
            </div>
    </script>

    </html>