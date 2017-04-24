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
function submitLog() {
      
        
         $('#newform').find("input[name='clientname']" ).val();
        
          var posting = $.post('submitlog.php', { clientname: clientName });
          
        //   posting.done(function( data ) {
        //       var content = $( data ).find('#content');
        //       $("#result").empty().append( content );
        //   });
      };