<div class="modal fade" id="modalStockView" tabindex="-1" role="dialog" aria-labelledby="modalStockViewTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Stock Info</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card text-left">

                                <div class="card-body bg-secondary text-light">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="card-text">{{__('Count item')}}</p>
                                            <p class="card-text">{{__('Count content per item')}}</p>
                                            <p class="card-text">{{__('Buying price unit')}}</p>
                                            <p class="card-text">{{__('Buying price total')}}</p>
                                            <p class="card-text">{{__('Selling price unit')}}</p>
                                            <p class="card-text">{{__('Selling price content')}}</p>
                                            <p class="card-text">{{__('Profit margin unit')}}</p>
                                            <p class="card-text">{{__('Profit margin Content')}}</p>
                                            <p class="card-text">{{__('Current sell')}}</p>
                                            <p class="card-text">{{__('Current profit')}}</p>
                                        </div>
                                        <div class="col-6" id="price-column">

                                        </div>
                                    </div>
                                  </div>
                                </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div id="SpinnerLoadingStockInfo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
