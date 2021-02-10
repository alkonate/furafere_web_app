<div class="modal fade" id="modalAddStock" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">{{__('Stock')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form  id="newStockForm" action="" method="post">

                        <div class="form-group">
                            <label for="barcode">{{__('Stock barcode')}}</label>
                            <div class="input-group">
                                <input type="text" autofocus
                                class="form-control" name="barcode" id="barcode" aria-describedby="barcodeHelper" placeholder="{{_('Enter the barcode')}}">
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text btn" id="barcodeReader" data-toggle="modal" data-target="#modalBarecodeReader"><i class="fas fa-barcode fa-lg fa-fw"></i></button>
                                </div>
                            </div>
                            <small id="barcodeHelper" class="form-text text-muted">{{__('Enter the stock barcode')}}</small>
                        </div>

                        <div class="form-group">
                            <label for="providerId">{{__('Stock provider')}}</label>
                            <select name="providerId"  class="form-control" id="providerId">
                                {{-- insert via JS/AJAX --}}
                            </select>
                            <small id="providerIdHelper" class="form-text text-muted">{{__('Choose the provider for this stock of product')}}</small>
                            <a href="{{route('product.provider.list') . '?action=new'}}">{{__('Add new provider ?')}}</a>
                        </div>

                        <div class="row 0 copyAfter">
                            <input type="text" id="itemId0" href="{{route('product.stock.item.delete')}}" name="itemId[]" class="form-control" disabled hidden>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="expireDate0">{{__('Stock expiration date')}}</label>
                                    <input type="date"
                                      class="form-control" name="expireDate[]" id="expireDate0" aria-describedby="expireDate0Helper" placeholder="{{__('MM/DD/YEAR')}}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="itemCount0">{{__('Stock item count')}}</label>
                                    <input type="number"
                                      class="form-control" onchange="itemCountUpdated();" name="itemCount[]" id="itemCount0" aria-describedby="itemCount0Helper" placeholder="{{_('0')}}">
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="text-white">add</label>
                                <div class="btn btn-primary" id="addMoreItemField" onclick="addNewDateItemQuantity();"><i class="fas fa-plus" aria-hidden="true"></i></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="buyingPrice">{{__('Buying-Price')}}</label>
                                    <input type="text" disabled
                                      class="form-control" name="buyingPrice" id="buyingPrice" aria-describedby="buyingPriceHelper" placeholder="{{_('0 FRANC CFA')}}">
                                    <small id="buyingPriceHelper" class="form-text text-muted">{{__('Enter a buying price for your items')}}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="buyingPriceUnit">{{__('Buying-Price Unit')}}</label>
                                    <input type="text" disabled
                                        class="form-control" name="buyingPriceUnit" id="buyingPriceUnit" aria-describedby="buyingPriceUnitHelper" placeholder="{{_('0 FRANC CFA')}}">
                                    <small id="buyingPriceUnitHelper" class="form-text text-muted">{{__('Enter a buying price unit')}}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="sellingPriceUnit">{{__('Selling-Price Unit')}}</label>
                                    <input type="text" disabled
                                      class="form-control" name="sellingPriceUnit" id="sellingPriceUnit" aria-describedby="sellingPriceUnitHelper" placeholder="{{_('0 FRANC CFA')}}">
                                    <small id="sellingPriceUnitHelper" class="form-text text-muted">{{__('Enter a selling price unit')}}</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="diff">{{__('Difference')}}</label>
                                    <input type="text" disabled
                                      class="form-control text-light" name="diff" id="diff" aria-describedby="diffHelper" placeholder="{{_('0 FRANC CFA')}}">
                                    <small id="diffHelper" class="form-text text-muted">{{__('This is the difference')}}</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="button" id="addStock" href="{{route('product.stock.add')}}" class="btn btn-primary">{{__('New stock')}}</button>
                <button type="button" id="updateStock" href="#" class="btn btn-primary">{{__('Update stock')}}</button>
            </div>
        </div>
    </div>
</div>
