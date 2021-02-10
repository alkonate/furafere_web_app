@extends('layouts.app1')

@section('header')
    {{-- pass the product type across pages --}}
    <meta name="type_id" content="{{ $category->id }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><i class="fas fa-book-medical fa-lg fa-fw"></i><a href="{{route('dashboard')}}" class="p-2 badge badge-secondary">{{__('Dashboard')}}</a><span class="ml-2 mr-2 font-weight-bold border p-1 bg-light text-dark">|></span><a href="{{route('product.category.list')}}" class="p-2 badge badge-secondary">{{__('Categories')}}</a><span class="ml-2 mr-2 font-weight-bold border p-1 bg-light text-dark">|></span><a href="#" class="p-2 badge badge-light">{{$category->type}}</a></div>
                    <div class="card-body">
                        {{-- delete mutiple item and item count --}}
                        <div class="row justify-content-between mb-4">
                            <div class="col-md-4">
                                <a href="{{route('product.multiple.delete')}}" id="deleteMultipleBtn" data-toggle="modal" data-target="#modalDelete" class="btn btn-light text-primary rounded"><i class="fas fa-trash fa-2x fa-fw text-danger"></i>{{__('Delete selected')}}</a>
                            </div>
                            <div class="col-md-2">
                                <span class="font-weight-bold item-count">{{trans_choice('item.product.count',$count,['count'=>$count])}}</span>
                            </div>
                        </div>

                        <div class="row justify-content-center">

                            @if (!request()->has('search'))
                                <button id="newProductFormBtn" type="button" class="btn btn-light btn-new-item" data-toggle="modal" data-target="#modalAddProduct">
                                    <div class="card shadow rounded">
                                        <div class="card-body overflow-hidden">
                                        <i class="fas fa-folder-plus fa-10x" aria-hidden="true"></i>
                                        </div>
                                        <div class="card-footer bg-success text-white">{{__('New Product')}}</div>
                                    </div>
                                </button>
                            @endif

                            @foreach ($products as $product)

                            <div class="card m-4 p-0 shadow rounded" style="width: 250px">
                                <div class="card-body overflow-hidden">
                                            <div class=" btn mr-1 p-0 dashboard-item shadow rounded">
                                                <input type="checkbox" class="btn btn-light option-input cursor checkbox checkbox-2x" id="{{$product->id}}">
                                            </div>
                                            <a href="{{route('product.delete',$product->id)}}" onclick="grabItem(event);" data-toggle="modal" data-target="#modalDelete" class="dashboard-item btn btn-light p-1 shadow rounded">
                                                <i class="fas fa-window-close fa-2x fa-fw text-danger"></i>
                                            </a>
                                            <a href="{{route('product.update',$product->id)}}" onclick="getProduct(event);" data-toggle="modal" data-target="#modalUpdateProduct" class="dashboard-item btn btn-light p-1 shadow rounded">
                                                <i class="fas fa-edit fa-2x"></i>
                                            </a>
                                            <div class="row overflow-hidden justify-content-center">
                                                <a href="{{route('product.stock.list',$product->id) . '?stock=available'}}">
                                                    <img class="product-placeholder-anim" src="{{$product->getthumbnail()}}" width="200" height="200" alt="{{$product->type}}">
                                                </a>
                                            </div>
                                        </div>
                                        <a href="{{route('product.view',$product->id)}}" onclick="viewProductInfo(event);" type="button" data-toggle="modal" data-target="#productView" class="dashboard-item btn btn-light">
                                            <div class="card-footer bg-primary text-white">

                                                <div class="row justify-content-center-between flex-nowrap card-footer-max-height shadow rounded">
                                                    <div class="col-11 flex-grow-0 bg-success ">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                {{$product->name}}
                                                            </div>
                                                        </div>
                                                        <div class="row justify-content-start">
                                                            <div class="col-12">
                                                                {{$product->miniDescription()}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-1 bg-secondary">{{$product->stocks()->count()}}</div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                            @endforeach

                            {{-- product info  modal --}}
                    @include('inc.modal.product.product.modalProductInfo')
                    {{-- add new product modal --}}
                    @include('inc.modal.product.product.modalAddProduct')
                    {{-- delete product modal --}}
                    @include('inc.modal.modalDelete')
                    {{-- update product modal --}}
                    @include('inc.modal.product.product.modalUpdateProduct')

                        </div>
                        {{-- pagination --}}
                        <nav aria-label="...">
                            <ul class="pagination pagination-lg">
                                {{ $products->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- preview the image before uploading --}}
    <script src="{{asset('js/previewImage.js')}}"></script>
    <script src="{{asset('js/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('js/viewProductInfo.js')}}"></script>
    <script src="{{asset('js/addNewProduct.js')}}"></script>
    <script src="{{asset('js/deleteProduct.js')}}"></script>
    <script src="{{asset('js/updateProduct.js')}}"></script>
@endsection
