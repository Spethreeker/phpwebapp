<form id="log-form" class="log-form animated is-hidden" name="newlog" method="POST" class="log" data-parsley-validate>
    <header class="modal-card-head">
        <h1 class="modal-card-title has-text-centered">New Log</h1>
        <button type="button" class="delete" onclick="show('log-form', 'fromleft')"></button>
    </header>
    <div class="notification message is-white">
        <div class="field">
            <label class="label" for="clientName">Client Name</label>
            <div class="field is-grouped is-horizontal">
              <div class="control has-icons-left" id="add-client">
                <input type="search" class="input" id="clientName" name="clientname" placeholder="Search Clients" required/>
                <span class="icon is-small is-left"><i class="fa fa-user" aria-hidden="true"></i></span>
              </div>
              <div class="control">
                <button type="button" class="button" onclick="generateClientList(); show('all-clients-panel', 'fromtop');">
                  <span class="icon">
                    <i class="fa fa-users" aria-hidden="true"></i>
                  </span>
                </button>
                <button type="button" class="button green" id="add-client-button" onclick="copyClientName(); show('client-details', 'fromtop')">
                  New Client
                </button>
              </div>
            </div>
            <div>
                <h4 class="help is-danger is-hidden" id="select-client-warning">Couldn't find that client</h4>
            </div>
        </div>
        <div class="field">
            <label class="label">Date</label>
            <div class="control">
                <input type="text" class="input" id="dateOccurred" />
            </div>
        </div>
        <div class="time-field">
            <div class="field">
                <label class="label" for="timeStarted">Time Started</label>
                <div class="control">
                    <input type="text" class="input" id="timeStarted" />
                </div>
            </div>
            <div class="field">
                <label class="label" for="timeStopped">Time Stopped</label>
                <div class="control">
                    <input type="time" class="input" id="timeStopped" />
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
                <a class="button" type="button" onclick="awesomplete.open();">
            <span class="icon"><i class="fa fa-plus"></i></span><span>Add Items</span></a>
            </div>
            <a class="control button green is-expanded" type="submit" id="submitbutton" name='Submit' onclick="saveLog()">
              <span class="icon" id="submitIcon"><i class="fa fa-check" aria-hidden="true"></i></span><span>Submit</span>
            </a>
            <a class="control button red is-expanded" type="button" onclick="show('log-form','fromleft')">
        <span class="icon"><i class="fa fa-times" aria-hidden="true"></i></span><span>Close</span>
        </a>
        </div>
    </div>
</form>