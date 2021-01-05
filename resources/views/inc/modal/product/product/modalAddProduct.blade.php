<div class="modal fade" id="modalAddProduct" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">{{__('New Product')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form  id="newProductForm" action="" method="post">

                        <div class="form-group row justify-content-center">
                            <div class="col-md-7">
                                <div class="card shadow thumbnail">
                                    <div class="card-body shadow">
                                        <img class="profilImage form-control" id="imagePreview" src="{{asset('img/thumbnail-unknown.jpeg')}}" alt="">
                                        <input type="file" name="thumbnail" id="imgInp" class="file" accept="image/*">
                                    </div>
                                    <div class="card-header text-center">
                                        <button class="btn btn-primary" id="upload" type="button">{{__('UPLOAD')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-form-label text-md-right">{{ __('Name') }}<span class="required-field">*</span></label>

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control" placeholder="{{__('Enter Product Name')}}" name="name" required autocomplete="off" autofocus>
                                <small id="ProductNameHelper" class="text-muted">{{__('Please enter the name of your product')}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="minQuantity" class="col-form-label text-md-right">{{ __('Min quantity') }}<span class="required-field">*</span></label>

                            <div class="col-md-12">
                                <input id="minQuantity" type="number" class="form-control" placeholder="{{__('Enter minimum quantity')}}" name="minQuantity" required autocomplete="off" autofocus>
                                <small id="ProductMinQuantityHelper" class="text-muted">{{__('Please enter the minimum quantity of product')}}</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-form-label text-md-right">{{ __('Description')}} <span class="required-field">*</span> </label>
                            <div class="col-md-12">
                                <textarea  id="description" class="form-control" name="description"  required autocomplete="off"></textarea>
                                <small id="ProductDescriptionHelper" class="text-muted">{{__('Please enter a description of the product')}}</small>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="button" id="addProduct" href="{{route('product.add')}}" class="btn btn-primary">{{__('NEw Product')}}</button>
            </div>
        </div>
    </div>
</div>
