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
        <link rel="stylesheet" href="css/awesomplete.css">
        <link rel="stylesheet" href="css/awesomplete.base.css">
        <link rel="stylesheet" href="css/animations.css">
        
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/a9de8a2dbb.js"></script>
        <script>
        //      $.ajax({
        //         url:'fetch-logs.php',
        //         type: 'GET',
        //         dataType: 'json'}).done(function(data) {
        //                 for (var objectNumber = 0; objectNumber < data.length; objectNumber++){
        //                     var element = data[objectNumber];
        //                     var f = element.dateOccurred.split(/[-]/);
        //                     element.dateOccured = new Date(Date.UTC(f[0], f[1]-1, f[2], f[3] || 0, f[4] || 0, f[5] || 0));
        //                  };
        //                 var fetchedLogs = data;
        //                 var rawTemplate = document.getElementById("log-template").innerHTML;
        //                 var log_container = $('#log-container');
        //                  for (var objectNumber = 0; objectNumber < fetchedLogs.length; objectNumber++){  
        //                     var compiledTemplate = Handlebars.compile(rawTemplate);           
        //                     var thing = fetchedLogs[objectNumber];
        //                     var ourGeneratedHTML = compiledTemplate(thing);
        //                     $(log_container).prepend(ourGeneratedHTML);
        //                 };
        // });
        
            var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
                "October", "November", "December"
            ];
            var todaysdate = new Date();
            jQuery.easing.def = 'easeOutQuad';
          
               
             
         
        </script>
        <script>
            function logout() {
                $.post('logout.php', function (data) {
                    window.open(data);
                });
            };
        </script>
        <style>

        </style>
    </head>

    <body class="mont-font">
        <nav class="nav grey has-shadow">
            <div class="nav-left is-hidden-mobile">
                <div class="nav-item is-hidden-touch">
                    <img src="hammerpen.png" alt="logo" />
                </div>
                <div class="nav-item">
                    <p class="white-font title">WorkLogs</p>
                </div>
            </div>
            <div class="nav-right">
                <div class="nav-item">
                    <p class="title is-4 white-font"><?php if(isset($_SESSION['name'])) {echo $greeting.$_SESSION['name'];}?>
                    </p>
                </div>
                <div class="nav-item">
                    <button type="button" class=" button light-blue" id="logoutButton" onclick="logout()">
                        <span class="icon"> <i class="fa fa-sign-out" aria-hidden="true"></i>
                        </span><p class=" is-hidden-touch header">Log Out</p>
                    </button>
                </div>
            </div>
        </nav>
        <form class="modal" id="client-details" data-parsley-validate>
            <div class="modal-background" id="modal-background"></div>
            <div class="modal-content animated" id="modal-content">
                <div class="modal-card-head">
                    <h1 class="modal-card-title has-text-centered">Add A Client</h1><button class="delete" type="button" onclick="toggleZoom()"></button></div>
                <div class="modal-card-body">
                    <div class="field">
                        <label class="label" for="clientname">Client Name</label>
                        <div class="control">
                            <input type="text" class="input" id="newClientName" name="addClientname" placeholder="Client name" value="" required />
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="clientphone">Phone Number</label>
                        <div class="control"><input type="tel" class="input" name="newClientPhone" id="newClientPhone" placeholder="#" value="" required /></div>
                    </div>
                    <div class="field">
                        <label class="label" for="clientcontact">Contact Name</label>
                        <div class="control"><input type="text" class="input" name="newClientContact" id="newClientContact" value="" required /></div>
                    </div>
                    <div class="field"><label class="label" for="clientadress">Address</label>
                        <div class="control"><input type="text" class="input" name="newClientAddress" id="newClientAddress" value="" required /></div>
                    </div>
                </div>
                <div class="modal-card-foot has-text-centered" id="modal-foot">
                    <div class="saved-indicator" id="saved-indicator">
                        <p class="help is-success has-text-centered" >Saved!</p>
                    </div>
                    <div class="log-action-group" id="save-buttons">
                        <button type="button" class="submit-button button green" id="saveNewClientButton" onclick="saveNewClient()">
                            <span class="icon"> <i class="fa fa-check" aria-hidden="true"></i>
                            </span><p class="header">Save Client</p>
                        </button>
                        <button class="button red control" id="newCancelButton" type="button" onclick="toggleZoom()">
                            <span class="icon"><i class="fa fa-times" aria-hidden="true">
                            </i></span><p class="header">Close</p>
                        </button>
                    </div>
                </div>
            </div>
        </form>
       
        <div class="container" id="whole-thing">
            <div id="saved-logs">
                <article class="media day" id="">
                            <div class="day-header">  
                            <h1 class="title day-date-title level-item" id="today"></h1> 
                                <button class="button light-blue" onclick="showlog()" id="add-log-button">
                                    <span class="icon"><i class="fa fa-plus"></i></span>
                                    <span class="is-hidden-mobile"><p class="header">Add Log<p></span>
                                </button>
                            </div>
                    <div id="log-form" class="log-form" style="display: block;">
                     <form class="notification" id="newlog" name="newlog" method="POST" class="log" data-parsley-validate>
                        <div class="tile is-ancestor">
                            <div class="tile is-parent is-vertical">
                                <div class="tile is-child">
                                    <div class="field">
                                    <label class="label" for="clientname">Client Name</label>
                                        <div class="control has-icons-left" id="add-client">
                                            <span class="icon is-small is-left"><i class="fa fa-user" aria-hidden="true"></i></span>
                                            <input type="text" class="input" id="clientName" name="clientname" placeholder="Client name" required/>
                                            <button type="button" class="button green" id="add-client-button" onclick="toggleClientDetails()">New </button>
                                        </div>
                                    </div>
                                    <div class="time-field">
                                      <div class="field">
                                        <label class="label" for="timeStarted">Time Started</label>
                                          <div class="control">
                                            <input type="time" class="input" id="timeStarted"/>
                                          </div>
                                      </div>
                                      <div class="field">
                                          <label class="label" for="timeStarted">Time Stopped</label>
                                          <div class="control">
                                            <input type="time" class="input" id="timeStopped"/>
                                          </div>
                                      </div>
                                      <div class="field">
                                        <label class="label" for="hoursWorked">Hours Worked</label>
                                            <div class="control">
                                                <input type="number" class="input" id="hoursWorked" placeholder="in hours" maxlength="4" size="4" required/>
                                            </div>
                                        </div>
                                      </div>
                                      <div class="field">
                                      <label class="label " for="issue">Issue</label>
                                          <div class="control ">
                                              <input type="text" class="input" name="issue" id="issue" placeholder="What was wrong" required/>
                                          </div>
                                    </div>
                                    <div class="field">
                                    <label class="label " for="longDescription">Work Description</label>
                                        <div class="control">
                                            <textarea type="textarea" class="textarea" id="description" placeholder="Describe" required></textarea>
                                        </div>
                                    </div>
                                    <div class="field is-grouped is-grouped-right log-action-group">
                                        <button class="control button green" type="button" id="submitbutton" onclick="saveLog()" name='Submit'>
                                            <span class="icon" id="submitIcon"><i class="fa fa-check" aria-hidden="true"></i></span><span>Submit</span>
                                        </button>
                                        <button class="control button red" type="button" onclick="showlog()">
                                            <span class="icon"><i class="fa fa-times" aria-hidden="true"></i></span><span>Close</span>
                                        </button>
                                    </div>
                                    </div>
                            </div>
                                </div>
                            </div>
                        </div>
                    </form>
                        <div id="log-container">
                        </div>
                    </div>
                </article>
                <article class="media day">
                     <div class="day-header">
                    <p class="title day-date-title" id="wed-mar-22">Wednesday, March 22</p>
                                <button class="button light-blue" onclick="showlog()" id="add-log-button">
                                    <span class="icon"><i class="fa fa-plus"></i></span>
                                    <span class="is-hidden-mobile">New Log</span>
                                </button>
                                
                            </div>
                    <div class="media log">
                        <div class="media-content">
                            <h3 class="title customer-name">Adam's Apple Farm</h3>
                            <p class="subtitle work-description">Ran cleaning tools</p>
                            <div class="work-duration">
                                <p class="work-start-time">9:25 A.M.</p>
                                <p>&nbsp-&nbsp</p>
                                <p class="work-end-time">10:00 A.M.</p>
                            </div>
                        </div>
                        <div class="log-action-group has-addons"> 
                            <div class="control has-addons">
                                <button class="button has-addons has-text-centered" id="view-log-button">
                                    <span class="icon"><i class="fa fa-eye"></i></span>
                                    <span class="is-hidden-mobile">View</span>
                                </button>
                            </div>
                            <div class="control has-addons">
                                <button class="button has-addons has-text-centered" id="edit-log-button">
                                    <span class="icon"><i class="fa fa-pencil"></i></span>
                                    <span class="is-hidden-mobile">Edit</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="media log">
                        <div class="media-left time-occured-container">
                            <p class="subtitle">9:25 AM</p>
                        </div>
                        <div class="media-content">
                            <h3 class="title customer-name">Doug's Dog Pound</h3>
                            <p class="subtitle work-description">Reinstalled Doggy software</p>
                            <div class="work-duration">
                                <p class="work-start-time">9:25 A.M.</p>
                                <p>&nbsp-&nbsp</p>
                                <p class="work-end-time">10:00 A.M.</p>
                            </div>
                        </div>
                        <div class="log-action-group has-addons"> 
                            <div class="control has-addons">
                                <button class="button has-addons has-text-centered" id="view-log-button">
                                    <span class="icon"><i class="fa fa-eye"></i></span>
                                    <span class="is-hidden-mobile">View</span>
                                </button>
                            </div>
                            <div class="control has-addons">
                                <button class="button has-addons has-text-centered" id="edit-log-button">
                                    <span class="icon"><i class="fa fa-pencil"></i></span>
                                    <span class="is-hidden-mobile">Edit</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </article>
                </div>
                </div>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.10/handlebars.min.js"></script>
    <script src="js/easing.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/parsley.min.js"></script>
    <script src="js/awesomplete.min.js"></script>
    <script>
    var input = document.getElementById('clientName');
   
    var selectedClientId = null;
    var clientObjectList = [];
window.addEventListener("DOMContentLoaded", function(){
      
      var awesomplete = new Awesomplete(input, {
            autoFirst: true
        });
    $.ajax({
        url:'fetch-clients.php',
        type: 'GET',
        dataType: 'json'}).done(function(data) {
            clientObjectList = data;
            var clientNameList = [];
            $.each(data, function(key, value) {
                clientNameList.push(value.name);
            })
    awesomplete.list = clientNameList;
});
});
  </script>
  <script>
document.addEventListener("awesomplete-close", function(){
        var clientId = null;
        for (var objectNumber = 0; objectNumber < clientObjectList.length; objectNumber++){
            var element = clientObjectList[objectNumber];
            if (element.name == input.value ){
                clientId = element.id;
            }
        }
        selectedClientId = clientId;
        console.log(selectedClientId);
}, false);
    </script>
    <script>
     document.getElementById("today").innerHTML = days[todaysdate.getDay()] + ", " + months[
        todaysdate.getMonth()] + " " + todaysdate.getDate();
    </script>
    <script id="log-template" type="text/x-handlebars-template">
        <div class="media log">
            <div class="media-content">
                <h3 class="title customer-name">{{name}}</h3>
                <p class="subtitle work-description">{{issue}}</p>
                <div class="work-duration">
                    <p class="work-start-time">9:25 A.M.</p>
                    <p>&nbsp-&nbsp</p>
                    <p class="work-end-time">10:00 A.M.</p>
                </div>
            </div>
            <div class="log-action-group has-addons"> 
                <div class="control has-addons">
                    <button class="button has-addons has-text-centered" id="view-log-button">
                        <span class="icon"><i class="fa fa-eye"></i></span>
                        <span class="is-hidden-mobile">View</span>
                    </button>
                </div>
                <div class="control has-addons">
                    <button class="button has-addons has-text-centered" id="edit-log-button">
                        <span class="icon"><i class="fa fa-pencil"></i></span>
                        <span class="is-hidden-mobile">Edit</span>
                    </button>
                </div>
            </div>
        </div>
    </script>
    </html>