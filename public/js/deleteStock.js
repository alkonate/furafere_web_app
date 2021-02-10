//deleting event fire on clicking deleteBtn in the helper.js
//...

//listen on admin channel
Echo.private('App.User.admin').listen('.StockDeletedEvent',(e)=>{
    $('a[href="'+ e.stockDeleted +'"]').parent().parent().remove();
    updateItemCount(e.count);
    Notyf.success(e.message);
});
