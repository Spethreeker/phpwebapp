
function showlog() {
             if ($("#log-form").is(":hidden")){
                 $("#log-form").slideDown("slow");
            }else{
                 $("#log-form").slideUp();
   }   
};
function delayToggleActive() {
    timeoutID = window.setTimeout(toggleZoom, 1000);
};
function toggleZoom() {
    $('#modal-content').removeClass('slideInDown');
    $('#modal-content').addClass('slideOutUp');
    $('#modal-background').fadeToggle('fast');
    newTimeoutID = window.setTimeout(toggleActive, 300);
};
function toggleActive() {
 $('#client-details').removeClass('is-active');
};
function toggleClientDetails() {
    $('#newClientName').val($('#clientName').val());
    $('#saved-indicator').hide();
    $('#modal-background').fadeToggle('400');
    $('#client-details').addClass('is-active');
    if ($('#modal-content').hasClass('slideInDown')){
            $('#modal-content').removeClass('slideInDown');
            $('#modal-content').addClass('slideOutUp');
            toggleZoom();
    }else{
        $('#modal-content').addClass('slideInDown');
        $('#modal-content').removeClass('slideOutUp');
    }
   
};
function saveNewClient() {
    $('#saveNewClientButton').toggleClass('is-loading');
    var newClientObject ={};
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
        $('#saved-indicator').fadeIn();
        delayToggleActive();}).toggleClass('is-loading');
    $('#saved-indicator').fadeOut('fast', function() {
            $('#saveNewClientButton').fadeIn();
        alert(data);
        });
    });
    
};
function createHTML(jsonObject) {
  var rawTemplate = document.getElementById("log-template").innerHTML;
  var compiledTemplate = Handlebars.compile(rawTemplate);
  var ourGeneratedHTML = compiledTemplate(jsonObject);
 $('#log-container').prepend(ourGeneratedHTML);
}
function go(){
    $('#submitbutton').toggleClass('is-loading');
    var clientName = $.trim($('#clientName').val());
    var issue = $.trim($('#issue').val());
    var hoursWorked = $.trim($('#hoursWorked').val());
    var description= $.trim($('#description').val());
    
    var jsonObject = {};
    jsonObject.name = clientName;
    jsonObject.issue = issue;
    jsonObject.hoursWorked = hoursWorked;
    jsonObject.descripton = description;
    $.post('submit-log.php',{
                            clientname: clientName,
                            issue: issue,
                            hours_worked: hoursWorked,
                            description: description
        },function(data) {
            createHTML(jsonObject);
            $('#submitbutton').toggleClass('is-loading');
    });
event.preventDefault();
};

