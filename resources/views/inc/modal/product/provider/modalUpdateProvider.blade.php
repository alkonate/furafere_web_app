<div class="modal fade" id="modalUpdateProvider" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">{{__('Update Provider')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <form  id="UpdateProviderForm" action="" method="post">
                        <div class="form-group">
                            <label for="UpdateProviderName" class="col-form-label text-md-right">{{__('Provider name')}}<span class="required-field">*</span></label>
                            <div class="col-md-12">
                                <input type="text" name="UpdateProviderName" id="UpdateProviderName" class="form-control" placeholder="{{__('Enter Provider Name')}}" aria-describedby="UpdateProviderNameHelper">
                                <small id="UpdateProviderNameHelper" class="text-muted">{{__('Please enter the name of your provider')}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="UpdateProviderEmail" class="col-form-label text-md-right">{{__('Provider Email')}}</label>
                            <div class="col-md-12">
                                <input type="email" name="UpdateProviderEmail" id="UpdateProviderEmail" class="form-control" placeholder="{{__('Enter Provider Email')}}" aria-describedby="UpdateProviderEmailHelper">
                                <small id="UpdateProviderEmailHelper" class="text-muted">{{__('Please enter the email of your provider')}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="UpdateProviderAddress" class="col-form-label text-md-right">{{__('Provider address')}}</label>

                            <div class="col-md-12">
                                <input type="text" name="UpdateProviderAddress" id="UpdateProviderAddress" class="form-control"  placeholder="{{__('Enter Provider Address')}}" aria-describedby="UpdateProviderAddresseHelper">
                                <small id="UpdateProviderAddressHelper" class="text-muted">{{__('Please enter the address of your provider')}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="UpdateProviderTelephone1" class="col-form-label text-md-right">{{__('Provider telephone number 1')}}</label>

                            <div class="col-md-12">
                                <input type="text" name="UpdateProviderTelephone1" id="UpdateProviderTelephone1" class="form-control"  placeholder="{{__('Enter Provider Telephone 1')}}" aria-describedby="UpdateProviderTelephone1Helper">
                                <small id="UpdateProviderTelephone1Helper" class="text-muted">{{__('Please enter the Telephone of your provider')}}</small>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="UpdateProviderTelephone2" class="col-form-label text-md-right">{{__('Provider telephone number 2')}}<span class="required-field">*</span></label>

                            <div class="col-md-12">
                                <input type="text" name="UpdateProviderTelephone2" id="UpdateProviderTelephone2" class="form-control"  placeholder="{{__('Enter Provider Telephone 2')}}" aria-describedby="UpdateProviderTelephone2Helper">
                                <small id="UpdateProviderTelephone2Helper" class="text-muted">{{__('Please enter the Telephone of your provider')}}</small>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="button" id="updateProvider" class="btn btn-primary">{{__('Update Provider')}}</button>
            </div>
        </div>
    </div>
</div>
