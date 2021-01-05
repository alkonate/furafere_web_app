//constant autonumerical fcfa
const autonumericalOptionsFcfa = {
    currencySymbol : ' Franc CFA',
    currencySymbolPlacement : 's',
    decimalCharacter : '.',
    digitGroupSeparator : ' ',
    decimalPlaces : 2,
};
//error modal message template
var errorMessage = '<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
                '   <button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                        '<span aria-hidden="true">&times;</span>'+
                    '</button>'+
                    '<strong>:message</strong>'+
                '</div>';

//add new custom prototype helper method on String
//format string
String.prototype.format = function(data){
    return Object.keys(data).reduce((template,placeholder)=>{
        if(data[placeholder] == null){
            data[placeholder] = '';
        }
        return template.replace(':'+placeholder,data[placeholder])},this);
};

//add new custom prototype helper method on String
//capitalize first character of a string
String.prototype.ucfirst = function(){
    return this.charAt(0).toUpperCase() + this.slice(1);
};

/**
 * update or add an item in the item list.
 * @param string href
 * @param object item
 * @param sting template
 * @return [type]
 */
function updateItemList(href,item,template){
    let pointer = $('a[href="'+ href +'"]').parent().parent();
    if(pointer.length){
        if(pointer.after(template.format(item)) && pointer.remove()){
            return true;
        }else{
            return false;
        }
    }else{
        if( $('.btn-new-item').after(template.format(item))){
            return true;
        }else{
            return false;
        }
    }

}

/**
 * update item count display into the browser.
 * @param mixed count
 * @return [type]
 */
function updateItemCount(count){
    $('.item-count').text(count);
}

/**
 *display error message in the model
 *arg messages object receive from ajax request
 * @param mixed messages
 * @return [type]
 */
function displayAllErrorMessages(messages) {
    Object.keys(messages).forEach((attr,index)=>{
        $('#'+attr).addClass('is-invalid');
        $(errorMessage.format({message : messages[attr]})).insertAfter('#'+attr);
    });
}

/**
 * remove all error message in the modal form
 * before submitting modal form
 * @param void
 * @return void
 */
function removeAllAlertMessage(){
    $('.alert').remove();
   $('.is-invalid').removeClass('is-invalid');
}

//on success close the modal form
function closeModalForm(modalId){
    $('input').val(null)
    $('.close').click();
}

//global variable pointing to the current item href
window.href = '';
/**
 * grab the item href
 * @param mixed event
 * @return [type]
 */
function grabItem(event){
    window.href = $(event.currentTarget).attr('href');
    removeAllAlertMessage();
    setMultipleItemActionFlag(false);
}
//
//reset modal and auto focus on password field
$('.modal').on('shown.bs.modal',function() {
    //set to null all input and text area
    $('input').val('');
    $('textarea').val('');
    //if there is an image in the modal set it to the default image
    if($('#imagePreview').length > 0 ){
        document.getElementById("imagePreview").src = '/img/thumbnail-unknown.jpeg';
    }

    //if there is password field in the modal focus on it
    if($('#deleteItemPasswordInput').length > 0){
        $('#deleteItemPasswordInput').focus();
     }
    removeAllAlertMessage();
});


//delete multiple item in once flag to change deleting mode
$('#deleteMultipleBtn').on('click',function(e){
    e.preventDefault();
    setMultipleItemActionFlag(true);
});

//start by a helper function grabItem() to grab the current item
//update the href
//grabItem(e);

$('#deleteBtn').on('click',function (e) {
    e.preventDefault();
    $('#deleteBtn').toggle().after("<i class=\"fas fa-spinner fa-lg fa-fw\"></i>");
    let password = $('#deleteItemPasswordInput').val();

    if(window.multipleItemDeleteFlag){
        var id = [];
        $('input[type=checkbox]:checked').each(function(){
        id.push($(this).attr('id'));
        });

        var url = $('#deleteMultipleBtn').attr('href');

        var data = {
            id : id,
            deleteItemPasswordInput : password,
        };

    }else{
        var url = window.href;
        var id = url.split('/');
            id = [
                id[id.length-1]
            ];

        var data = {
            id : id,
            deleteItemPasswordInput : password,
        };
    }

    //ajax post item data
    ajaxItem(e,data,url);

});

//global variable setting the deleting mode to on or many
window.multipleItemDeleteFlag = false;

/**
 * set the global variable multiple item deleting.
 * @param mixed flag
 * @return boolean
 */
function setMultipleItemActionFlag(flag){
    window.multipleItemDeleteFlag = flag;
}


/**
 *fill modal form with the data get from the server.
 *the key(s) of json object return from the server should
 *be the same as the id(s) of the modal fields.
 * @param object data
 * @return [type]
 */
function fillModalWithItemData(data) {
    Object.keys(data).forEach((id) => {
        field = $('#'+id);
        if(field.is('input') || field.is('textarea')){
            field = $('#'+id).val(data[id]);
        }else if(field.is('img')){
            document.getElementById(id).src = data[id];
        }else{
            field = $('#'+id).text(data[id]);
        }
    });
}

/**
 * fill the modal item info with values.
 * @param mixed $fieldName='fieldNames'
 * @param mixed $fieldValue='fieldValues'
 * @param mixed data
 *
 * @return [type]
 */
function fillValueFieldWindow($fieldName='fieldNames',$fieldValue='fieldValues',data){

    let fieldId = [];
     $('#'+$fieldName).children().each(function(){
        fieldId.push($(this).attr('id'));
        });

    fieldId.forEach(function (field){
        $('#'+$fieldValue).append('<p class="card-text ">' + data[field] + '</p>')
    });
}

/**
 * send ajax request to create,update,delete,get item from the server.
 * @param mixed event
 * @param mixed data=[]
 * @param mixed url=href
 * @param mixed method="POST"
 * @param mixed onDoneCallback=onDoneDefault
 * @param mixed onFailCallback=onFailDefault
 * @param mixed alwaysCallback=alwaysDefault
 *
 * @return [type]
 */
function ajaxItem(event,data={},url=href,method="POST",onDoneCallback=onDoneDefault,onFailCallback=onFailDefault,alwaysCallback=alwaysDefault){

    let headers = (method == "POST") ? {
        "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content'),
        } : {};

    $.ajax({
 headers : headers,
  url : url,
  method : method,
  contentType : "application/json",
  data : JSON.stringify(data),

 }).done(function(result){
    onDoneCallback(result);
 }).fail(function(xhr,status){
    onFailCallback(xhr,status);
 }).always(function(){
    alwaysCallback(event);
 });
}

/**
 * on ajax request success or fail default action to execute.
 * @return [type]
 */
function alwaysDefault(event){
    //spinner toggle
    $(event.target).toggle().next().remove();
    if($('#deleteItemPasswordInput').length > 0){
       $('#deleteItemPasswordInput').val(null);
    }
}

/**
 * on ajax request fail default action to execute.
 * @param mixed xhr
 * @param mixed status
 *
 * @return [type]
 */
function onFailDefault(xhr,status){
    var errorMessage = status +" : " + xhr.statusText;
    Notyf.error(errorMessage);
}

/**
 * on ajax request success default action to execute.
 * @param mixed result
 *
 * @return [type]
 */
function onDoneDefault(result){
    console.log(result);
           if(result.success){
               $('.close').click();
           }

           if(result.error){
               Notyf.error(result.messages);
           }
           if(result.invalid){
               displayAllErrorMessages(result.messages);
           }

    }


/**
 * toggle the spinner inside the item info modal.
 * @param mixed $fieldName='fieldName'
 * @param mixed $fieldValue='fieldValue'
 *
 * @return [type]
 */
function toggleSpinnerInsideValueFieldsWindow($fieldName='fieldNames',$fieldValue='fieldValues'){

    if (!$('#'+$fieldValue).children('p.spinner').length) {

        $('#'+$fieldValue).children().remove();

        fieldLength = $('#'+$fieldName).children('p.card-text').length;

        for(i=0;i < fieldLength;i++){
            $('#'+$fieldValue).prepend('<p class="card-text spinner"><i class="fas fa-spinner fa-fw"></i></p>');
        }
    }else{
        $('#'+$fieldValue).children().remove();
    }
}

/**
 * toggle the spinner inside the graph field in the modal
 * and add a canvas for chart.
 * @param string graphField='spinnerloadingGraph'
 * @param string canvas='ItemDoughnut'
 * @return [type]
 */
function toggleSpinnerInsideGraphWindow(graphField='spinnerloadingGraph',canvas='ItemDoughnut'){
    if ($('#'+graphField).children('i').length) {

        $('#'+graphField).children().remove();
        $('#'+graphField).prepend('<canvas id="'+canvas+'"></canvas>');

    }
    else{
        $('#'+graphField).children().remove();
        $('#'+graphField).prepend('<i class="fas fa-spinner fa-3x fa-fw"></i>');
    }
}


const backgroundColor = [
    'rgba(255,99,132,0.2)',
    'rgba(54,162,135,0.2)',
    'rgba(255,206,86,0.2)',
    'rgba(0,100,0,0.2)',
];
const hoverBackgroundColor = [
    'rgba(255,99,132,0.6)',
    'rgba(54,162,135,0.6)',
    'rgba(255,206,86,0.6)',
    'rgba(0,100,0,0.6)',
];
const borderColor = [
    'rgba(255,99,132,1)',
    'rgba(54,162,135,1)',
    'rgba(255,206,86,1)',
    'rgba(0,100,0,1)',
];

/**
 * Create chart for item data.
 * @param mixed canvas='ItemDoughnut'
 * @param mixed type='doughnut'
 * @param mixed backgroundColor
 * @param mixed hoverBackgroundColor
 * @param mixed borderColor
 * @param mixed title
 * @param mixed labels
 * @param mixed data
 *
 * @return [type]
 */
function ItemChart(canvas='ItemDoughnut',type='doughnut',backgroundColor,hoverBackgroundColor,borderColor,title,labels,data){

    let chart = new Chart($('#'+canvas),{
        type : type,
        data : {
            labels : labels,
            datasets : [{
                data : data,
                backgroundColor : backgroundColor,
                hoverBackgroundColor : hoverBackgroundColor,
                borderColor : borderColor,
                borderWidth : 1,
            }],
        },

        options : {
           title : {
               display : true,
               text : title,
           },

           legend : {
                display : true,
                position : 'left',
                labels : {
                    fontSize : 14,
                }
           },

        //    tooltips : {
        //        callbacks : {
        //            label : function(tooltipItem,data){
        //                 return data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
        //            }
        //        }
        //    },
        }
    });

}

