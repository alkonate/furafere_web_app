<div class="modal fade" id="modalUpdateCategory" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('New Category')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form  id="UpdateCategoryForm" action="" method="post">
                        <div class="form-group">
                            <label for="UpdateCategory">{{__('Category')}}</label>
                            <input type="text" name="UpdateCategory" id="UpdateCategory" class="form-control" placeholder="{{__('Enter category name')}}" aria-describedby="helpId">
                            <small id="helpId" class="text-muted">{{__('Enter category name.')}}</small>
                          </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="button" class="btn btn-primary" id="updateType">{{__('Update')}}</button>
            </div>
        </div>

    </div>
</div>
