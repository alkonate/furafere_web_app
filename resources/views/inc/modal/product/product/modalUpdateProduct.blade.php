<div class="modal fade" id="modalUpdateProduct" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">{{__('Update Product')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <form  id="UpdateProductForm" action="" method="post">
                        <div class="form-group row justify-content-center">
                            <div class="col-md-7">
                                <div class="card shadow thumbnail">
                                    <div class="card-body shadow">
                                        <img class="profilImage form-control" id="updateimagePreview" src="{{asset('img/thumbnail-unknown.jpeg')}}" alt="">
                                        <input type="file" name="thumbnail" id="updateimgInp" class="file" accept="image/*">
                                    </div>
                                    <div class="card-header text-center">
                                        <button class="btn btn-primary" id="updateupload" type="button">{{__('UPLOAD')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="updatename" class="col-form-label text-md-right">{{ __('Name') }}<span class="required-field">*</span></label>

                            <div class="col-md-12">
                                <input id="updatename" type="text" class="form-control" placeholder="{{__('Enter Product Name')}}" name="name" required autocomplete="off" autofocus>
                                <small id="updateProductNameHelper" class="text-muted">{{__('Please enter the name of your product')}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="updateminQuantity" class="col-form-label text-md-right">{{ __('Min quantity') }}<span class="required-field">*</span></label>

                            <div class="col-md-12">
                                <input id="updateminQuantity" type="number" class="form-control" placeholder="{{__('Enter minimum quantity')}}" name="minQuantity" required autocomplete="off" autofocus>
                                <small id="updateProductMinQuantityHelper" class="text-muted">{{__('Please enter the minimum quantity of product')}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="updatedescription" class="col-form-label text-md-right">{{ __('Description')}} <span class="required-field">*</span> </label>
                            <div class="col-md-12">
                                <textarea  id="updatedescription" class="form-control" name="description"  required autocomplete="off"></textarea>
                                <small id="updateProductDescriptionHelper" class="text-muted">{{__('Please enter a description of the product')}}</small>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="button" id="updateProduct" class="btn btn-primary">{{__('Update Product')}}</button>
            </div>
        </div>
    </div>
</div>
