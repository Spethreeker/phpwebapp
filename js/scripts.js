function showlog() {
             if ($("#log-form").is(":hidden")){
                 $("#log-form").slideDown("slow");
            }else{
                 $("#log-form").slideUp();
   }   
};
function toggleClientDetails() {
                //   $('#client-details').fadeToggle("fast");
                $('#client-details').toggleClass('is-active');
};
function saveClientDetails() {
                  $('#client-details').fadeToggle("fast");
   
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
