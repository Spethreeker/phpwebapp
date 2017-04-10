function showlog() {
             if ($("#log-form").is(":hidden")){
                 $("#log-form").slideDown();
                 $("#add-log-button").toggleClass("red");
            }else{
                 $("#log-form").slideUp();
       
   }
};