var log_form = $('#log-form');
var modal_content =  $('#modal-content');
var modal_background =  $('#modal-background');
var client_details =  $('#client-details');
var save_new_client_button = $('#saveNewClientButton');
var saved_indicator = $('#saved-indicator');
var log_container = $('#log-container');
var client_name_search = $('#clientName');
var new_client_name_input = $('#newClientName');
var newClientObject ={};
var clientList = [];
function showlog() {
        if ($(log_form).is(":hidden")){
            $(log_form).slideDown("slow");
        }else{
            $(log_form).slideUp();
   }   
};
function delayToggleActive() {
    timeoutID = window.setTimeout(toggleZoom, 1000);
};
function toggleZoom() {
    $(modal_content).removeClass('slideInDown');
    $(modal_content).addClass('slideOutUp');
    $(modal_background).fadeToggle('fast');
    newTimeoutID = window.setTimeout(toggleActive, 300);
};
function toggleActive() {
 $(client_details).removeClass('is-active');
};
function toggleClientDetails() {
    $(new_client_name_input).val($(client_name_search).val());
    $(saved_indicator).hide();
    $(modal_background).fadeToggle('400');
    $(client_details).addClass('is-active');
    if ($(modal_content).hasClass('slideInDown')){
            $(modal_content).removeClass('slideInDown');
            $(modal_content).addClass('slideOutUp');
            toggleZoom();
    }else{
        $(modal_content).addClass('slideInDown');
        $(modal_content).removeClass('slideOutUp');
    }
};
function saveNewClient() {
    $(save_new_client_button).toggleClass('is-loading');
    newClientObject.newClientName =    $.trim($('#newClientName').val());
    newClientObject.newClientPhone   = $.trim($('#newClientPhone').val());
    newClientObject.newClientContact = $.trim($('#newClientContact').val());
    newClientObject.newClientAddress = $.trim($('#newClientAddress').val());
    $.post('save-client.php', {
        newName: newClientObject.newClientName,
        newPhone: newClientObject.newClientPhone,
        newContact: newClientObject.newClientContact,
        newAddress: newClientObject.newClientAddress
                            }, function(data){
    $('#saveNewClientButton').fadeOut('fast', function() {
        $(saved_indicator).fadeIn();
        delayToggleActive();}).toggleClass('is-loading');
    $(saved_indicator).fadeOut('fast', function() {
            $('#saveNewClientButton').fadeIn();
        alert(data);
        });
    }); 
};
function createHTML(jsonObject) {
  var logTemplate = document.getElementById('log-template').innerHTML;
  var compiledTemplate = Handlebars.compile(logTemplate);
  var ourGeneratedHTML = compiledTemplate(jsonObject);
 $(log_container).prepend(ourGeneratedHTML);
};
function saveLog(){
    $('#submitbutton').toggleClass('is-loading');
    var clientName = $.trim($('#clientName').val());
    var dateOccurred = $.trim($('#dateOccurred').val());
    var timeStarted = $.trim($('#timeStarted').val());
    var timeStopped = $.trim($('#timeStopped').val());
    var hoursWorked = $.trim($('#hoursWorked').val());
    var issue = $.trim($('#issue').val());
    var description= $.trim($('#description').val());
    var jsonObject = {};
    jsonObject.name = clientName;
    jsonObject.issue = issue;
    jsonObject.hoursWorked = hoursWorked;
    jsonObject.descripton = description;
    jsonObject.timeStopped = timeStopped;
    jsonObject.timeStarted = timeStarted;
    $.post('save-log.php',{
        client_id: selectedClientId,
        date_occurred: dateOccurred,
        hours_worked: hoursWorked,
        time_started: timeStarted,
        time_stopped: timeStopped,
        issue: issue,
        description: description
        },function(data) {
            alert(data);
            createHTML(jsonObject);
            $('#submitbutton').toggleClass('is-loading');
    });
event.preventDefault();
};
function dothis() {
  date = $('#dateOccurred')
  time1 = $('#timeStarted')
  time2 = $('#timeStopped');
  issue = $('#issue');
  desc = $('#description');
  hours = $('#hoursWorked');
  time2.val('20:20');
  time1.val('16:45');
  date.val('2017-03-23');
  desc.val('Testing');
  issue.val('Testing');
  time2.val() - time1.val();
//   hours.val(a);
  console.log( time2.val() - time1.val());
};
function getClientList() {
    if(sessionStorage.getItem("clientList")){
        return;
    }else{
        $.ajax({
        url:'fetch-clients.php',
        type: 'GET',
        dataType: 'json'}).done(function(data) {
            clientObjectList = data;
            var clientNameList = [];
            $.each(data, function(key, value) {
                clientNameList.push(value.name);
                });
            sessionStorage.setItem("clientList", clientNameList);
           
            awesomplete.list = clientNameList;
            });
        }
}