
function getCategory(e){
    //start by a helper function to grab the current category
    //update the href
    grabItem(e);
    removeAllAlertMessage();

    $('#UpdateCategoryForm').toggle().after('<i class="fas fa-spinner fa-lg fa-fw"></i>');

    $.ajax({

         url : '/get/product/category/'+ href.split('/').pop(),
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
            $('#UpdateCategoryForm').toggle().next().remove();
        });

}


//on submit event
$('#updateType').on('click',function(e) {
    e.preventDefault();
    removeAllAlertMessage();
   //spinner toggle
   $(e.target).toggle().after("<i class=\"fas fa-spinner fa-lg fa-fw\"></i>");

   //get user inputs
   var categoryData = {
    UpdateCategory : ($('#UpdateCategory').val()).ucfirst(),
   };

   ajaxItem(e,categoryData,href);

});

Echo.private('App.User.admin').listen('.ProductCategoryUpdatedEvent',function(e){
    //update list view helpers function
    updateItemList(e.categoryUpdated.updateRoute,e.categoryUpdated,templateCategory);
    Notyf.success(e.message);
});
