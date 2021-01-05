
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('Validator')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label for="deleteItemPasswordInput">{{__('Password')}}</label>
                  <input type="password" name="deleteItemPasswordInput" id="deleteItemPasswordInput" class="form-control" placeholder="{{__('Enter your password')}}" aria-describedby="helpId">
                  <small id="helpId" class="text-muted">{{__('Enter your password to validate.')}}</small>
                  <small id="helpId" class="text-danger">{{__('This operation can not be undone, it will automatically delete every data associated to the current item.')}}</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="button" class="btn btn-primary" id="deleteBtn">{{__('Delete')}}</button>
            </div>
        </div>

    </div>
</div>
