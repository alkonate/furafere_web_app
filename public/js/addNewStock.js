var newstockTemplate = '<div class="card m-4 p-0 shadow rounded">'+
                            '<div class="card-body overflow-hidden">'+
                                '<a href="" class="dashboard-item  btn btn-light P-0 shadow rounded">'+
                                    '<i class="fas fa-plus fa-2x text-primary" aria-hidden="true"></i>'+
                                '</a>'+
                                '<a href="" class="dashboard-item btn btn-light shadow rounded">'+
                                    '<i class="fas fa-window-close fa-2x fa-fw text-danger"></i>'+
                                '</a>'+
                                '<a href="" class="dashboard-item btn btn-light shadow rounded">'+
                                    '<i class="fas fa-unlock fa-2x fa-fw text-secondary"></i>'+
                                '</a>'+
                            '</div>'+
                            '<a href="" class="dashboard-item btn btn-light">'+
                                '<div class="card-footer bg-primary text-left text-white">'+
                                    '<div class="row justify-content-center-between flex-nowrap  card-footer-max-height shadow rounded">'+
                                        '<div class="col-11 flex-grow-0 bg-success ">'+
                                            '%s'+
                                        '</div>"'+
                                        '<div class="col-1 bg-secondary">1000</div>'+
                                    '</div>'+
                                '</div>'+
                            '</a>'+
                        '</div>';


//product name
var productName = $(location).attr('href').split('/')[4];

//config accounting currency for converting in raw format
accounting.settings.currency.symbol = "Franc CFA";
accounting.settings.currency.format = "%v %s";
accounting.settings.currency.decimal = ".";
accounting.settings.currency.thousand = " ";
accounting.settings.currency.precision = 2;

//config numerical currency for better user experience
//mask for buying Price currency input
 new AutoNumeric('#buyingPrice',autonumericalOptionsFcfa);
//mask for selling Price Unit currency input
new AutoNumeric('#sellingPriceUnit',autonumericalOptionsFcfa);




//event on add stock send ajax request
$('#addStock').on('click',function(e) {

    e.preventDefault();

   removeAllAlertMessage();

   //spinner toggle
   $('#addStock').toggle().after("<i class=\"fas fa-spinner fa-lg fa-fw\"></i>");

    let buyingPriceUnit = ($('#buyingPriceUnit').val()) ? accounting.parse($('#buyingPriceUnit').val()) : $('#buyingPriceUnit').val();
    let sellingPriceUnit = ($('#sellingPriceUnit').val()) ? accounting.parse($('#sellingPriceUnit').val()) : $('#sellingPriceUnit').val();

   $.ajax({
       headers : {
        "X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content'),
        },
        url : $('#addStock').attr('href'),
        method : "POST",
        contentType : "application/json",
        data : JSON.stringify({
            ProductName : productName,
            buyingPriceUnit : buyingPriceUnit,
            sellingPriceUnit : sellingPriceUnit,
        }),
   }).done(function(result){
    console.log(result);
        if(result.success){

            // closeNewStockForm();

        }else if(result.error){

            // displayEAllrrorMessages(result.messages);

        }

   }).fail(function(xhr,status){
        var errorMessage = status +" : " + xhr.statusText;
        alert(errorMessage);
   }).always(function(){

        //spinner toggle
        $('#addStock').toggle().next().remove();
   });
});

   var item = $("#itemCount");;
   var buyingPrices = $("#buyingPrice");
   var buyingPriceUnit = $("#buyingPriceUnit");

// itemCount on change update the buying prices
item.on('change',function (e) {
  let itemCount = item.val();
   if(itemCount > 0){
        buyingPrices.attr('disabled',false);

   }else{
    buyingPrices.attr('disabled',true);
   }

});

// buyingPrices on change update the buying price unit
buyingPrices.on('change',function (e) {
    buyingPricesValue = accounting.parse(buyingPrices.val());

    buyingPriceUnit.val(accounting.formatMoney(buyingPricesValue / item.val()));

 });

//listen on admin channel
Echo.private('App.User.admin').listen('ProductNewStockCreatedEvent',(e)=>{
    $('#newStockFormBtn').after(newstockTemplate.format(e.createdAtFormated));
});
