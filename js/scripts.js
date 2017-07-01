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
var allClientsListGenerated = false;
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
        console.log("went and got it");
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

function copyClientName() {
    $(new_client_name_input).val($(client_name_search).val());
};
function show(id, type, deffered) {
    let that = document.getElementById(id);
    that.classList.remove("is-hidden");
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
        // if (that.classList.contains('is-active')){
        //     that.classList.remove('is-active');
        // } else {
        //     that.classList.add('is-active');
        // }
        if (that.classList.contains('slideInDown')){
            that.classList.remove('slideInDown');
            that.classList.add('slideOutUp');
        }else{
        that.classList.add('slideInDown');
        that.classList.remove('slideOutUp');
        }
    }
};

function saveNewClient() {
    var newClientObject ={};
    newClientObject.newClientName =    $.trim($('#newClientName').val());
    newClientObject.newClientPhone   = $.trim($('#newClientPhone').val());
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

function generateClientList() {
    if (allClientsListGenerated == false){
        let all_clients_container = $('#all-clients-container');
        let clientTemplate = document.getElementById('client-template').innerHTML;
        let compiledTemplate = Handlebars.compile(clientTemplate);
        for (var objectNumber = 0; objectNumber < clientlist.length; objectNumber++){
            var element = clientlist[objectNumber];
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
     console.log("ajaxed");
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

function editClient(id) {
    var that = $('#' + id);
    var editButton = $(that).find('.edit-button');
    var detailsChanged = null;
    if ($(that).attr('data-editing') === "true" && $(editButton).attr('data-editing') === "true"){
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
        data = data;
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
        editButton.addClass('light-blue');
        editButton.removeClass('green');
        editButton.text("Edit");
       
    }
    else if ($(that).attr('data-editing') === "false") {
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
        $(editButton).attr('data-editing', true);
        editButton.addClass('green');
        editButton.removeClass('light-blue');
        editButton.text("Save");
        
    }
   
}
function saveLog(){
    $('#submitbutton').toggleClass('is-loading');
    let clientName = $.trim($('#clientName').val());
    let dateOccurred = $.trim($('input[name=date_submit]').val());
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
   var clickedLog = $('[data-log-id='+id+']');
   var descCont = clickedLog.find('.desc-container');
   var downArrow = clickedLog.find('#down-arrow');
   if(clickedLog.attr('data-log-clicked') !== 'true'){
    downArrow.toggleClass('spin-around');
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
            downArrow.toggleClass('spin-around rotate')
        });
   }else{
    //    descCont.removeClass('slideInDown');
    //    descCont.addClass('slideOutUp');
    descCont.toggleClass('is-hidden');
    downArrow.toggleClass('rotate');
   }
};
