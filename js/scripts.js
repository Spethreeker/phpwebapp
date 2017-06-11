var log_form = $('#log-form');
var new_client_modal =  $('#new-client-modal');
var all_clients_modal = $('#all-clients-modal')
var modal_background =  $('#new-client-modal-background');
var client_details =  $('#client-details');
var save_new_client_button = $('#saveNewClientButton');
var saved_indicator = $('#saved-indicator');
var log_container = $('#log-container');
var client_name_search = $('#clientName');
var new_client_name_input = $('#newClientName');
var options_panel = $('#options-panel');
var newClientObject ={};
var clientlist = [];

function toggleClientDetails() {
    $(new_client_name_input).val($(client_name_search).val());
};
function show(id, type) {
    switch (type) {
        case 'fromright':
        var that = $("#" + id);
             that.removeClass("is-hidden");
        if (that.hasClass('slideInRight')){
            that.removeClass('slideInRight');
            that.addClass('slideOutRight');
        }else{
            that.addClass('slideInRight');
            that.removeClass('slideOutRight');
        }
        break;
        case 'fromleft':
        var that = $("#" + id);
        that.removeClass("is-hidden");
         if (that.hasClass('slideInLeft')){
        that.removeClass('slideInLeft');
        that.addClass('slideOutLeft');
        }else{
        that.addClass('slideInLeft');
        that.removeClass('slideOutLeft');
        }
        break;
        case 'fromtop':
        var that = $("#" + id);
        that.removeClass("is-hidden");
        that.toggleClass('is-active');
        if (that.hasClass('slideInDown')){
            that.removeClass('slideInDown');
            that.addClass('slideOutUp');
        }else{
        that.addClass('slideInDown');
        that.removeClass('slideOutUp');
    }

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
        delayToggleActive();
    }).toggleClass('is-loading');
        $(saved_indicator).fadeOut('fast', function() {
            $('#saveNewClientButton').fadeIn();
        
        });
    }); 
    
};
function createHTML(jsonObject) {
  var dateTimeStamp = jsonObject.dateTimestamp //if it breaks i added 'var' here
  if (!document.getElementById(dateTimeStamp)){
    var dayTemplate = document.getElementById('day-template').innerHTML;
    var compiledTemplate = Handlebars.compile(dayTemplate);
    var ourGeneratedHTML = compiledTemplate(jsonObject);  
    $(log_container).prepend(ourGeneratedHTML);
  }else{
    var logTemplate = document.getElementById('log-template').innerHTML;
    var compiledTemplate = Handlebars.compile(logTemplate);
    var ourGeneratedHTML = compiledTemplate(jsonObject);
    $('#' + dateTimeStamp).append(ourGeneratedHTML);
    }
};

function dothis() {
  date = $('#dateOccurred')
  time1 = $('#timeStarted')
  time2 = $('#timeStopped');
  issue = $('#issue');
  desc = $('#description');
  hours = $('#hoursWorked');
  time2.val('19:20');
  time1.val('15:45');
  date.val('2017-05-13');
  desc.val('Boopity');
  issue.val('Bop');
  time2.val() - time1.val();
//   hours.val(a);
  console.log( time2.val() - time1.val());
};

function getClientList() {
 if (localStorage.getItem('clientlist') == null){
    $.ajax({
    url:'php/fetch-clients.php',
    type: 'GET',
    dataType: 'json'}).done(function(data) {
        var clientNameList = [];
        $.each(data, function(key, value) {
            clientNameList.push(value.name);
            });
        awesomplete.list = clientNameList;
        console.log("went and got it");
        localStorage.setItem('clientlist', JSON.stringify(data));
        clientlist = data;
    });
 } else {
     var clientNameList = [];
     clientlist = JSON.parse(localStorage.getItem('clientlist'));
     $.each(clientlist, function(key, value) {
        clientNameList.push(value.name);
        });
        awesomplete.list = clientNameList;
        console.log("worked");
 }
};
function generateClientList() {
    
};

//Anything to do with getting or saving logs

function saveLog(){
    $('#submitbutton').toggleClass('is-loading');
    var clientName = $.trim($('#clientName').val());
    var dateOccurred = $.trim($('input[name=date_submit]').val());
    var dateTimestamp = Date.parse(dateOccurred)/1000;
    var timeStarted = $.trim($('input[name=started_submit]').val());
    var timeStopped = $.trim($('input[name=stopped_submit]').val());
    var hoursWorked = $.trim($('#hoursWorked').val());
    var issue = $.trim($('#issue').val());
    var description= $.trim($('#description').val());

    var jsonObject = {};
    jsonObject.name = clientName;
    jsonObject.issue = issue;
    jsonObject.dateOccurred = moment().format("dddd, Do");
    jsonObject.dateTimestamp = dateTimestamp;
    jsonObject.hoursWorked = hoursWorked;
    jsonObject.descripton = description;
    jsonObject.timeStopped = timeStopped;
    jsonObject.timeStarted = timeStarted;

    $.post('php/save-log.php',{
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
function showLogDetails(id){
   var clickedLog = $('#' + id);
   var descCont = clickedLog.find('.desc-container');
   var downArrow = clickedLog.find('#down-arrow');
   if(clickedLog.attr('data-log-clicked') !== 'true'){
    downArrow.toggleClass('spin-around');
    clickedLog.attr('data-log-clicked','true')
        $.ajax({
            type: 'GET',
            url: 'php/get-desc.php',
            data: {
                log_id: id
            },
            datetype: 'text'
        }).done( function(data) {
            descCont.append('<h1 class="subtitle">'+data+'</h1>');
            // descCont.removeClass('slideOutUp');
            // descCont.removeClass('is-hidden');
            // descCont.addClass('slideInDown');
            descCont.toggleClass('is-hidden');
            downArrow.toggleClass('spin-around rotate')
        });
   }else{
    //    descCont.removeClass('slideInDown');
    //    descCont.addClass('slideOutUp');
    descCont.toggleClass('is-hidden');
    downArrow.toggleClass('rotate');
   }
};
