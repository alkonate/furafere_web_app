<div class="modal fade" id="modalAddStock" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">{{__('New Stock')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form  id="newStockForm" action="" method="post">

                        <label for="barcode">{{__('Stock barcode')}}</label>
                        <div class="input-group">
                            <input type="text"
                              class="form-control" name="barcode" id="barcode" aria-describedby="barcodeHelper" placeholder="{{_('Enter the barcode')}}">
                            <div class="input-group-append">
                                <button type="button" class="input-group-text btn" id="barcodeReader" data-toggle="modal" data-target="#modalBarecodeReader"><i class="fas fa-barcode fa-lg fa-fw"></i></button>
                            </div>
                        </div>
                        <small id="barcodeHelper" class="form-text text-muted">{{__('Enter the stock barcode')}}</small>

                        <div class="form-group">
                            <label for="itemCount">{{__('Item count')}}</label>
                            <input type="number"
                              class="form-control" name="itemCount" id="itemCount" aria-describedby="itemCountHelper" placeholder="{{_('Enter the number of item')}}">
                            <small id="itemCountHelper" class="form-text text-muted">{{__('Enter the total number of item')}}</small>
                        </div>

                        <div class="form-group">
                            <label for="buyingPrice">{{__('Buying-Price')}}</label>
                            <input type="text" disabled
                              class="form-control" name="buyingPrice" id="buyingPrice" aria-describedby="buyingPriceHelper" placeholder="{{_('Enter Price of items')}}">
                            <small id="buyingPriceHelper" class="form-text text-muted">{{__('Enter a buying price for your items')}}</small>
                        </div>

                        <div class="form-group">
                            <label for="buyingPriceUnit">{{__('Buying-Price Unit')}}</label>
                            <input type="text" disabled
                              class="form-control" name="buyingPriceUnit" id="buyingPriceUnit" aria-describedby="buyingPriceUnitHelper" placeholder="{{_('Enter Price Unit of item')}}">
                            <small id="buyingPriceUnitHelper" class="form-text text-muted">{{__('Enter a buying price unit')}}</small>
                        </div>

                        <div class="form-group">
                          <label for="sellingPriceUnit">{{__('Selling-Price Unit')}}</label>
                          <input type="text"
                            class="form-control" name="sellingPriceUnit" id="sellingPriceUnit" aria-describedby="sellingPriceUnitHelper" placeholder="{{_('Enter Price Unit of item')}}">
                          <small id="sellingPriceUnitHelper" class="form-text text-muted">{{__('Enter a selling price unit')}}</small>
                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="button" id="addStock" href="{{route('product.stock.add')}}" class="btn btn-primary">{{__('NEw Stock')}}</button>
            </div>
        </div>
    </div>
</div>
