//start by a helper function grabItem() to grab the current category
//update the href

function viewCategoryInfo(e){

    grabItem(e);
    toggleSpinnerInsideValueFieldsWindow();
    toggleSpinnerInsideGraphWindow();


    ajaxItem(e,undefined,undefined,"GET",function(result){
        toggleSpinnerInsideValueFieldsWindow();
        toggleSpinnerInsideGraphWindow();
        fillValueFieldWindow(undefined,undefined,result.category.info);
        ItemChart(undefined,undefined,backgroundColor,hoverBackgroundColor,borderColor,result.category.title,Object.keys(result.category.data),Object.values(result.category.data));
    },undefined,function(){});
}


