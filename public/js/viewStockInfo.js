
function viewStockInfo(e){
    let href = e.currentTarget.href;

    toggleSpinnerInsidePriceColumWindow('SpinnerLoadingStockInfo');
    toggleSpinnerInsideStockInfoWindow('SpinnerLoadingStockInfo');

    $.ajax({
        headers : {
            //
        },
        url : href,
        ContentType : "application/json",
        method : "GET",


    }).done(function(result){
        toggleSpinnerInsidePriceColumWindow('SpinnerLoadingStockInfo');
        toggleSpinnerInsideStockInfoWindow('SpinnerLoadingStockInfo');
       if(result.error){
        alert(result.messages.id);
       }else{
        priceTable(result.stock.info);
        stockChart(result.stock);
       }

    }).fail(function(xhr,status){
        var errorMessage = status +" : " + xhr.statusText;
        alert(errorMessage);
    });
}


//toggle the spinner stock count, doughnut
function toggleSpinnerInsideStockInfoWindow($spinnerId){

    if ($('#'.$spinnerId).children('i').length) {

        $('#'.$spinnerId).children().remove();
        $('#'.$spinnerId).prepend('<canvas id="stockInfo"></canvas>');

    }
    else{
        $('#'.$spinnerId).children().remove();
        $('#'.$spinnerId).prepend('<i class="fas fa-spinner fa-3x fa-fw"></i>');
    }
}

//toggle the spinner stock prices table
function toggleSpinnerInsidePriceColumWindow(){
    if ($('#price-column').children('p.spinner').length) {

        $('#price-column').children().remove();

    }
    else{
        $('#price-column').children().remove();
        for(i=0;i < 7;i++){
            $('#price-column').prepend('<p class="card-text spinner"><i class="fas fa-spinner fa-fw"></i></p>');
        }
    }
}

function priceTable(info){

    let buyingPrice = info.item_prices.buying_price;
    let sellingPriceUni = info.item_prices.selling_price_uni;
    let sellingPriceCont = info.item_prices.selling_price_cont;
    let profitUni = (sellingPriceUni) ? (sellingPriceUni - buyingPrice) : null;
    let profitCont = (sellingPriceCont) ? ( sellingPriceCont - ( buyingPrice / info.content_count ) ) : null;
    let currentSell = ( info.item_sold_by_unit*sellingPriceUni ) + ( info.item_sold_by_content*sellingPriceCont );
    let currentProfit = currentSell - ( info.item_count*buyingPrice);

        $('#price-column').append('<p class="card-text ">' + info.item_count + '</p>');
        $('#price-column').append('<p class="card-text ">' + info.content_count + '/unit</p>');
        $('#price-column').append('<p class="card-text  buying_price">' + buyingPrice + '</p>');
        $('#price-column').append('<p class="card-text  buying_price_total">' + (buyingPrice*info.item_count) + '</p>');
        $('#price-column').append('<p class="card-text  selling_price_uni">' + sellingPriceUni + '</p>');
        $('#price-column').append('<p class="card-text  selling_price_cont">' + sellingPriceCont + '</p>');
        if(profitUni > 0){
            $('#price-column').append('<p class="card-text  profit_uni bg-success">' + profitUni  + '</p>');
        }else if(profitUni==undefined){
            $('#price-column').append('<p class="card-text  profit_uni">' + profitUni  + '</p>');
        }else{
            $('#price-column').append('<p class="card-text  profit_uni bg-danger">' + profitUni  + '</p>');
        }

        if(profitCont > 0){
            $('#price-column').append('<p class="card-text  profit_cont bg-success">' + profitCont  + '</p>');
        }else if(profitCont==undefined){
            $('#price-column').append('<p class="card-text  profit_cont">' + profitCont  + '</p>');

        }else{
            $('#price-column').append('<p class="card-text  profit_cont bg-danger">' + profitCont  + '</p>');
        }

        $('#price-column').append('<p class="card-text  current_sell">' + currentSell  + '</p>');

        if(currentProfit > 0){
            $('#price-column').append('<p class="card-text  current_profit bg-success">' + currentProfit  + '</p>');
        }else{
            $('#price-column').append('<p class="card-text  current_profit bg-danger">' + currentProfit  + '</p>');
        }

        //FORMAT CURRENCY FCFA
        new AutoNumeric('.buying_price',autonumericalOptionsFcfa);
        new AutoNumeric('.buying_price_total',autonumericalOptionsFcfa);

        if(info.item_prices.selling_price_uni) new AutoNumeric('.selling_price_uni',autonumericalOptionsFcfa);
        if(info.item_prices.selling_price_cont) new AutoNumeric('.selling_price_cont',autonumericalOptionsFcfa);
        if(info.item_prices.selling_price_uni) new AutoNumeric('.profit_uni',autonumericalOptionsFcfa);
        if(info.item_prices.selling_price_cont) new AutoNumeric('.profit_cont',autonumericalOptionsFcfa);

        new AutoNumeric('.current_sell',autonumericalOptionsFcfa);
        new AutoNumeric('.current_profit',autonumericalOptionsFcfa);

}


//build the chart of stock
function stockChart(stock){

    let chart = new Chart($('#stockInfo'),{
        type : 'doughnut',
        data : {
            labels : stock.labels,
            datasets : [{
                data : [
                    stock.info.item_sold,
                    stock.info.item_left,
                    stock.info.item_expired,
                    stock.info.item_damaged
                ],
                backgroundColor : [
                    'rgba(255,99,132,0.2)',
                    'rgba(54,162,135,0.2)',
                    'rgba(255,206,86,0.2)',
                    'rgba(75,1,192,0.2)',
                ],
                hoverBackgroundColor : [
                    'rgba(255,99,132,0.6)',
                    'rgba(54,162,135,0.6)',
                    'rgba(255,206,86,0.6)',
                    'rgba(75,1,192,0.6)',
                ],
                borderColor : [
                    'rgba(255,99,132,1)',
                    'rgba(54,162,135,1)',
                    'rgba(255,206,86,1)',
                    'rgba(75,1,192,1)',
                ],
                borderWidth : 1,
            }],
        },

        options : {
           title : {
               display : true,
               text : "Stock " + stock.info.created_at,
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
