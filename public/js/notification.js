$(document).ready(updateNotifcationBell());

//trigger new notification
Echo.private('App.User.' + laravel.user_id).notification(notification=>{

    let number = parseInt ($('.notification-number').text());
    $('.notification-number').text(number+1);

    // !!!!!YOU CAN REFACTOR THIS PART BY USING THE format String METHOD helper!!!!!!
  let notif_item =  '<a href="#" class="content bg-primary">'+
                        '<div class="notification-item row">'+
                            '<img src="' + notification.product_thumbnail +'" alt="" class="mr-2">'+
                            '<h4 class="item-title">' + notification.product_name + '</h4>'+
                            '<p class="item-info">' + notification.message + '</p>'+
                        '</div>'+
                    '</a>';

    //Dropdown close update notif
    if(!$('.notificationContainer').hasClass('show')){
        updateNotifcationBell();
    }else{
        deleteAllNotificationsOfUser();
    }
    //remove empty notif placeholder
    $('.no-notification').remove();
    //add new notif
    $('.notifications-wrapper').prepend(notif_item);
});

//update the bell icon and count
function updateNotifcationBell(){
    var bell = $('.fas.fa-bell');
    var notificationNumber = $('.notification-number');
    var number = notificationNumber.text();

    //there is no unread notification
    if( number == 0){
        notificationNumber.removeClass();
        notificationNumber.addClass("notification-number notification-number-stop-bouncing");
        bell.removeClass('bell');
    }else{//new notification not read yet
        notificationNumber.removeClass();
        notificationNumber.addClass("notification-number notification-number-start-bouncing");
        bell.addClass('bell');
    }

    return;

}

function deleteAllNotificationsOfUser() {

    let number = $('.notification-number').text();

    //if there are notification delete them
    if(number != 0){
            $.ajax({
            // Only with POST method
            headers:{
                "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')
            },
            url:"/read/notifications",
            method:"GET",
            contentType:"application/json",
            }).done(function(result){
                result = JSON.parse(result);
                $('.notification-number').text(result.number);
                updateNotifcationBell();
            }).fail(function(xhr,status,error){
                var errorMessage = "Unable to connect to the database : " + xhr.statusText;
                alert(errorMessage);
        });
    }

}


