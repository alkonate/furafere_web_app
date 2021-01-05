
function toggleStockVault(e){
    var vaultBtn = $(e.currentTarget);
    var href = vaultBtn.attr('href');

    vaultBtn.toggle().after("<i class=\"fas fa-spinner fa-lg fa-fw\"></i>");

    $.ajax({
        headers : {
            "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content'),
            },
        url : href,
        method : "POST",
        contentType : "application/json",

    }).done(function(result){
        console.log(result);

    }).fail(function(xhr,status){
        var errorMessage = status +" : " + xhr.statusText;
        Notyf.error(errorMessage);
    });
}

//listen on admin channel
Echo.private('App.User.admin').listen('ProductStockLockedEvent',(e)=>{

    let vault = $('a[href="'+ e.stockLocked +'"]');

    if(e.locked){
        vault.html('<i class="fas fa-lock fa-2x fa-fw text-danger"></i>');
    }else{
        vault.html('<i class="fas fa-unlock fa-2x fa-fw text-secondary"></i>');
    }

    vault.next('i').remove();
    vault.show();

    Notyf.success(e.message);
});
