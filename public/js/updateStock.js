// stock information send with the update data
window.stock;

function getStock(e){
    //start by a helper function to grab the current product
    //update the href
    grabItem(e);
    removeAllAlertMessage();

    // hide the add new stock btn and show the update stock btn
    $('#updateStock').removeAttr('hidden');
    $('#addStock').attr('hidden',true);

    $('#newStockForm').toggle().after('<i class="fas fa-spinner fa-lg fa-fw"></i>');

    $.ajax({

         url : '/get/stock/'+ href.split('/').pop(),
         method : "GET",
         contentType : "application/json",

        }).done(function(result){
            // console.log(result);
            if(result.success){
                // fill providers select field options
                getProviders();
                // copy the items id before update
                window.stock.items = itemsIDArray(result.inputs.items);
                // window.stock.items = [{'id':45},{'id':'20'}];
                // fill the first item field
                fillModalWithItemData(result.inputs.items[0]);
                // fill the rest of item fields
                for (let $i = 1; $i < result.inputs.items.length; $i++) {
                    $('#addMoreItemField').click();
                    fillModalWithItemData(result.inputs.items[$i]);
                }
                // fill the modal input text and select field
                fillModalWithItemData(result.inputs);

                // tigger the update item event
                $('#itemCount0').trigger('change');

            }else if(!result.success){
                Notyf.error(result.messages);
            }

        }).fail(function(xhr,status){
            var errorMessage = status +" : " + xhr.statusText;
            Notyf.error(errorMessage);
        }).always(function(){
            $('#newStockForm').toggle().next().remove();
        });

}

//event on add stock send ajax request
$('#updateStock').on('click',function(e) {

    e.preventDefault();

   removeAllAlertMessage();

   //spinner toggle
   $('#updateStock').toggle().after("<i class=\"fas fa-spinner fa-lg fa-fw\"></i>");

   stockData = {
        stock : {
            barcode : $('#barcode').val(),
            providerId : $('#providerId').val(),
            buyingPriceUnit : ($('#buyingPriceUnit').val()) ? accounting.parse($('#buyingPriceUnit').val()) : $('#buyingPriceUnit').val(),
            sellingPriceUnit : ($('#sellingPriceUnit').val()) ? accounting.parse($('#sellingPriceUnit').val()) : $('#sellingPriceUnit').val(),
            items : {
                original : {
                    id : window.stock.items,
                },
                update : {
                    id : $("input[name|='itemId[]']").getObjectDOMValues(),
                    count : $("input[name|='itemCount[]']").getObjectDOMValues(),
                    expireDate : $("input[name|='expireDate[]']").getObjectDOMValues(),
                },
            }
        }
    };

   ajaxItem(e,stockData,window.href,undefined,function(result){
        var matched;

        if(result.invalid){
            Object.keys(result.messages).forEach(key => {
                if(matched = key.match(/itemCount[0-9]+/g)){
                    result.messages[matched[0]] = result.messages[key];
                }
                if(matched = key.match(/expireDate[0-9]+/g)){
                    result.messages[matched[0]] = result.messages[key];
                }
            });
        }

        onDone(result);
    });

});

/**
 * Get an array of items ID
 * @param array items
 *
 * @return array
 */
function itemsIDArray(items){
    itemId = [];
    items.forEach(item => {
        itemId.push(item[Object.keys(item)[0]]);
    });

    return itemId;
}

Echo.private('App.User.admin').listen('.StockUpdatedEvent',function(e){
    //update list view helpers function
    updateItemList(e.stockUpdated.updateRoute,e.stockUpdated,templateStock);
    Notyf.success(e.message);
});
