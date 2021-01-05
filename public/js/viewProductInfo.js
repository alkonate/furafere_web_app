//start by a helper function grabItem() to grab the current product
//update the href

function viewProductInfo(e){

    grabItem(e);
    toggleSpinnerInsideValueFieldsWindow();
    toggleSpinnerInsideGraphWindow();

    ajaxItem(e,undefined,undefined,"GET",function(result){
        toggleSpinnerInsideValueFieldsWindow();
        toggleSpinnerInsideGraphWindow();
        fillValueFieldWindow(undefined,undefined,result.product.info);
        ItemChart(undefined,undefined,backgroundColor,hoverBackgroundColor,borderColor,result.product.title,Object.keys(result.product.data),Object.values(result.product.data));
    },undefined,function(){});
}

