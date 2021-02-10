//provider template
var templateProvider = '<div class="card m-4 p-0 shadow rounded" style="min-width: 250px">'+
                            '<div class="card-body overflow-hidden">'+
                                '<div class=" btn mr-1 p-0 dashboard-item shadow rounded">'+
                                    '<input type="checkbox" class="btn btn-light option-input cursor checkbox checkbox-2x" id=":id">'+
                                '</div>'+
                                '<a href=":deleteRoute" onclick="grabItem(event);" data-toggle="modal" data-target="#modalDelete" class="dashboard-item btn btn-light p-1 shadow rounded">'+
                                    '<i class="fas fa-window-close fa-2x fa-fw text-danger"></i>'+
                                '</a>'+
                                '<a href=":updateRoute" onclick="getProvider(event);" data-toggle="modal" data-target="#modalUpdateProvider" class="dashboard-item btn btn-light p-1 shadow rounded">'+
                                    '<i class="fas fa-edit fa-2x"></i>'+
                                '</a>'+
                            '</div>'+
                            '<a href=":viewRoute" onclick="viewProviderInfo(event);" type="button" data-toggle="modal" data-target="#providerView" class="dashboard-item btn btn-light">'+
                                '<div class="card-footer bg-primary text-left">'+
                                        '<div class="row justify-content-center-between flex-nowrap  card-footer-max-height shadow rounded">'+
                                            '<div class="col-11 flex-grow-0 bg-light text-light" style="font-size: 18px;">'+
                                                '<div class="row bg-light text-secondary justify-content-center">'+
                                                    '<span>:name</span>'+
                                                '</div>'+
                                                '<div class="row bg-light text-secondary justify-content-center">'+
                                                '<span>:telephone1</span>'+
                                                '</div>'+
                                                '<div class="row bg-light text-secondary justify-content-center">'+
                                                '<span>:telephone2</span>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="col-1 bg-secondary text-white">:itemLeft</div>'+
                                        '</div>'+
                                '</div>'+
                            '</a>'+
                        '</div>';

//telephone number input mask
new Cleave('#ProviderTelephone1',{
    phone : true,
    phoneRegionCode : 'SN',
});
new Cleave('#ProviderTelephone2',{
    phone : true,
    phoneRegionCode : 'SN',
});
//new provider template
// var newProviderTemplate = '';

// URL object
var params = new URLSearchParams(location.search);
// if action == new provider is set in URL show the modal to start
// creating a new provider
if(params.get('action') == 'new'){
    $('#newProviderFormBtn').click();
}

//event on add provider send ajax request
$('#addProvider').on('click',function(e) {
    e.preventDefault();
   removeAllAlertMessage();
   setMultipleItemActionFlag(false);

   //spinner toggle
   $(e.target).toggle().after("<i class=\"fas fa-spinner fa-lg fa-fw\"></i>");

   //get user inputs
   var providerData = {
         ProviderName : ($('#ProviderName').val()).ucfirst(),
         ProviderEmail : $('#ProviderEmail').val(),
         ProviderAddress : ($('#ProviderAddress').val()).ucfirst(),
         ProviderTelephone1 : $('#ProviderTelephone1').val(),
         ProviderTelephone2 : $('#ProviderTelephone2').val(),
   };

   //Ajax post default option
   ajaxItem(e,providerData,$(e.target).attr('href'));

});



Echo.private('App.User.admin').listen('.ProductProviderCreatedEvent',function(e){
    //add new provider to the list and update item count notice.
    updateItemList(e.providerCreated.updateRoute,e.providerCreated,templateProvider);
    updateItemCount(e.count);
    Notyf.success(e.message);
    // if new is set in the URL return back to the previous URL
    if(params.get('action') == 'new'){
        window.location.href = document.referrer;
    }
});
