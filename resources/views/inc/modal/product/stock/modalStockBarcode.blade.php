
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('Update Stock')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form  id="updateStockForm" action="" method="post">

                        <div class="form-group">
                            <label for="sellingMethodUpdate">{{__('Sold Per')}}</label>
                            <select class="custom-select sellingMethod" name="sellingMethodUpdate" id="sellingMethodUpdate">
                                <option value="unit">{{__('Unit')}}</option>
                                <option value="content">{{__('Content')}}</option>
                                <option value="both">{{__('Both')}}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="buyingPriceUpdate">{{__('Buying-Price Unit')}}</label>
                            <input type="text"
                              class="form-control buyingPriceUnit" name="buyingPriceUnitUpdate" id="buyingPriceUnitUpdate" aria-describedby="buyingPriceUnitHelper" placeholder="{{_('Enter Price Unit of item')}}">
                            <small id="buyingPriceUnitHelper" class="form-text text-muted">{{__('Enter a buying price unit')}}</small>
                        </div>

                        <div class="form-group unit">
                          <label for="sellingPriceUnitUpdate">{{__('Selling-Price Unit')}}</label>
                          <input type="text"
                            class="form-control sellingPriceUnit" name="sellingPriceUnitUpdate" id="sellingPriceUnitUpdate" aria-describedby="sellingPriceUnitHelper" placeholder="{{_('Enter Price Unit of item')}}">
                          <small id="sellingPriceUnitHelper" class="form-text text-muted">{{__('Enter a selling price unit')}}</small>
                        </div>

                        <div class="form-group content" hidden>
                            <label for="sellingPriceContentUpdate">{{__('Selling-Price Unit Content')}}</label>
                            <input type="text"
                              class="form-control sellingPriceContent" name="sellingPriceContentUpdate" id="sellingPriceContentUpdate" aria-describedby="sellingPriceContentHelper" placeholder="{{_('Enter Price Unit of item')}}">
                            <small id="sellingPriceContentHelper" class="form-text text-muted">{{__('Enter a selling price unit of content')}}</small>
                          </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="button" class="btn btn-primary" id="updateStockBtn">{{__('Update')}}</button>
            </div>
        </div>
    </div>
</div>
