<div class="modal fade" id="modalAddCategory" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('New Category')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label for="ProductType">{{__('Category')}}</label>
                  <input type="text" name="ProductType" id="ProductType"  class="form-control" placeholder="{{__('Enter category name')}}" aria-describedby="helpId">
                  <small id="helpId" class="text-muted">{{__('Enter new category name of product.')}}</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="button" class="btn btn-primary"  href="{{route('product.category.add')}}" id="addCategory">{{__('New category')}}</button>
            </div>
        </div>

    </div>
</div>
