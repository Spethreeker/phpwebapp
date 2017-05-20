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
        <script src="js/jquery-3.2.0.min.js"></script>
        <script src="js/handlebars-v4.0.5.js"></script>
        <script src="js/scripts.js"></script>
        <!--<script src="js/SmoothScroll.js"></script>-->
        <script src="js/easing.js"></script>
        <script src="https://use.fontawesome.com/a9de8a2dbb.js"></script>
        <script>
            var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
                "October", "November", "December"
            ];
            var todaysdate = new Date();
            jQuery.easing.def = 'easeOutQuad';
            $(document).ready(function () {
                document.getElementById("today").innerHTML = days[todaysdate.getDay()] + ", " + months[
                    todaysdate.getMonth()] + " " + todaysdate.getDate();
                var form = $('#newlog');
            });
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
        <form class="modal" id="client-details" data-parsley-validate="">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div class="modal-card-head">
                    <h1 class="modal-card-title has-text-centered">Add A Client</h1><button class="delete" type="button" onclick="toggleClientDetails()"></button></div>
                <div class="modal-card-body">
                    <div class="field">
                        <label class="label" for="clientname">Client Name</label>
                        <div class="control">
                            <input type="text" class="input" id="addClientName" name="addClientname" placeholder="Client name" required="" />
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="clientphone">Phone Number</label><br>
                        <div class="control"><input type="tel" class="input" name="clientphone" placeholder="" /></div>
                    </div>
                    <div class="field">
                        <label class="label" for="clientcontact">Contact Name</label>
                        <div class="control"><input type="text" class="input" name="clientcontact" /></div>
                    </div>
                    <div class="field"><label class="label" for="clientadress">Address</label>
                        <div class="control"><input type="text" class="input" name="clientaddress" /></div>
                    </div>
                </div>
                <div class="modal-card-foot has-text-centered">
                    <button type="button" class="submit-button button green" onclick="toggleClientDetails()">
                        <span class="icon"> <i class="fa fa-check" aria-hidden="true"></i>
                        </span><p class="header">Save Client</p>
                    </button>
                    <button class="button red control" type="button" onclick="toggleClientDetails()">
                        <span class="icon"><i class="fa fa-times" aria-hidden="true">
                        </i></span><p class="header">Cancel</p>
                    </button>
                </div>
            </div>
        </form>
        <div class="container" id="whole-thing">
            <div id="saved-logs">
                <article class="media day">
                    <div class="">
                       
                            <div class="field is-pulled-right">
                                <button class="control button light-blue has-text-centered" onclick="showlog()" id="add-log-button">
                                    <span class="icon"><i class="fa fa-plus"></i></span>
                                    <span class="is-hidden-mobile">Add Log</span>
                                </button>
                                
                            </div>
                            <p class="title day-date-title" id="today"></p>
                          
                        
                    </div>
                    <div id="log-form" class="log-form" style="display: block;">
                        <form class="notification" id="newlog" name="newlog" method="POST" class="log">
                            <div class="tile is-ancestor">
                                <div class="tile is-parent is-vertical">
                                    <div class="tile is-child">
                                        <label class="label" for="clientname">Client Name</label><br>
                                        <div class="field">
                                            <div class="control has-icons-left">
                                                <input type="text" class="input" id="clientName" name="clientname" placeholder="Client name" />
                                                <span class="icon is-small is-left"><i class="fa fa-user" aria-hidden="true"></i></span>
                                            </div>
                                                <button type="button" class="button green" onclick="toggleClientDetails()">Add New Client</button>
                                            </div>
                                        </div>
                                        <label class="label" for="issue">Issue</label>
                                        <div class="field">
                                            <div class="control">
                                                <input type="text" class="input" name="issue" id="issue" placeholder="What was wrong" />
                                            </div>
                                        </div>
                                        <label class="label" for="workdescription">Hours Worked</label><br>
                                        <div class="field">
                                            <div class="control">
                                                <input type="number" class="" id="hoursWorked" placeholder="in hours" maxlength="4" size="4" /><br/>
                                            </div>
                                        </div>
                                        <label class="label" for="longDescription">Work Description</label>
                                        <div class="field">
                                            <div class="control">
                                                <textarea type="textarea" class="textarea" id="description" placeholder="Describe"></textarea>
                                            </div>
                                        </div>
                                        <div class="field is-grouped">
                                            <button class="control button green" type="button" id="submitbutton" onclick="go()" name='Submit'>
                                                <span class="icon" id="submitIcon"><i class="fa fa-check" aria-hidden="true"></i></span><span>Submit</span>
                                            </button>
                                            <button class="control button red" type="button" onclick="showlog()">
                                                <span class="icon"><i class="fa fa-times" aria-hidden="true"></i></span><span>Close</span>
                                            </button>
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
                    <p class="title day-date-title" id="wed-mar-22">Wednesday, March 22</p>
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
                                <button class="button is-medium has-addons has-text-centered" id="view-log-button">
                                    <span class="icon"><i class="fa fa-eye"></i></span>
                                    <span class="is-hidden-mobile">View</span>
                                </button>
                            </div>
                            <div class="control has-addons">
                                <button class="button is-medium has-addons has-text-centered" id="edit-log-button">
                                    <span class="icon"><i class="fa fa-pencil"></i></span>
                                    <span class="is-hidden-mobile">Edit</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="media log">
                        <div class="media-content">
                            <h3 class="title customer-name">Doug's Dog Pound</h3>
                            <p class="subtitle work-description">Reinstalled Doggy software</p>
                            <div class="work-duration">
                                <p class="work-start-time">9:25 A.M.</p>
                                <p>&nbsp-&nbsp</p>
                                <p class="work-end-time">10:00 A.M.</p>
                            </div>
                        </div>
                    </div>
                </article>
                </div>
                </div>
    </body>
    <script src="js/parsley.min.js"></script>
    <script src="js/awesomplete.min.js"></script>
   
    <script>
        var userid = <?php echo $_SESSION['id'];?>;
        var listofClients = "";
        var input = document.getElementById("clientName");
        $.post("fetch-clients.php", {
            id: userid
        }, function (data) {
            listofClients = JSON.parse(data);
            var awesomplete = new Awesomplete(input, {
                autoFirst: true
            });
            awesomplete.list = listofClients;
            //   document.cookie
        });
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
        </div>
    </script>

    </html>