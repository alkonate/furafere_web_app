//product template
var templateProduct = '<div class="card m-4 p-0 shadow rounded border border-info" style="width: 250px">'+
                            '<div class="card-body overflow-hidden">'+
                                        '<div class=" btn mr-1 p-0 dashboard-item shadow rounded">'+
                                            '<input type="checkbox" class="btn btn-light option-input cursor checkbox checkbox-2x" id=":id">'+
                                        '</div>'+
                                        '<a href=":deleteRoute" onclick="grabItem(event);" data-toggle="modal" data-target="#modalDelete" class="dashboard-item btn btn-light p-1 shadow rounded">'+
                                            '<i class="fas fa-window-close fa-2x fa-fw text-danger"></i>'+
                                        '</a>'+
                                        '<a href=":updateRoute" onclick="getProduct(event);" data-toggle="modal" data-target="#modalUpdateProduct" class="dashboard-item btn btn-light p-1 shadow rounded">'+
                                            '<i class="fas fa-edit fa-2x"></i>'+
                                        '</a>'+
                                        '<div class="row overflow-hidden justify-content-center">'+
                                            '<a href=":viewRoute">'+
                                                '<img class="product-placeholder-anim" src=":thumbnail" width="200" height="200">'+
                                            '</a>'+
                                        '</div>'+
                            '</div>'+
                            '<a href=":infoRoute" onclick="viewProductInfo(event);" type="button" data-toggle="modal" data-target="#productView" class="dashboard-item btn btn-light">'+
                                '<div class="card-footer bg-primary text-white">'+
                                    '<div class="row justify-content-center-between flex-nowrap card-footer-max-height shadow rounded">'+
                                        '<div class="col-11 flex-grow-0 bg-success ">'+
                                            '<div class="row">'+
                                                '<div class="col-12">'+
                                                    ':name'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="row justify-content-start">'+
                                                '<div class="col-12">'+
                                                    ':description'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-1 bg-secondary">:stock</div>'+
                                    '</div>'+
                                '</div>'+
                            '</a>'+
                        '</div>';

//event on add provider send ajax request
$('#addProduct').on('click',function(e) {
    e.preventDefault();
   removeAllAlertMessage();
   setMultipleItemActionFlag(false);

   //spinner toggle
   $(e.target).toggle().after("<i class=\"fas fa-spinner fa-lg fa-fw\"></i>");


   //INPUT DATA SEND BY AJAX
   formData = new FormData($('#newProductForm')[0]);
   formData.append('type_id',$('meta[name="type_id"]').attr('content'));

$.ajax({
    headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
    type : "POST",
    url : $(e.target).attr('href'),
    data : formData,
    contentType : false,
    processData : false,
}).done(function(result){
    onDoneDefault(result);
}).fail(function(hrx,status){
    onFailDefault(hrx,status);
}).always(function(){
    alwaysDefault(e);
 });

});



Echo.private('App.User.admin').listen('.ProductCreatedEvent',function(e){
    //add new product to the list and update item count notice.
    updateItemList(e.productCreated.updateRoute,e.productCreated,templateProduct);
    updateItemCount(e.count);
    Notyf.success(e.message);
});
