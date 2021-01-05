// Echo.channel('public-channel').listen('newProductAddedEvent',e=>{
//     console.log(e);
// });


Echo.private('App.User.' + laravel.user_id).notification(notification=>{
    console.log(notification);
});


// Echo.join('admin-channel')
//     .here((users)=>{
//         //
//     })
//     .joining((user)=>{
//         console.log(user.name);
//     })
//     .leaving((user)=>{
//         console.log(user.name);
//     });

// Echo.private('App.User.admin').notification((notification)=>{
//     console.log(notification);
// });

