function showlog() {
             if ($("#log-form").is(":hidden")){
                 $("#log-form").slideDown("slow");
            }else{
                 $("#log-form").slideUp();
       
   }
            
};
function toggleClientDetails() {
                  $('#client-details').fadeToggle("fast");
   
};
function saveClientDetails() {
                  $('#client-details').fadeOut("fast");
   
};
function createHTML(jsonObject) {
  var rawTemplate = document.getElementById("log-template").innerHTML;
  var compiledTemplate = Handlebars.compile(rawTemplate);
  var ourGeneratedHTML = compiledTemplate(jsonObject);
 $('#log-container').prepend(ourGeneratedHTML);
}
