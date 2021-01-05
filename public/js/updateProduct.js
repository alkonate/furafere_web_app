function getProduct(e){
    //start by a helper function to grab the current product
    //update the href
    grabItem(e);
    removeAllAlertMessage();

    $('#UpdateProductForm').toggle().after('<i class="fas fa-spinner fa-lg fa-fw"></i>');

    $.ajax({

         url : '/get/product/'+ href.split('/').pop(),
         method : "GET",
         contentType : "application/json",

        }).done(function(result){
            console.log(result);
            if(result.success){
                fillModalWithItemData(result.inputs);
            }else if(!result.success){
                Notyf.error(result.messages);
            }

        }).fail(function(xhr,status){
            var errorMessage = status +" : " + xhr.statusText;
            Notyf.error(errorMessage);
        }).always(function(){
            $('#UpdateProductForm').toggle().next().remove();
        });

}


//on submit event
$('#updateProduct').on('click',function(e) {
    e.preventDefault();
    removeAllAlertMessage();
   //spinner toggle
   $(e.target).toggle().after("<i class=\"fas fa-spinner fa-lg fa-fw\"></i>");

    //INPUT DATA SEND BY AJAX
    formData = new FormData($('#UpdateProductForm')[0]);
    formData.append('type_id',$('meta[name="type_id"]').attr('content'));

    $.ajax({
    headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
    type : "POST",
    url : href,
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


Echo.private('App.User.admin').listen('.ProductUpdatedEvent',function(e){
    //update list view helpers function
    updateItemList(e.productUpdated.updateRoute,e.productUpdated,templateProduct);
    Notyf.success(e.message);
});
