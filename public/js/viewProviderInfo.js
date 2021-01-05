//start by a helper function grabItem() to grab the current provider
//update the href

function viewProviderInfo(e){

    grabItem(e);
    toggleSpinnerInsideValueFieldsWindow();
    toggleSpinnerInsideGraphWindow();


    ajaxItem(e,undefined,undefined,"GET",function(result){
        toggleSpinnerInsideValueFieldsWindow();
        toggleSpinnerInsideGraphWindow();
        fillValueFieldWindow(undefined,undefined,result.provider.info);
        ItemChart(undefined,undefined,backgroundColor,hoverBackgroundColor,borderColor,result.provider.title,Object.keys(result.provider.data),Object.values(result.provider.data));
    },undefined,function(){});
}

