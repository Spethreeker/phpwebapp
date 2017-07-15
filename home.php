<!DOCTYPE html>
<?php
session_start();
$_SESSION['loggedin'] = true;
$user_id = 4;
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
        header("Location: index.php");
    }
require "php/config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$greetings_array = array("Hello, ", "Howdy, ", "What's up, ", "Bonjour, ", "Hola, ", "Hey, ");
$greeting = $greetings_array[array_rand($greetings_array)];
// $user_id = $_SESSION['id'];
$log_array = array();
$returned_logs = array();
$query = "SELECT recd.ID, recd.clientID, recd.issue, recd.hoursWorked, recd.dateOccurred, recd.timeStarted, recd.timeStopped,recd.dateEntered, clients.name
          FROM recordedLogs recd
          JOIN clients ON recd.clientID = clients.id
          WHERE recd.userid = $user_id AND recd.dateOccurred <= NOW() ORDER BY recd.dateOccurred DESC LIMIT 15";
($stmt = $db->query($query))
        || fail("query error".$db->error);
for ($row_no = ($stmt->num_rows - 1); $row_no >= 0; $row_no-- ) {
        $stmt->data_seek($row_no);
        $returned_logs[] = ($stmt->fetch_assoc());
}
$stmt->free_result();
$db->close();

$log_array = array_reverse($returned_logs);//Flips array around to correct order

function drawLog($logID, $clientName, $issue, $timeStarted, $timeStopped, $dateOccurred) {
    $humanTimeStarted = date('G:i A', strtotime($timeStarted));
    echo  <<<EOT
        <div class="log" data-log-id="{$logID}" data-log-clicked="false">
          <div class="log-content">
            <h3 class="title client-name two_point_four">{$clientName}</h3>
            <p class="subtitle issue one_point_five">{$issue}</p>&nbsp<p class="title"></p>
            <div class="icon" onclick="showLogDetails({$logID})">
              <i class="fa fa-arrow-down" aria-hidden="true" id="down-arrow"></i>
            </div>
          </div>
          <div class="box desc-container animated">
            <div class="log-left grey time-started-container">
            <h1 class="subtitle white-font">{$humanTimeStarted}</h1>
            </div>
          </div>
        </div>
EOT;
}
function humanizeTime($time){ //runs when a new day is echo'd
    $day = date("l", $time).", ".date("F", $time)." ".date("j", $time).date("S", $time);
    return($day);
}
?>
<html>
<?php include("includes/head.inc");?>
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
                    <p class="title is-4 white-font">
                        <?php if(isset($_SESSION['name'])) {echo $greeting.$_SESSION['name'];}?>
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
<?php include("includes/newclient.inc");?>
        <form class="modal is-block is-hidden animated" id="all-clients-panel">
            <div class="modal-background"></div>
            <div class="modal-card animated">
                <header class="modal-card-head">
                    <h1 class="modal-card-title has-text-centered">Clients</h1>
                    <button type="button" class="delete" onclick="show('all-clients-panel', 'fromtop')"></button>
                </header>
                <section class="modal-card-body">
                    <div class="panel" id="all-clients-container">
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button type="button" class="button green" id="add-client-button" onclick="show('all-clients-panel', 'fromtop');show('client-details', 'fromtop')">New Client</button>
                    <button type="button" class="button red" onclick="show('all-clients-panel', 'fromtop')">Close</button>
                </footer>
            </div>
        </form>
        <div class="container">
            <div class="columns is-mobile is-gapless is-marginless">
                <div class="column is-half">
                    <div class="field">
                        <a class="button control light-blue is-fullwidth is-medium" type="button" onclick="show('log-form', 'fromleft')"
                            id="add-log-button">
                  <span class="icon"><i class="fa fa-plus"></i></span>
                  <span>Add Log</span>
                </a>
                    </div>
                </div>
                 <div class="column">
                    <a class="button control light-blue is-fullwidth is-medium" type="button" onclick="generateClientList();show('all-clients-panel', 'fromtop')">
                   <span class="icon"><i class="fa fa-user"></i></span>
                   <span class="is-hidden-mobile">Clients</span>
                </a>

                </div>
                <div class="column is-2">
                    <a class="button control light-blue is-fullwidth is-medium" type="button" onclick="show('options-panel', 'fromright')">
                   <span class="icon"><i class="fa fa-bars"></i></span>
                </a>
                </div>
            </div>


           
<?php include("includes/newlog.inc");?>

<?php include("includes/options.inc");?>
            <div class="log-container" id="log-container">
<?php
        if (!isset($log_array[0])){ //New Guy
            echo '<div class="index-form">
                    <h1 class="title">Looks like you don\'t have any logs.</h1>
                  </div>';
        }else{
        $dateChecker = $log_array[0]['dateOccurred'];
        $timeChecker = $log_array[0]['timeStarted'];
        foreach ( $log_array as $log ) {
                if ($dateChecker == strtotime($log['dateOccurred'])) {
                    drawLog($log['ID'], $log['name'], $log['issue'], $log['timeStarted'], $log['timeStopped'], $log['dateOccurred'], $log['dateEntered']);
                    $dateChecker = strtotime($log['dateOccurred']);
                }else{ //New day
                    $dateChecker = strtotime($log['dateOccurred']);
                    echo '
                       </article>
                        <article class="day" id="'.$dateChecker.'" data-date-occurred="'.$dateChecker.'">
                            <div class="day-header">  
                            <h1 class="title day-date-title one_point_nine" id="">'.humanizeTime($dateChecker).'</h1> 
                            </div>
                         ';
                       drawLog($log['ID'], $log['name'], $log['issue'], $log['timeStarted'], $log['timeStopped'], $log['dateOccurred'], $log['dateEntered']);
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
        var awesomplete = new Awesomplete(clientnameinput, {
            autoFirst: true
        });
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

        function clearlocal() {
            localStorage.clear();
        };
    </script>
    <script>
        if ('addEventListener' in document) {
            document.addEventListener('DOMContentLoaded', function () {
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
            var highlightedclient = null;
            document.addEventListener("awesomplete-highlight", function (callback) {
                highlightedclient = callback.text;
                console.log("Highlighted client:" + highlightedclient); //in case user closes awesomplete without selecting
            }, false); //a client
            document.addEventListener("awesomplete-close", function (callback) {
                var clientId = null;
                reason = callback.reason;
                    console.log(reason);
                if (reason == "nomatches") {
                    return;
                }
                //gets value of clientname input, finds it in the clientlist object, gets the clientid
                else { //makes input value last-highlighted value
                    clientnameinput.value = highlightedclient;
                }
                for (var objectNumber = 0; objectNumber < clientlist.length; objectNumber++) {
                    var element = clientlist[objectNumber];
                    if (element.name == clientnameinput.value) {
                        clientId = element.id;
                    }
                }
                selectedClientId = clientId;
                console.log(selectedClientId, reason.reason);
            }, false);
        };
    </script>
    <script id="log-template" type="text/x-handlebars-template">
            <div class="log" data-log-id="{$logID}" data-log-clicked="false">
            <div class="log-content">
                <h3 class="title client-name two_point_four">{name}</h3>
                <p class="subtitle issue one_point_five">{issue}</p>
                <div class="icon" onclick="showLogDetails({$logID})">
                <i class="fa fa-arrow-down" aria-hidden="true" id="down-arrow"></i>
                </div>
            </div>
            <div class="box desc-container animated is-hidden">
                <div class="log-left grey time-started-container">
                <h1 class="subtitle white-font">{$humanTimeStarted}</h1>
                </div>
            </div>
        </div>
    </script>
    <script id="day-template" type="text/x-handlebars-template">
        <article class="day" id="{{dateTimestamp}}" data-date-occurred="">
            <div class="day-header">
                <h1 class="title day-date-title">{{dateOccurred}}</h1>
            </div>
             <div class="log" data-log-id="{$logID}" data-log-clicked="false">
            <div class="log-content">
                <h3 class="title client-name two_point_four">{name}</h3>
                <p class="subtitle issue one_point_five">{issue}</p>
                <div class="icon" onclick="showLogDetails({{logId}})">
                <i class="fa fa-arrow-down" aria-hidden="true" id="down-arrow"></i>
                </div>
            </div>
            <div class="box desc-container animated is-hidden">
                <div class="log-left grey time-started-container">
                <h1 class="subtitle white-font">{{timeStarted}}</h1>
                </div>
            </div>
        </div>
            
        </article>
    </script>
    <script id="client-template" type="text/x-handlebars-template">
        <div class="message is-light" id="{{id}}" data-name="{{name}}" data-editing="false">
            <header class="message-header" data-detailsexpanded="false">
                <h1 class="title is-marginless" contenteditable="false" data-idname="{{id}}">{{name}}</h1>
                <button class="button card-header-icon client-details-toggle" type="button" onclick="showClientDetails('{{id}}')">
              <!--<span class="icon">
                <i class="fa fa-angle-down"></i>
              </span>-->
              <span></span>
              <span></span>
              <span></span>
            </button>
            </header>
            <div class="details-content is-hidden">
                <div class="card-content">
                    <span class="loader has-text-centered is-large"></span>
                    <div class="columns is-hidden animated">
                        <div class="column">
                            <h2 class="subtitle"><strong>Phone Number</strong></h2>
                            <h3 class="subtitle" data-idphone="{{id}}" contenteditable="false"></h3>
                        </div>
                        <div class="column">
                            <h1 class="subtitle">Address</h1>
                            <p class="subtitle" data-idaddress="{{id}}" contenteditable="false"></p>
                        </div>
                        <div class="column">
                            <h1 class="subtitle">Contact</h1>
                            <p class="subtitle" data-idcontact="{{id}}" contenteditable="false"></p>
                        </div>
                    </div>
                </div>
                <footer class="modal-card-foot">
                    <div class="field">
                        <span class="control">
                    <a class="button light-blue">View Logs</a>
                </span>
                        <span class="control">
                    <a class="button light-blue">Add Log</a>
                </span>
                        <span class="control">
                    <a class="button light-blue edit-button" onclick="editClient({{id}})" data-editing="true">Edit</a>
                </span>
                    </div>
                    <div class="modal client-edit-close-box" id="confirm-close-box">
                        <div class="message is-warning has-text-centered">
                            <div class="message-header">
                                <h1 class="">Close and Discard Changes?</h1>
                            </div>
                            <div class="message-body">
                                <button class="button" type="button" onclick="confirmEditClose()" value="Yes"></button>
                                <button
                                    class="button" type="button" onclick="">No</button>
                            </div>
                        </div>
                    </div>

                </footer>
            </div>
        </div>
    </script>
<script type="text/javascript">
    (function() {
        var path = '//easy.myfonts.net/v2/js?sid=310636(font-family=Yorkten+Slab+Condensed+Bold)&sid=310638(font-family=Yorkten+Slab+Condensed+Medium)&sid=310639(font-family=Yorkten+Slab+Condensed+Regular)&sid=310642(font-family=Yorkten+Slab+Condensed+Light)&key=G1qIkvCDhz',
            protocol = ('https:' == document.location.protocol ? 'https:' : 'http:'),
            trial = document.createElement('script');
        trial.type = 'text/javascript';
        trial.async = true;
        trial.src = protocol + path;
        var head = document.getElementsByTagName("head")[0];
        head.appendChild(trial);
    })();
    
</script>
</html>
    <!--<p class="title day-date-title" id="wed-mar-22">Wednesday, March 22</p>-->