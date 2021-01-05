//deleting event fire on clicking deleteBtn in the helper.js
//...

//listen on admin channel
Echo.private('App.User.admin').listen('.ProductCategoryDeletedEvent',(e)=>{
    $('a[href="'+ e.categoryDeleted +'"]').parent().parent().remove();
    updateItemCount(e.count);
    Notyf.success(e.message);
});
