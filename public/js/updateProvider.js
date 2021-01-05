//telephone number input mask
new Cleave('#UpdateProviderTelephone1',{
    phone : true,
    phoneRegionCode : 'SN',
});
new Cleave('#UpdateProviderTelephone2',{
    phone : true,
    phoneRegionCode : 'SN',
});

function getProvider(e){
    //start by a helper function to grab the current provider
    //update the href
    grabItem(e);
    removeAllAlertMessage();

    $('#UpdateProviderForm').toggle().after('<i class="fas fa-spinner fa-lg fa-fw"></i>');

    $.ajax({

         url : '/get/product/provider/'+ href.split('/').pop(),
         method : "GET",
         contentType : "application/json",

        }).done(function(result){

            if(result.success){
                fillModalWithItemData(result.inputs);
            }else if(!result.success){
                Notyf.error(result.messages);
            }

        }).fail(function(xhr,status){
            var errorMessage = status +" : " + xhr.statusText;
            Notyf.error(errorMessage);
        }).always(function(){
            $('#UpdateProviderForm').toggle().next().remove();
        });

}


//on submit event
$('#updateProvider').on('click',function(e) {
    e.preventDefault();
    removeAllAlertMessage();
   //spinner toggle
   $(e.target).toggle().after("<i class=\"fas fa-spinner fa-lg fa-fw\"></i>");

   //get user inputs
   var providerData = {
         UpdateProviderName : ($('#UpdateProviderName').val()).ucfirst(),
         UpdateProviderEmail : $('#UpdateProviderEmail').val(),
         UpdateProviderAddress : ($('#UpdateProviderAddress').val()).ucfirst(),
         UpdateProviderTelephone1 : $('#UpdateProviderTelephone1').val(),
         UpdateProviderTelephone2 : $('#UpdateProviderTelephone2').val(),
   };

   ajaxItem(e,providerData,href);

});


Echo.private('App.User.admin').listen('.ProductProviderUpdatedEvent',function(e){
    //update list view helpers function
    updateItemList(e.providerUpdated.updateRoute,e.providerUpdated,templateProvider);
    Notyf.success(e.message);
});
