function copyClientName(){$(new_client_name_input).val($(client_name_search).val());};
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
var clientDetailsBox = null;
var clientlist = [];
function clearLocal(){
    localStorage.clear();
    getClientList();
}
$(function() {
    clearLocal();
});
function getClientList() {
 if (localStorage.getItem('clientlist') == null){
    $.ajax({
    url:'php/fetch-clients.php',
    type: 'GET',
    dataType: 'json'}).done(function(data) {
        let clientNameList = [];
        $.each(data, function(key, value) {
            clientNameList.push(value.name);
            });
        awesomplete.list = clientNameList;
        console.log("got clientlist");
        localStorage.setItem('clientlist', JSON.stringify(data));
        clientlist = data;
    })
 } else {
     let clientNameList = [];
     clientlist = JSON.parse(localStorage.getItem('clientlist'));
     $.each(clientlist, function(key, value) {
        clientNameList.push(value.name);
        });
        awesomplete.list = clientNameList;
        console.log("worked");
        }
};

function createHTML(jsonObject) {
  var dateTimeStamp = jsonObject.dateTimestamp //if it breaks i added 'var' here
  if (!document.getElementById(dateTimeStamp)){
    let dayTemplate = document.getElementById('day-template').innerHTML;
    let compiledTemplate = Handlebars.compile(dayTemplate);
    let ourGeneratedHTML = compiledTemplate(jsonObject);
    $(log_container).prepend(ourGeneratedHTML);
  }else{
    let logTemplate = document.getElementById('log-template').innerHTML;
    let compiledTemplate = Handlebars.compile(logTemplate);
    let ourGeneratedHTML = compiledTemplate(jsonObject);
    $('#' + dateTimeStamp).append(ourGeneratedHTML);
    }
};
function toggStatus(stat){
    var e=document.getElementById('job-finished-input'),
        f=document.getElementById('job-ongoing-input');
    if (stat === 'finished'){
        e.classList.toggle('is-hidden');
        f.classList.add('is-hidden');
    }
    if(stat === 'ongoing'){
        f.classList.toggle('is-hidden');
        e.classList.add('is-hidden');
    }
}
function show(id, type, callback) {
    let that = document.getElementById(id);
    that.classList.remove("is-hidden");
    if (that.classList.contains('modal')){
      that.classList.add('is-active');
    };
    switch (type) {
        case 'fromright':
            if (that.classList.contains('slideInRight')){
                that.classList.remove('slideInRight');
                that.classList.add('slideOutRight');
            }else{
                that.classList.add('slideInRight');
                that.classList.remove('slideOutRight');
            }
        break;
        case 'fromleft':
            if (that.classList.contains('slideInLeft')){
                that.classList.remove('slideInLeft');
                that.classList.add('slideOutLeft');
            }else{
                that.classList.add('slideInLeft');
                that.classList.remove('slideOutLeft');
            }
        break;
        case 'fromtop':
            if (that.classList.contains('slideInDown')){
                that.classList.remove('slideInDown');
                that.classList.add('slideOutUp');
            }else{
                that.classList.add('slideInDown');
                that.classList.remove('slideOutUp');
            }
        break;
        case 'fade':
            if (that.classList.contains('fadeIn')){
                that.classList.remove('fadeIn');
                that.classList.add('fadeOut');
            }else{
                that.classList.add('fadeIn');
                that.classList.remove('fadeOut');
            }
    }
      
};
function saveNewClient() {
    var newClientObject ={};
    newClientObject.newClientName =    $.trim($('#newClientName').val());
    newClientObject.newClientPhone = $.trim($('#newClientPhone').val());
    newClientObject.newClientContact = $.trim($('#newClientContact').val());
    newClientObject.newClientAddress = $.trim($('#newClientAddress').val());
    $(save_new_client_button).toggleClass('is-loading');
    $.post('php/save-client.php', {
        newName: newClientObject.newClientName,
        newPhone: newClientObject.newClientPhone,
        newContact: newClientObject.newClientContact,
        newAddress: newClientObject.newClientAddress
                            }, function(data){
    }).done( function() {
$(saved_indicator).addClass('fadeIn');
    $(saved_indicator).removeClass('is-hidden');
    $('#saveNewClientButton').fadeOut('fast', function() {
    }).toggleClass('is-loading');
       clearLocal();
    });
};

var allClientsListGenerated = false;
function generateClientList() {
    let srtedList = clientlist.sort();
    if (allClientsListGenerated === false){ //Makes sure the list only generates once
        let all_clients_container = $('#all-clients-container');
        let compiledTemplate = Handlebars.compile(document.getElementById('client-template').innerHTML);
        for (var objectNumber = 0; objectNumber < srtedList.length; objectNumber++){
            var element = srtedList[objectNumber];
            var ourGeneratedHTML = compiledTemplate(element);
            $(all_clients_container).append(ourGeneratedHTML);
        }
        allClientsListGenerated = true;
        console.log("generated list");
    } else {
        return false;
    }
};

function showClientDetails(id, close) {
    var that  = $('#' + id);
     clientDetailsBox = $(that).find('.details-content');
     clientDetailsToggle = $(that).find('.client-details-toggle');
    if ($(that).attr('data-editing') === "true" && close === 'close'){
        var closeBox = document.getElementById("confirm-close-box");
        closeBox.classList.add('is-active');
        return;
    }else if ($(that).attr('data-editing') === "true"){
        return; 
    }
    if ($(that).attr("data-ajaxed") !== "true"){
        $.ajax({
        url:'php/fetch-client-details.php',
        type: 'GET',
        data: {client_id:id},
        dataType: 'json'}).done(function(data) {
            var clientDetails = data;
            var phone_Num = $(that).find($('[data-idphone="' + id + '"]'));
            var addr = $(that).find($('[data-idaddress="' + id + '"]'));
            var contact = $(that).find($('[data-idcontact="' + id + '"]'));
            phone_Num.text(clientDetails['phone']);
            addr.text(clientDetails['address']);
            contact.text(clientDetails['contact']);
            let container = $(clientDetailsBox).find('.columns');
            let loader = $(clientDetailsBox).find('.loader');
            loader.addClass('is-hidden');
            container.removeClass('is-hidden');
            container.addClass('fadeIn');
            clientDetailsToggle.addClass('is-active');
    });
     console.log("got client details");
     $(that).attr("data-ajaxed", true);
}
    if ($(that).attr('data-detailsexpanded') == "true"){
        clientDetailsBox.addClass('is-hidden');
        clientDetailsToggle.removeClass('is-active');
        $(that).attr('data-detailsexpanded', "false");
        console.log("shrunk");
    }else{
        clientDetailsToggle.addClass('is-active');
    clientDetailsBox.removeClass('is-hidden');
    $(that).attr('data-detailsexpanded', "true");
    }
};

var clientToEdit = null;
function delClient() {
    var error =  null;
    $.post('php/delete-client.php', {
        clientID: clientToEdit,
    }, function(data){
        error = data;
    }).done( function() {
        console.log(error);
        show('confirm-delete-modal', 'fade');
        document.getElementById('confirm-delete-modal').classList.remove('is-active');
        $('#'+clientToEdit).remove();
        console.log('button works' + ' '+ clientToEdit);
    });
};
function editClient(id) {
    clientToEdit = id;
    var that = $('#' + id),
    data = null,
    detailsChanged = null,
    editBtn = $(that).find('.edit-button'),
    deleteBtn = $(that).find('.delete-client-button');
    console.log(clientToEdit);
    if ($(that).attr('data-editing') === "true" && $(editBtn).attr('data-editing') === "true"){ //save editing
        var editedClientObj = {};
        var phone = $(that).find( $('[data-idphone="' + id + '"]') ).text();
        var addr = $(that).find( $('[data-idaddress="' + id + '"]') ).text();
        var name = $(that).find( $('[data-idname="' + id + '"') ).text();
        var contact = $(that).find( $('[data-idcontact="' + id + '"') ).text();
        console.log(phone, addr, name, contact);
        $.post('php/edit-client.php', {
        clientID: id,
        newName: name,
        newPhone: phone,
        newContact: contact,
        newAddress: addr
    }, function(data){
        var data = data;
        console.log(data);
    }).done( function() {
        if (data == " "){ 
            alert("success");
        };
           clearLocal();
        });
    }
    if ($(that).attr('data-editing') === "true"){
        $('#'+id + '' + ' [contenteditable="true"]').each( function(){
            this.setAttribute('contenteditable', 'false');
            this.classList.remove('input');
        })
        $('#'+id + '' + ' .button:not(.edit-button)').each( function(){
           this.classList.remove('is-disabled');
        });
        $(that).attr('data-editing', false);
        editBtn.addClass('light-blue');
        editBtn.removeClass('green');
        editBtn.text("Edit");
        deleteBtn.addClass('is-hidden');
    }
    else if ($(that).attr('data-editing') === "false") { //start editing
        $('#'+id + '' + ' [contenteditable="false"]').each( function(){
            this.setAttribute('contenteditable', 'true');
            this.classList.add('input');
            this.addEventListener('input', function() {
                detailsChanged = true;
            })
        })
        $('#'+id + '' + ' .button:not(.edit-button)').each( function(){
        this.classList.add('is-disabled');
        });
        $(that).attr('data-editing', true);
        $(editBtn).attr('data-editing', true);
        editBtn.addClass('green');
        editBtn.removeClass('light-blue');
        editBtn.text("Save");
        deleteBtn.removeClass('is-hidden');
    }
}
function saveLog(){
    if (selectedClientId === null){ //makes sure client was selected before saving log
        alert("You didn't select a client");
        return;
    }

    var clientName = $.trim($('#clientName').val());
    var dateOccurred = $.trim($('input[name=date_submit]').val());
    var dateTimestamp = Date.parse(dateOccurred)/1000,
    timeStarted = $.trim($('input[name=started_submit]').val()),
    timeStopped = $.trim($('input[name=stopped_submit]').val()),
    hoursWorked = $.trim($('#hoursWorked').val()),
    issue = $.trim($('#issue').val());
    
    if (document.getElementById('finished-radio').checked){
        
    }
    var jsonObject = {};
    jsonObject.name = clientName;
    jsonObject.dateOccurred = moment().format("dddd, Do");
    jsonObject.dateTimestamp = dateTimestamp;
    jsonObject.timeStarted = timeStarted;
    jsonObject.timeStopped = timeStopped;
    jsonObject.hoursWorked = hoursWorked;
    jsonObject.issue = issue;

    for (var key in jsonObject) {
        if (jsonObject[key] === null || jsonObject[key] === ""){
            alert('Please fill in the '+key+' field');
            return;
        }
    }

    $('#submitbutton').toggleClass('is-loading');
    $.post('php/save-log.php',{
        client_id: selectedClientId,
        date_occurred: dateOccurred,
        hours_worked: hoursWorked,
        time_started: timeStarted,
        time_stopped: timeStopped,
        issue: issue
       
    },function(data) {
        if (data.match(/[0-9]/i)){
            if (data.match(/[a-z]/i)){
                alert(data);
            }
            else{
                jsonObject.logId = data;
                console.log(jsonObject.logId);
                show('log-form', 'fromleft');
                createHTML(jsonObject);
                $('#submitbutton').toggleClass('is-loading');
            }
        }
        else {
            alert("An error occurred" + data);
        }
    });
    event.preventDefault();
};
function fillInLog(){
    let dateOccurred = $.trim($('input[name=date_submit]').val());
    var descriptions = ["Needed a new power supply", "Didn't pay electric bill", "House was too old","Talked too much"];
    var issues = ["Computer wouldn't cut on", "Lights wouldn't work", "House smelt bad","Family Left"];
    var dates = ["2017-07-12", "2017-06-05", "2017-05-05", "2017-07-04"];
    var times = ["3:30", "4:40", "5:30", "6:30"];
    var value = randomWithRange();
   
    var dateTimestamp = (Date.parse(dates[randomWithRange()])/1000);
    $('input[name=started_submit]').val(times[randomWithRange()]);
    $('input[name=stopped_submit]').val(times[randomWithRange()]);
    $('#hoursWorked').val((times[randomWithRange()]));
    $('#issue').val((issues[randomWithRange()]));
    $('#description').val((descriptions[randomWithRange()]));
}
function showLogDetails(id){
   var clickedLog = $('[data-log-id='+id+']');
   var descCont = clickedLog.find('.desc-container');
   var btn = clickedLog.find('.client-details-toggle');
   btn.toggleClass('is-active');
   if(clickedLog.attr('data-log-clicked') !== 'true'){
    clickedLog.attr('data-log-clicked','true')
        $.ajax({
            type: 'GET',
            url: 'php/fetch-desc.php',
            data: {
                log_id: id
            },
            datetype: 'text'
        }).done( function(data) {
            descCont.append('<h1 class="subtitle font">'+data+'</h1>');
            // descCont.removeClass('slideOutUp');
            // descCont.removeClass('is-hidden');
            // descCont.addClass('slideInDown');
            descCont.toggleClass('is-hidden');

        });
   }else{
    //    descCont.removeClass('slideInDown');
    //    descCont.addClass('slideOutUp');
    descCont.toggleClass('is-hidden');
 
   }
};
