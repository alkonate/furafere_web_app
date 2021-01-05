<div class="modal fade" id="providerView" tabindex="-1" role="dialog" aria-labelledby="providerViewTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">{{__('Provider Info')}}</h5>
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
                                        <div class="col-6"  id="fieldNames">
                                            <p class="card-text" id="fieldName">{{__('Name')}}</p>
                                            <p class="card-text" id="fieldAddress">{{__('Address')}}</p>
                                            <p class="card-text" id="fieldEmail">{{__('Email')}}</p>
                                            <p class="card-text" id="fieldTelephone1">{{__('Telephone 1')}}</p>
                                            <p class="card-text" id="fieldTelephone2">{{__('Telephone 2')}}</p>
                                            <p class="card-text" id="fieldItemCount">{{__('Item count')}}</p>
                                            <p class="card-text" id="fieldItemSold">{{__('Item sold')}}</p>
                                            <p class="card-text" id="fieldItemExpired">{{__('Item expired')}}</p>
                                            <p class="card-text" id="fieldItemDamaged">{{__('Item damaged')}}</p>
                                            <p class="card-text" id="fieldItemLeft">{{__('Item left')}}</p>
                                        </div>
                                        <div class="col-6" id="fieldValues">

                                        </div>
                                    </div>
                                  </div>
                                </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div id="spinnerloadingGraph">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
