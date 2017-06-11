<!DOCTYPE html>
<?php
session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
        header("Location: index.php");
    }
require "php/config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$greetings_array = array("Hello, ", "Howdy, ", "What's up, ", "Bonjour, ", "Hola, ", "Hey, ");
$greeting = $greetings_array[array_rand($greetings_array)];
$user_id = $_SESSION['id'];
$log_array = array();
$query = "SELECT recd.ID, recd.clientID, recd.issue, recd.hoursWorked, recd.dateOccurred, recd.timeStarted, recd.timeStopped, clients.name
          FROM recordedLogs recd
          JOIN clients ON recd.clientID = clients.id
          WHERE recd.userid = $user_id AND recd.dateOccurred <= NOW() ORDER BY recd.dateOccurred ASC LIMIT 15";
($stmt = $db->query($query))
        || fail("query error".$db->error);
for ($row_no = ($stmt->num_rows - 1); $row_no >= 0; $row_no-- ) {
        $stmt->data_seek($row_no);
        $log_array[] = ($stmt->fetch_assoc());
}
$stmt->free_result();
$db->close();
function drawLog($logID, $clientName, $issue, $timeStarted, $timeStopped, $dateOccurred) {
    $humanTimeStarted = date('G:i A', strtotime($timeStarted));
    echo  <<<EOT
        <div class="media log" id="{$logID}" data-log-clicked="false">
         
        <div class="log-overlay">
            <div class="media-content">
               <div class="">
                <h3 class="title client-name">{$clientName}</h3>
                <p class="subtitle issue">{$issue}</p>
                <div class="down-arrow" onclick="showLogDetails({$logID})">
                  <div class="icon is-large">
                    <i class="fa fa-arrow-down" aria-hidden="true" id="down-arrow"></i>
                  </div>
                </div>
               </div>
                <div class="box desc-container animated is-hidden">
                    <div class="media-left grey time-started-container">
                 <h1 class="subtitle white-font">{$humanTimeStarted}</h1>
               </div>
                </div>
            </div>
            
            </div>
              
        </div>
EOT;
}
function humanizeTime($time){
    $day = date("l", $time).", ".date("j", $time).date("S", $time);
    return($day);
}
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
        <link rel="stylesheet" href="css/default.css">
        <link rel="stylesheet" href="css/default.date.css">

        <link rel="apple-touch-icon" sizes="57x57" href="images/favicons/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="images/favicons/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="images/favicons/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="images/favicons/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="images/favicons/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="images/favicons/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="images/favicons/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="images/favicons/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="images/favicons/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="images/favicons/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="images/favicons/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicons/favicon-16x16.png">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="images/favicons/ms-icon-144x144.png">
  <meta name="theme-color" content="#025D8C">
  <script type='application/javascript' src='js/fastclick.min.js'></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <script src="https://use.fontawesome.com/a9de8a2dbb.js"></script>
  <script src="js/parsley.min.js"></script>
  <script>
    var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var todaysdate = new Date();
  </script>
</head>
    <body id="whole-thing">
    <nav class="nav grey has-shadow">
        <div class="nav-left is-hidden-mobile">
            <div class="nav-item is-hidden-touch">
                <img src="images/hammerpen.png" alt="logo" />
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
                    <span class="icon"><i class="fa fa-sign-out" aria-hidden="true"></i>
                    </span><p class=" is-hidden-touch header">Log Out</p>
                </button>
            </div>
        </div>
    </nav>
        <form class="modal is-block is-hidden animated" id="client-details" data-parsley-validate><!--new client form-->
          <div class="modal-background"></div>
            <div class="modal-content" id="new-client-modal">
                <div class="modal-card-head">
                    <h1 class="modal-card-title has-text-centered">Add A Client</h1><button class="delete" type="button" onclick="show('client-details', 'fromtop')"></button></div>
                <div class="modal-card-body">
                    <div class="field">
                        <label class="label" for="clientname">Client Name</label>
                        <div class="control">
                            <input type="text" class="input" id="newClientName" name="addClientname" placeholder="Client name" required/>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="clientphone">Phone Number</label>
                        <div class="control"><input type="tel" class="input" name="newClientPhone" id="newClientPhone" placeholder="#" required /></div>
                    </div>
                    <div class="field">
                        <label class="label" for="clientcontact">Contact Name</label>
                        <div class="control"><input type="text" class="input" name="newClientContact" id="newClientContact" required /></div>
                    </div>
                    <div class="field"><label class="label" for="clientadress">Address</label>
                        <div class="control"><input type="text" class="input" name="newClientAddress" id="newClientAddress" required /></div>
                    </div>
                </div>
                <div class="modal-card-foot has-text-centered" id="modal-foot">
                    <div class="saved-indicator is-hidden" id="saved-indicator">
                        <p class="help is-success has-text-centered" >Saved!</p>
                    </div>
                    <div class="log-action-group" id="save-buttons">
                        <button type="submit" class="submit-button button green" id="saveNewClientButton" >
                            <span class="icon"> <i class="fa fa-check" aria-hidden="true"></i>
                            </span><p class="header">Save Client</p>
                        </button>
                        <button class="button red control" id="newCancelButton" type="button" onclick="show('client-details', 'fromtop'); toggleClientDetails()">
                            <span class="icon"><i class="fa fa-times" aria-hidden="true">
                            </i></span><p class="header">Close</p>
                        </button>
                    </div>
                </div>
            </div>
        </form>

 <!--all clients--><form class="modal box is-block  animated" id="all-clients-modal">
        <div class="modal-background"></div>
            <div class="modal-content all-clients-modal animated">
              <header class="modal-card-head">
                 <div>
                  <h1 class="title has-text-centered">Clients</h1>
                  <input type="search" class="input" placeholder="Search..." />
                 </div>
                 <button type="button" class="delete" onclick="show('all-clients-modal', 'fromtop')"></button>
              </header>
              <div class="panel-tabs grey">
                  <p class="heading white-font" style="margin-left: 0; margin-right: 0;">Sort by:</p>
                 <a class="heading">Name</a>
                 <a class="heading">Something else</a>
               </div>
              <section class="modal-card-body">
                <div class="panel" id="all-clients-container">
                    
                </div>
              </section>
               <footer class="modal-card-foot">
                <button type="button" class="button red" onclick="show('all-clients-modal', 'fromtop')">Close</button>
               </footer>
            </div>
<!--all clients--></form>
        <div class="container">
            <div class="columns is-mobile is-gapless is-marginless">
              <div class="column is-three-quarters">
                <div class="button light-blue is-fullwidth nav-toggle" onclick="show('log-form', 'fromleft'); getClientList()" id="add-log-button">
                  <div class="icon"><i class="fa fa-plus"></i></div>
                  <p class="subtitle white-font is-marginless">Add Log<p>
                </div>
              </div>
              <div class="column is-one-quarter">
                <div class="button light-blue is-fullwidth nav-toggle" onclick="show('options-panel', 'fromright')">
                   <div class="icon"><i class="fa fa-bars"></i></div>
                  <p class="subtitle white-font is-marginless is-hidden-mobile">Options<p>
                </div>
              </div>
            </div>

            <!--new log form-->
              <form id="log-form" class="log-form animated is-hidden" name="newlog" method="POST" class="log" onsubmit="saveLog()" data-parsley-validate>
               <div class="notification">
                <div class="field">
                <label class="label" for="clientname">Client Name</label>
                    <div class="control has-icons-left" id="add-client">
                        <input type="search" class="input" id="clientName" name="clientname" placeholder="Search Clients" required/>
                        <span class="icon is-small is-left"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <button type="button" class="button green" id="add-client-button" onclick="toggleClientDetails(); show('client-details', 'fromtop')">New Client</button>
                    </div>
                </div>
                    <div class="field">
                    <label class="label" for="timeStarted">Date</label>
                        <div class="control">
                        <input type="text" class="input" id="dateOccurred"/>
                        </div>
                    </div>
                <div class="time-field">
                    <div class="field">
                    <label class="label" for="timeStarted">Time Started</label>
                        <div class="control">
                        <input type="text" class="input" id="timeStarted"/>
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
                <div class="field is-grouped is-grouped-centered">
                    <div class="control is-expanded">
                    <button class="button" type="button" onclick="dothis();">
                        <span class="icon"><i class="fa fa-plus"></i></span><span>Add Items</span></button>
                    </div>
                    <button class="control button green is-expanded" type="submit" id="submitbutton" name='Submit'>
                    <span class="icon" id="submitIcon"><i class="fa fa-check" aria-hidden="true"></i></span><span>Submit</span>
                    </button>
                    <button class="control button red is-expanded" type="button" onclick="show('log-form','fromleft')">
                    <span class="icon"><i class="fa fa-times" aria-hidden="true"></i></span><span>Close</span>
                    </button>
                    </div>
              </div>
<!--new log form--></form>
            
            <div class="option-panel panel animated is-hidden" id="options-panel">
                <h1 class="panel-heading has-text-centered">Options</h1>
                    <div class="panel-tabs">
                        <a class="heading is-active">Clients</a>
                        <a class="heading">Account</a>
                    </div>
                  <a class="panel-block">
                    <span class="icon"><i class="fa fa-pencil" aria-hidden="true"></i>
                    </span>
                    <p class="subtitle">Edit Client</p>
                  </a>
                 <a class="panel-block" onclick="show('all-clients-modal', 'fromtop'); generateClientList()">
                    <span class="icon"><i class="fa fa-address-book" aria-hidden="true"></i>
                    </span>
                    <p class="subtitle">View Clients</p>
                  </a>
               
            </div>
           <div class="log-container" id="log-container">
        <?php
        if (!isset($log_array[0])){ //New Guy
            echo '<div class="index-form">
                    <h1 class="title">Looks like you don\'t have any logs.</h1>
                  </div>
            ';
        }else{
        $dateChecker = $log_array[0]['dateOccurred'];
        foreach ( $log_array as $log ) {
                if ($dateChecker == strtotime($log['dateOccurred'])) {
                    drawLog($log['ID'], $log['name'], $log['issue'], $log['timeStarted'], $log['timeStopped'], $log['dateOccurred']);
                    $dateChecker = strtotime($log['dateOccurred']);
                }else{ //New day
                    $dateChecker = strtotime($log['dateOccurred']);
                    echo '
                       </article>
                        <article class="media day" id="'.$dateChecker.'" data-date-occurred="'.$dateChecker.'">
                            <div class="day-header">  
                            <h1 class="title day-date-title" id="">'.humanizeTime($dateChecker).'</h1> 
                            </div>
                         ';
                       drawLog($log['ID'], $log['name'], $log['issue'], $log['timeStarted'], $log['timeStopped'], $log['dateOccurred']);
                    }
                }
            }
        ?>
          </div>
        </div>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.10/handlebars.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="js/awesomplete.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/picker.js"></script>
    <script>
    var clientnameinput = document.getElementById('clientName');
    var selectedClientId = null;
    var clientObjectList = [];
    var awesomplete = new Awesomplete(clientnameinput, {autoFirst: true});
    function clearClientCache() {
        localStorage.removeItem('clientlist');
    }
    window.onload =clearClientCache;
    </script>
    <script>
        var dayBlockIdArray = {};
        $('#client-details').on('submit', function () {
            saveClientDetails();
            return false;
        });
        $('#log-form').on('submit', function () {
            savelog();
        return false;   
        });
    </script>
    <script>
    var highlighedclient = null;
    if ('addEventListener' in document) {
        document.addEventListener('DOMContentLoaded', function() {
            FastClick.attach(document.body);
             $('#dateOccurred').pickadate({
                 format: 'mmmm d, yyyy',
                 formatSubmit: 'yyyy-mm-d',
                 hiddenPrefix: 'date'
             });
             $('#timeStarted').pickatime({
                 formatSubmit: 'HH:i',
                 hiddenPrefix: 'started'
             });
             $('#timeStopped').pickatime({
                 formatSubmit: 'HH:i',
                 hiddenPrefix: 'stopped'
             });
        }, false);
        document.addEventListener("awesomplete-highlight", function(callback){
            highlightedclient = callback.text; //in case user closes awesomplete without selecting
        }, false);                            //a client
        document.addEventListener("awesomplete-close", function(reason){
            var clientId = null;
            //gets value of clientname input, finds it in the clientlist object, gets the clientid
            if (reason.reason != "select"){
                clientnameinput.value = highlightedclient;//makes input value last-highlighted value
            }
            for (var objectNumber = 0; objectNumber < clientlist.length; objectNumber++){
                var element = clientlist[objectNumber];
                if (element.name == clientnameinput.value){
                    clientId = element.id;
                }
            }
            selectedClientId = clientId;
            console.log(selectedClientId);
        }, false);
    };
    </script>
    <script id="log-template" type="text/x-handlebars-template">
        <div class="media log">
            <div class="media-content">
                <h3 class="title client-name">{{name}}</h3>
                <p class="subtitle work-description">{{issue}}</p>
                <div class="work-duration">
                    <p class="work-start-time">{{timeStarted}}</p>
                    <p>&nbsp-&nbsp</p>
                    <p class="work-end-time">{{timeStopped}}</p>
                </div>
            </div>
        </div>
    </script>
    <script id="day-template" type="text/x-handlebars-template">
        <article class="media day" id="{{dateTimestamp}}" data-date-occurred="">
            <div class="day-header">  
            <h1 class="title day-date-title">{{dateOccurred}}</h1> 
            </div>
            <div class="media log">
            <div class="media-content">
                <h3 class="title client-name">{{name}}</h3>
                <p class="subtitle work-description">{{issue}}</p>
                <div class="work-duration">
                    <p class="work-start-time">{{timeStarted}}</p>
                    <p>&nbsp-&nbsp</p>
                    <p class="work-end-time">{{timeStopped}}</p>
                </div>
            </div>
        </div>
        </article>
    </script>
    <script id="client-template" type="text/x-handlebars-template">
        <a class="panel-block">
            <h1>{{name}}</h1>
        </a>
    </script>
    </html>
     <!--<p class="title day-date-title" id="wed-mar-22">Wednesday, March 22</p>-->