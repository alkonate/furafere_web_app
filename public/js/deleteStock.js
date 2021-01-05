var href = '';
function grabStockToDelete(event){
     href = $(event.currentTarget).attr('href');
    removeAllAlertMessage();
}

    $('#modelDelete').on('shown.bs.modal',function() {
        $('#deleteStockPasswordInput').focus();
    });


$('#deleteStockBtn').on('click',function (e) {
    $('#deleteStockBtn').toggle().after("<i class=\"fas fa-spinner fa-lg fa-fw\"></i>");
    let password = $('#deleteStockPasswordInput').val();

    $.ajax({
        headers : {
            "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content'),
            },
        url : href,
        method : "POST",
        contentType : "application/json",
        data : JSON.stringify({
            deleteStockPasswordInput : password
        }),
    }).done(function(result){

        if(result.validation){
            console.log(result);
        }
        else if(result.error){
            displayEAllrrorMessages(result.messages);
        }else{
            $('.close').click();
        }

    }).fail(function(xhr,status){
        var errorMessage = status +" : " + xhr.statusText;
       Notyf.error(errorMessage);
    }).always(function() {
        $('#deleteStockBtn').toggle().next().remove();
        $('#deleteStockPasswordInput').val(null);
    });
});


//listen on admin channel
Echo.private('App.User.admin').listen('ProductStockDeletedEvent',(e)=>{
    $('a[href="'+ e.stockDeleted +'"]').parent().parent().remove();

    Notyf.success(e.message);
});
