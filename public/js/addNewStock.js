var templateStock = '<div class="card m-4 p-0  border border-info shadow rounded">'+
                            '<div class="card-body overflow-hidden">'+
                                '<div class=" btn mr-4 p-0 dashboard-item shadow rounded">'+
                                    '<input type="checkbox" class="btn btn-light option-input cursor checkbox checkbox-2x" id=":id">'+
                                '</div>'+
                                '<a href=":updateRoute" onclick="getStock(event);" data-toggle="modal" data-target="#modalAddStock" class="dashboard-item btn btn-light p-1 shadow rounded">'+
                                    '<i class="fas fa-edit fa-2x"></i>'+
                                '</a>'+
                                '<a href=":deleteRoute" onclick="grabItem(event);" data-toggle="modal" data-target="#modalDelete" class="dashboard-item btn btn-light p-1 shadow rounded">'+
                                        '<i class="fas fa-window-close fa-2x fa-fw text-danger"></i>'+
                                '</a>'+
                                '<a href=":lockRoute" onclick="toggleStockVault(event);" class="dashboard-item btn btn-light p-1 shadow rounded">'+
                                       '<i class="fas fa-unlock fa-2x fa-fw text-secondary"></i>'+
                                '</a>'+
                            '</div>'+
                            '<a href=":viewRoute" onclick="viewStockInfo(event);" type="button" data-toggle="modal" data-target="#modalStockView" class="dashboard-item btn btn-light">'+

                                    '<div class="card-footer bg-primary text-left">'+

                                        '<div class="row justify-content-center-between flex-nowrap  card-footer-max-height shadow rounded">'+
                                            '<div class="col-11 flex-grow-0 bg-light text-light" style="font-size: 18px;">'+
                                                '<div class="row bg-light text-secondary justify-content-center">'+
                                                    '<span>:createdAtFormated</span>'+
                                                '</div>'+
                                                '<div class="row bg-secondary justify-content-center">'+
                                                    '<span>:stockBuyingPrices</span>'+
                                                '</div>'+
                                                '<div class="row bg-secondary justify-content-center">'+
                                                    '<span>:stockBuyingPriceUnit</span>/unit'+
                                                '</div>'+
                                                '<div class="row bg-success justify-content-center">'+
                                                    '<i class="fas fa-shopping-cart fa-sm fa-fw"></i>'+
                                                    '<span>:stockSellingPriceUnit</span>/unit'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="col-1 bg-secondary text-white">:stockQuantity</div>'+
                                        '</div>'+
                                    '</div>'+
                            '</a>'+
                        '</div>';

var dateFieldTemplate = '<div class="row fieldPast :field_date_time_count">'+
                            '<input type="text" id=":itemId" name="itemId[]" class="form-control" disabled hidden>'+
                            '<div class="col-6">'+
                                '<div class="form-group">'+
                                    '<label for=":expireDate">' + lang.addNewStock['Stock expiration date'] + '</label>'+
                                    '<input type="date"'+
                                    'class="form-control" name="expireDate[]" id=":expireDate" aria-describedby="expireDateHelper" placeholder="' + lang.addNewStock['MM/DD/YEAR'] + '">'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-4">'+
                                '<div class="form-group">'+
                                    '<label for=":itemCount">' + lang.addNewStock['Stock item count'] + '</label>'+
                                    '<input type="number"'+
                                    'class="form-control"  onchange="itemCountUpdated();" name="itemCount[]" id=":itemCount" aria-describedby="itemCountHelper" placeholder="0">'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-2">'+
                                '<label class="text-white">del</label>'+
                                '<div class="btn btn-danger" onclick = "deleteDateItemQuantity(:field_date_time_count);"><i class="fas fa-window-close fa-sm fa-fw"></div>'+
                            '</div>'+
                        '</div>';

// provider selection option template
var providerOptionTemplate = '<option value=":providerId" :disabled :selected>:providerName</option>';
// inputs jquery object
var item;
var expireDate;
var barcode = $("#barcode");
var providerId = $("#providerId");
var buyingPrices = $("#buyingPrice");
var buyingPriceUnit = $("#buyingPriceUnit");
var sellingPriceUnit = $("#sellingPriceUnit");
var diff = $("#diff");

// date item quantity field count append with the id attribute name.
//this value will be incremented
window.field_date_time_count = 0;

//global variable to set deleting mode to stock item delete
window.stockItemDeleteFlag = false;

//globla variable define the id of stock item to be deleted
window.stockItemIdTodelete = null;

//config accounting currency for converting in raw format
accounting.settings.currency.symbol = "Franc CFA";
accounting.settings.currency.format = "%v %s";
accounting.settings.currency.decimal = ".";
accounting.settings.currency.thousand = " ";
accounting.settings.currency.precision = 2;

//config numeric currency for better user experience
//mask for buying Price currency input
 new AutoNumeric('#buyingPrice',autonumericalOptionsFcfa);
 //mask for buying Price currency input
 new AutoNumeric('#buyingPriceUnit',autonumericalOptionsFcfa);
//mask for selling Price Unit currency input
new AutoNumeric('#sellingPriceUnit',autonumericalOptionsFcfa);


// show the add new stock button and hide the update stock btn
$('#newStockFormBtn').on('click',function () {
    $('#addStock').removeAttr('hidden');
    $('#updateStock').attr('hidden',true);
});

// on add new stock modal show up
// get the provider list
$("#modalAddStock").on('show.bs.modal',function (e) {
    // get providers
    getProviders();
});

// on modal add new stock hide reset every thing
$("#modalAddStock").on('hide.bs.modal',function (e) {
   // field copy and paste in the add new stock modal
    $(".row .fieldPast").remove();
    // every field set to empty
    $("input[name|='itemCount[]']").val('');
    $("input[name|='expireDate[]']").val('');
    barcode.val('');
    providerId.val('');
    buyingPrices.val('');
    buyingPriceUnit.val('');
    sellingPriceUnit.val('');
    diff.val('');
    $('#itemCount0').trigger('change');
    window.field_date_time_count = 0;
});

//event on add stock send ajax request
$('#addStock').on('click',function(e) {

    e.preventDefault();

   removeAllAlertMessage();

   //spinner toggle
   $('#addStock').toggle().after("<i class=\"fas fa-spinner fa-lg fa-fw\"></i>");

   stockData = {
    productId : $('meta[name="productId"]').attr('content'),
    barcode : barcode.val(),
    providerId : providerId.val(),
    itemCount : $("input[name|='itemCount[]']").getObjectDOMValues(),
    expireDate : $("input[name|='expireDate[]']").getObjectDOMValues(),
    buyingPriceUnit : ($('#buyingPriceUnit').val()) ? accounting.parse($('#buyingPriceUnit').val()) : $('#buyingPriceUnit').val(),
    sellingPriceUnit : ($('#sellingPriceUnit').val()) ? accounting.parse($('#sellingPriceUnit').val()) : $('#sellingPriceUnit').val(),
    };

   ajaxItem(e,stockData,$(e.target).attr('href'),undefined,function(result){onDone(result)});

});

/**
 * get the list of provider and fill the select provider field
 * @return void
 */
function getProviders(){
    if($('#providerId').children().length == 0){
        $.ajax({
            headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
            type : "GET",
            url : $('meta[name="getProviderURL"]').attr('content'),
            contentType : "application/json",
        }).done(function(result){
            // build the select html val's options and push it inside
            // the select DOM val
            let selectProviderHtml = providerOptionTemplate.format({
                "providerId" : "",
                "providerName" : lang["addNewStock"]["select provider"],
                "disabled" : "disabled",
                "selected" : "selected"
                });
               result.providers.forEach(provider => {
                    selectProviderHtml += providerOptionTemplate.format({
                        "providerId" : provider.id,
                        "providerName" : provider.name,
                    });
               });
               $('#providerId').html(selectProviderHtml);

        }).fail(function(hrx,status){
            onFailDefault(hrx,status);
        });

    }
}

/**
 * On done ajax item request
 * @param json result
 *
 * @return void
 */
function onDone(result){
    if(result.invalid==true){
        Object.keys(result.messages).forEach(message => {
            messageSplited = message.split('.');
            if(messageSplited[0] !== message){
                result.messages[messageSplited[1]] = result.messages[message];
                delete (result.messages[message]);
            }
        });
    }

    onDoneDefault(result);
}

// buyingPrices on change update the buying price unit
buyingPrices.on('change',function (e) {
    updateBuyingPriceUnit();
    updateDifference();
 });

 // buyingPriceUnit on change update the buying prices
buyingPriceUnit.on('change',function (e) {
    updateBuyingPrices();
    updateDifference();
 });

 // sellingPriceUnit on key press update the color inside the input
 sellingPriceUnit.on('keyup',function (e) {
    updateDifference();
 });

// update the difference price between buying price unit and selling
// price unit
function updateDifference(){
    diffValue = accounting.parse(sellingPriceUnit.val()) - accounting.parse(buyingPriceUnit.val());
    diff.val(accounting.formatMoney(diffValue));
    if(diffValue > 0){
       if(!diff.hasClass('bg-success')){
        diff.addClass('bg-success');
        diff.removeClass('bg-danger');
       }

    }else{
        if(!diff.hasClass('bg-danger')){
            diff.addClass('bg-danger');
            diff.removeClass('bg-success');
           }
    }
}

 // update the buying price unit when item number or buying prices change
function updateBuyingPriceUnit(){
    buyingPricesValue = accounting.parse(buyingPrices.val());
    buyingPriceUnit.val(accounting.formatMoney(buyingPricesValue / $("input[name|='itemCount[]']").getArrayDOMValues().convertArrayStrToArrayInteger().sumIntArrayValues()));
}

 // update the buying prices when item number or buying price unit change
 function updateBuyingPrices(){
     buyingPriceUnitValue = accounting.parse(buyingPriceUnit.val());
     buyingPrices.val(accounting.formatMoney(buyingPriceUnitValue * $("input[name|='itemCount[]']").getArrayDOMValues().convertArrayStrToArrayInteger().sumIntArrayValues()));
 }

 function itemCountUpdated() {
            let itemCount = $("input[name|='itemCount[]']").getArrayDOMValues().convertArrayStrToArrayInteger().sumIntArrayValues();
             if(itemCount > 0){
                  buyingPrices.attr('disabled',false);
                  buyingPriceUnit.attr('disabled',false);
                  sellingPriceUnit.attr('disabled',false);
                  updateBuyingPrices();
                  updateDifference();
             }else{
              buyingPrices.attr('disabled',true);
              buyingPriceUnit.attr('disabled',true);
              sellingPriceUnit.attr('disabled',true);
             }

    }

/**
 * add new date and item quantity field to the add new stock modal in the view.
 * @return void
 */
function addNewDateItemQuantity(){

    window.field_date_time_count++;
    newField = dateFieldTemplate.format({
        "field_date_time_count" :  window.field_date_time_count,
        "itemId" : 'itemId' + window.field_date_time_count,
        "itemCount" : 'itemCount' + window.field_date_time_count,
        "expireDate" : 'expireDate' + window.field_date_time_count,
    });

    $('.copyAfter').after(newField);

}

/**
 * delete date field and item quantity field in the add new stock modal in the view.
 * @param event e
 *
 * @return void
 */
function deleteDateItemQuantity(field_date_time_id){
    if($('#itemId'+field_date_time_id).val()){
        window.stockItemDeleteFlag = true;
        window.stockItemIdTodelete = $('#itemId'+field_date_time_id).val();
        $('#modalAddStock').modal('hide');
        $('#modalDelete').modal('show');

    }else{
        console.log('smouth del');
        $('.row .' + field_date_time_id).remove();
        $('#itemCount0').trigger('change');
    }

}

/**
 * grab from a set of element an array of values.
 * @return array
 */
jQuery.prototype.getArrayDOMValues = function (){
    val= [];
    this.each(function(index,value) {
        val.push($(this).val());
    })
    return val;
}

/**
 * grab from a set of element an object of values.
 * @return object
 */
jQuery.prototype.getObjectDOMValues = function (){
    val= {};
    this.each(function(index,value) {
        val[$(this).attr('id')] = $(this).val();
    })
    return val;
}

/**
 * convert array of string to array of integer.
 * @return array
 */
Array.prototype.convertArrayStrToArrayInteger = function (){
    intArray=[];
    this.forEach(val => {
        if(val.length <= 0){
            intArray.push(0);
        }else{
            intArray.push(parseInt(val));
        }
    });

    return intArray;
}

/**
 * calculate the sum of all integer value inside the array.
 * @param array intArray
 *
 * @return integer
 */
Array.prototype.sumIntArrayValues = function (){
    return this.reduce(function(acc,currentVal){
            return acc + currentVal;
            });
}




/**
 * Delete stock item form the database.
 * @param object itemId
 *
 * @return [type]
 */
function deleteItemFromDB(itemId){

}

//listen on admin channel
Echo.private('App.User.admin').listen('.StockCreatedEvent',(e)=>{
    //add new provider to the list and update item count notice.
    updateItemList(e.stockCreated.addRoute,e.stockCreated,templateStock);
    updateItemCount(e.count);
    Notyf.success(e.message);
});
