//category template
var templateCategory = '<div class="card m-4 p-0 shadow rounded" style="min-width: 250px">'+
                            '<div class="card-body overflow-hidden">'+
                                    '<div class=" btn mr-1 p-0 dashboard-item shadow rounded">'+
                                        '<input type="checkbox" class="btn btn-light option-input cursor checkbox checkbox-2x" id=":id">'+
                                    '</div>'+
                                    '<a href=":deleteRoute" onclick="grabItem(event);" data-toggle="modal" data-target="#modalDelete" class="dashboard-item btn btn-light p-1 shadow rounded">'+
                                        '<i class="fas fa-window-close fa-2x fa-fw text-danger"></i>'+
                                    '</a>'+
                                    '<a href=":updateRoute" onclick="getCategory(event);" data-toggle="modal" data-target="#modalUpdateCategory" class="dashboard-item btn btn-light p-1 shadow rounded">'+
                                        '<i class="fas fa-edit fa-2x"></i>'+
                                    '</a>'+
                                    '<div class="row overflow-hidden justify-content-center">'+
                                        '<a href=":productRoute">'+
                                            '<img class="product-placeholder-anim" src=":mosaic" width="200" height="200" alt="">'+
                                        '</a>'+
                                    '</div>'+
                                '</div>'+
                                '<a href=":infoRoute" onclick="viewCategoryInfo(event);" type="button" data-toggle="modal" data-target="#categoryView" class="dashboard-item btn btn-light">'+
                                    '<div class="card-footer bg-primary text-white">'+

                                        '<div class="row justify-content-center-between flex-nowrap card-footer-max-height shadow rounded">'+
                                            '<div class="col-11 flex-grow-0 bg-success ">'+
                                                ':type'+
                                            '</div>'+
                                            '<div class="col-1 bg-secondary">:count</div>'+

                                        '</div>'+
                                    '</div>'+
                                '</a>'+
                            '</div>';


//event on add provider send ajax request
$('#addCategory').on('click',function(e) {
    e.preventDefault();
   removeAllAlertMessage();
   setMultipleItemActionFlag(false);

   //spinner toggle
   $(e.target).toggle().after("<i class=\"fas fa-spinner fa-lg fa-fw\"></i>");

   //get user inputs
   var categoryData = {
        ProductType : ($('#ProductType').val()).ucfirst(),
   };

   console.log($(e.target).attr('href'));
   //Ajax post default option
   ajaxItem(e,categoryData,$(e.target).attr('href'));

});



Echo.private('App.User.admin').listen('.ProductCategoryCreatedEvent',function(e){
    //add new provider to the list and update item count notice.
    updateItemList(e.categoryCreated.updateRoute,e.categoryCreated,templateCategory);
    updateItemCount(e.count);
    Notyf.success(e.message);
});
