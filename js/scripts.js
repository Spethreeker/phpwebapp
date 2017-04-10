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