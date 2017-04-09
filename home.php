<!DOCTYPE html>
<?php
session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
        header("Location: index.php");

    }

?>


    <html>

    <head>
        <link rel="stylesheet" href="css/bulma.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="jquery-3.2.0.min.js"></script>
        <script src="parsley.js"></script>
        <script src="scripts.js"></script>
        <script>
            $(document).ready(function () {
                $('#client-details').hide();
            });
        </script>
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
                    <p class="title white-font"></p>
                </div>
            </div>
            <buton class="nav-toggle" onclick="navtoggle()">
                <span></span>
                <span></span>
                <span></span>
                </button>
        </nav>

        <div id="whole-thing">
            <div class="level nav-menu" id="navbar">
                <div class="level-left">
                    <button class="level-item button light-blue" onclick="showlog()" id="add-log-button">+ Add Log</button>
                    <button class="level-item button light-blue">* Edit Log</button>
                    <button class="level-item button light-blue" href="index.php">Log out</button>
                </div>
            </div>
            <div id="log-form" class="log-form">
                <form class="notification" name="newlog" action="makelog.php" method="POST" class="log">
                    <div class="tile is-ancestor">
                        <fieldset class="tile is-parent is-1" style="border: none;">
                            <div class="tile is-child">
                                <label class="label" for="clientname">Client Name</label>                                <br>
                                <input type="text" class="input" name="clientname" placeholder="Client name" /><br>
                                <label class="label" for="clientphone">Phone Number</label><br>
                                <input type="tel" class="input" name="clientphone" placeholder=""/><br>

                            </div>

                            <button class="button is-link is-small" type="button" onclick="showClientDetails()">+ Client Details</button>
                        </fieldset>
                        <div class="tile is-parent" id="client-details">
                            <div class="tile is-child">
                                <label class="label" for="clientcontact">Contact</label>
                                <br>
                                <input type="text" class="input" name="clientcontact" placeholder="Contact Name" />
                               <br>
                                <label class="label" for="clientadress">Client Address</label><br>
                                <input type="text" class="input" name="clientaddress"/><br>
                                <button type="button" class="button is-small green" onclick="hideClientDetails()">Save Details</button>
                            </div>
                            
                        </div>
                    </div>
                    <div class="tile is-ancestor is-vertical">
                        <fieldset class="tile is-parent is-3" style="border: none;">
                            <div class="tile is-child">
                                <label class="label" for="workdescription">Work Description</label>
                                <input type="text" class="input" name="description" placeholder="Description" />
                            </div>


                        </fieldset>



                        <fieldset class="tile is-parent" style="border: none;">
                            <div class="tile is-child">
                                <legend class="label">Date</legend>
                                <div class="control">
                                    <input type="radio" name="date-select" class="checkbox" />
                                    <label for="date-today" class="label">Today</label><br>
                                    <input type="radio" name="date-select" class="checkbox">
                                    <label for="date-specific" class="label">On This Day</label>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="tile is-3" style="border: none;">
                            <input class="button light-blue" type="submit" name='Submit' for="newlog" value="Submit">
                            <button class="button red" type="button" onclick="showlog()">Cancel</button>
                        </fieldset>


                    </div>
                </form>
                <br>


            </div>
            <div id="saved-logs">
                <article class="media day">
                    <p class="subtitle day-date-title" id="wed-mar-22">Wednesday, March 22</p>

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
                <article class="media day">
                    <p class="subtitle day-date-title">Tuesday, March 21</p>

                    <div class="media log">
                        <div class="media-content">
                            <h3 class="title customer-name">Sal's Sacks</h3>
                            <p class="subtitle work-description">Fixed checkout computer</p>
                        </div>
                    </div>
                    <div class="media log">
                        <div class="media-content">
                            <h3 class="title customer-name">Doug's Dog Pound</h3>
                            <p class="subtitle work-description">Reinstalled Doggy software</p>
                        </div>
                    </div>
                </article>
                <article class="media log">
                    <figure class="media-left date">
                        <p class="title month">Monday</p>
                        <p class="subtitle day">March 20</p>
                    </figure>
                    <div class="media-content">
                        <h3 class="title customer-name">Doug's Dog Pound</h3>
                        <p class="subtitle work-desctription">Reinstalled Doggy software</p>
                    </div>
                </article>

            </div>
        </div>
    </body>
    <script>
        function navtoggle() {
            var d = document.getElementById("navbar");
            if (d.classList.contains("is-active")) {
                d.classList.remove("is-active");
            } else {
                d.classList.add("is-active");
            }
        }
    </script>

    </html>