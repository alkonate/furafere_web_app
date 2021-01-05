<div class="modal fade" id="modalAddProvider" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">{{__('New Provider')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form  id="newProviderForm" action="" method="post">
                        <div class="form-group">
                            <label for="ProviderName" class="col-form-label text-md-right">{{__('Provider name')}}<span class="required-field">*</span></label>
                            <div class="col-md-12">
                                <input type="text" name="ProviderName" id="ProviderName" class="form-control" placeholder="{{__('Enter Provider Name')}}" aria-describedby="ProviderNameHelper">
                                <small id="ProviderNameHelper" class="text-muted">{{__('Please enter the name of your provider')}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ProviderEmail" class="col-form-label text-md-right">{{__('Provider Email')}}</label>

                            <div class="col-md-12">
                                <input type="email" name="ProviderEmail" id="ProviderEmail" class="form-control" placeholder="{{__('Enter Provider Email')}}" aria-describedby="ProviderEmailHelper">
                                <small id="ProviderEmailHelper" class="text-muted">{{__('Please enter the email of your provider')}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ProviderAddress" class="col-form-label text-md-right">{{__('Provider address')}}</label>

                            <div class="col-md-12">
                                <input type="text" name="ProviderAddress" id="ProviderAddress" class="form-control"  placeholder="{{__('Enter Provider Address')}}" aria-describedby="ProviderAddresseHelper">
                                <small id="ProviderAddressHelper" class="text-muted">{{__('Please enter the address of your provider')}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ProviderTelephone1" class="col-form-label text-md-right">{{__('Provider telephone number 1')}}</label>

                            <div class="col-md-12">
                                <input type="text" name="ProviderTelephone1" id="ProviderTelephone1" class="form-control"  placeholder="{{__('Enter Provider Telephone 1')}}" aria-describedby="ProviderTelephone1Helper">
                                <small id="ProviderTelephone1Helper" class="text-muted">{{__('Please enter the Telephone of your provider')}}</small>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="ProviderTelephone2" class="col-form-label text-md-right">{{__('Provider telephone number 2')}}</label>

                            <div class="col-md-12">
                                <input type="text" name="ProviderTelephone2" id="ProviderTelephone2" class="form-control"  placeholder="{{__('Enter Provider Telephone 2')}}" aria-describedby="ProviderTelephone2Helper">
                                <small id="ProviderTelephone2Helper" class="text-muted">{{__('Please enter the Telephone of your provider')}}</small>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="button" id="addProvider" href="{{route('product.provider.add')}}" class="btn btn-primary">{{__('NEw Provider')}}</button>
            </div>
        </div>
    </div>
</div>
