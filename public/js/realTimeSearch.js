  // URI list
  var minifyThumbnailURI ='/img/minify-unknown.jpeg';
  var minifyMosaicURI = minifyThumbnailURI;
   var searchProductURI = "/product/category/:categoryId";
   var searchProviderURI = "/product/providers";
//    var searchStockURI = "/product/category/:categoryId";
   var searchCategoryURI = "/product/categories";

   var product = {
    display : "name",
    href : function (item) {

        return searchProductURI.format({categoryId : item.type_id}) + "?search=" + item.name;
    },
    template : function(query,item){
        var color = '#000';
        var img='';
        if(item.thumbnail==null){
            img = '<img src="' + minifyThumbnailURI + '" class="float-left border">';
        }else{
            img = '<img src="/minify/{{thumbnail}}" class="float-left border">';
        }

        return '<div class="row">' +
                    '<div class="col-3 thumbnail">' +
                       img +
                    '</div>' +
                    '<div class="col-9 productName"> '+
                        '{{name}}' +
                    '</div>' +
                    // '<div class="col-3"> '+
                    //             '<small style="color:' + color +';">' +
                    //             lang.realTimeSearch["Product"] +
                    //             '</small>' +
                    // '</div>' +
                '</div>';

    },
    ajax : function(query){
        return {
            type : "GET",
            url : "/autocomplete/search/product",
            path : "product",
            data : { search : "{{query}}", },
            }
        }
    };

    var category = {
        display : "type",
        href : function (item) {
            return searchCategoryURI + "?search=" + item.type;
        },
        template : function(query,item){
            var color = '#000';

            return '<div class="row">' +
                        '<div class="col-9"> '+
                            '{{type}}' +
                        '</div>' +
                        '<div class="col-3"> '+
                                '<small style="color:' + color +';">' +
                                lang.realTimeSearch["Category"] +
                                '</small>' +
                            '</div>' +
                    '</div>';

        },
        ajax : function(query){
            return {
                type : "GET",
                url : "/autocomplete/search/category",
                path : "category",
                data : { search : "{{query}}", },
                }
            }
        };

        var provider = {
            display : "name",
            href : function (item) {
                return searchProviderURI + "?search=" + item.name;
            },
            template : function(query,item){
                var color = '#000';

                return '<div class="row">' +
                            '<div class="col-9"> '+
                                '{{name}}' +
                            '</div>' +
                            '<div class="col-3"> '+
                                '<small style="color:' + color +';">' +
                                lang.realTimeSearch["Provider"] +
                                '</small>' +
                            '</div>' +
                        '</div>';

            },
            ajax : function(query){
                return {
                    type : "GET",
                    url : "/autocomplete/search/provider",
                    path : "provider",
                    data : { search : "{{query}}", },
                    }
                }
            };
            var stock = {
                display : "name",
                ajax : function(query){
                    return {
                        type : "GET",
                        url : "/autocomplete/search/product",
                        path : "product",
                        data : { search : "{{query}}", },
                        }
                    }
                };


    $.typeahead({
        input : ".js-typeahead",
        hint : true,
        highlight : true,
        dynamic : true,
        cache : sessionStorage,
        delay : 500,
        filter : false,
        asyncResult : true,
        mustSelectItem : true,
        group : true,
        backdrop : {
            "opacity" : 0.15,
            "filter" : "alpha(opacity=15)",
            // "background-color" : "#eaf3ff",
            "background-color" : "#111"
        },

        dropdownFilter : lang.realTimeSearch['All'],
        emptyTemplate : lang.realTimeSearch["zero result for {{query}}"],

        source : {
                   [lang.realTimeSearch["Product"]] : product,
                   [lang.realTimeSearch["Category"]] : category,
                //    [lang.realTimeSearch["Stock"]] : stock,
                [lang.realTimeSearch["Provider"]] : provider,
                },
        //callback
        callback : {
            onDropdownFilter : function (node,a,item,event) {
               if(typeof(item) != 'undefined'){
                node.attr('placeholder',lang.realTimeSearch["Eg : "] + item.value);
               }
            },
        }
    });


