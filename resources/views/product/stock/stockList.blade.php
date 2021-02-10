@extends('layouts.app1')

@section('header')
    {{-- pass the stock type across pages --}}
    <meta name="productId" content="{{ $product->id }}">
    {{-- route use to pull providers --}}
    <meta name="getProviderURL" content="{{ route('product.provider.all') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fas fa-book-medical fa-lg fa-fw"></i><a href="{{route('dashboard')}}" class="p-2 badge badge-secondary">{{__('Dashboard')}}</a><span class="ml-2 mr-2 font-weight-bold border p-1 bg-light text-dark">|></span><a href="{{route('product.category.list')}}" class="p-2 badge badge-secondary">{{__('Categories')}}</a><span class="ml-2 mr-2 font-weight-bold border p-1 bg-light text-dark">|></span><a href="{{route('product.list',$category->id)}}" class="p-2 badge badge-secondary">{{$category->type}}</a><span class="ml-2 mr-2 font-weight-bold border p-1 bg-light text-dark">|></span><a href="#" class="p-2 badge badge-light">{{$product->name}}</a></div>
                <div class="card-body">
                    {{-- delete mutiple item and item count --}}
                    <div class="row justify-content-between mb-4">
                        <div class="col-md-4">
                            <a href="{{route('product.stock.multiple.delete')}}" id="deleteMultipleBtn" data-toggle="modal" data-target="#modalDelete" class="btn btn-light text-primary rounded"><i class="fas fa-trash fa-2x fa-fw text-danger"></i>{{__('Delete selected')}}</a>
                        </div>
                        <div class="col-md-6">
                            @if (request()->stock == 'all' || !request()->has('stock'))
                            <a href="{{route('product.stock.list',$product->id) . '?stock=all'}}" class="p-2 badge badge-dark text-white">{{__('all')}}</a>
                            @else
                            <a href="{{route('product.stock.list',$product->id) . '?stock=all'}}" class="p-2 badge badge-light">{{__('all')}}</a>
                            @endif
                            @if (request()->stock == 'available')
                            <a href="{{route('product.stock.list',$product->id) . '?stock=available'}}" class="p-2 badge badge-dark text-white">{{__('available')}}</a>
                            @else
                            <a href="{{route('product.stock.list',$product->id) . '?stock=available'}}" class="p-2 badge badge-light">{{__('available')}}</a>
                            @endif
                            @if (request()->stock == 'expired')
                            <a href="{{route('product.stock.list',$product->id) . '?stock=expired'}}" class="p-2 badge badge-dark text-white">{{__('expired')}}</a>
                            @else
                            <a href="{{route('product.stock.list',$product->id) . '?stock=expired'}}" class="p-2 badge badge-light">{{__('expired')}}</a>
                            @endif
                            @if (request()->stock == 'out_of_stock')
                            <a href="{{route('product.stock.list',$product->id) . '?stock=out_of_stock'}}" class="p-2 badge badge-dark text-white">{{__('out of Stock')}}</a>
                            @else
                            <a href="{{route('product.stock.list',$product->id) . '?stock=out_of_stock'}}" class="p-2 badge badge-light">{{__('out of Stock')}}</a>
                            @endif
                        </div>
                        <div class="col-md-2">
                            <span class="font-weight-bold item-count">{{trans_choice('item.stock.count',$count,['count'=>$count])}}</span>
                        </div>
                    </div>

                    <div class="row justify-content-center">

                        @if (request()->stock == 'available')
                            <button id="newStockFormBtn" type="button" class="btn btn-light btn-new-item" data-toggle="modal" data-target="#modalAddStock">
                                <div class="card shadow rounded">
                                    <div class="card-body overflow-hidden">
                                    <i class="fas fa-folder-plus fa-10x" aria-hidden="true"></i>
                                    </div>
                                    <div class="card-footer bg-success text-white">{{__('New Stock')}}</div>
                                </div>
                            </button>
                        @endif

                        @foreach ($stocks as $stock)

                            <div class="card m-4 p-0 shadow rounded">
                                <div class="card-body overflow-hidden">
                                    <div class=" btn mr-4 p-0 dashboard-item shadow rounded">
                                        <input type="checkbox" class="btn btn-light option-input cursor checkbox checkbox-2x" id="{{$stock->id}}">
                                    </div>

                                    <a href="{{route('product.stock.update',$stock->id)}}" onclick="getStock(event);" data-toggle="modal" data-target="#modalAddStock" class="dashboard-item btn btn-light p-1 shadow rounded">
                                        <i class="fas fa-edit fa-2x"></i>
                                    </a>

                                    <a href="{{route('product.stock.delete',$stock->id)}}" onclick="grabItem(event);" data-toggle="modal" data-target="#modalDelete" class="dashboard-item btn btn-light p-1 shadow rounded">
                                        <i class="fas fa-window-close fa-2x fa-fw text-danger"></i>
                                    </a>

                                    <a href="{{route('product.stock.lock',$stock->id)}}" onclick="toggleStockVault(event);"  class="dashboard-item btn btn-light p-1 shadow rounded">
                                        @if ($stock->locked)
                                            <i class="fas fa-lock fa-2x fa-fw text-danger"></i>
                                        @else
                                            <i class="fas fa-unlock fa-2x fa-fw text-secondary"></i>
                                        @endif
                                    </a>
                                </div>

                                <a href="{{route('product.stock.view',$stock->id)}}" onclick="viewStockInfo(event);" type="button" data-toggle="modal" data-target="#modalStockView" class="dashboard-item btn btn-light">

                                    <div class="card-footer bg-primary text-left">

                                        <div class="row justify-content-center-between flex-nowrap  card-footer-max-height shadow rounded">
                                            <div class="col-11 flex-grow-0 bg-light text-light" style="font-size: 18px;">
                                                <div class="row bg-light text-secondary justify-content-center">
                                                    <span>{{$stock->created_at}}</span>
                                                </div>
                                                <div class="row bg-secondary justify-content-center">
                                                    <span>{{$stock->buyingPrices()}}</span>
                                                </div>
                                                <div class="row bg-secondary justify-content-center">
                                                    <span>{{$stock->buyingPriceUnit()}}</span>/unit
                                                </div>
                                                <div class="row bg-success justify-content-center">
                                                    <i class="fas fa-shopping-cart fa-sm fa-fw"></i>
                                                    <span>{{$stock->sellingPriceUnit()}}</span>/unit
                                                </div>
                                            </div>
                                            <div class="col-1 bg-secondary text-white">{{$stock->quantity}}</div>
                                        </div>

                                    </div>

                                </a>

                            </div>

                        @endforeach


                             <!-- Modal add new stock-->
                             @include('inc.modal.product.stock.modalAddStock')

                            <!-- Modal stock info -->
                            @include('inc.modal.product.stock.modalStockInfo')

                            <!-- Modal delete stock -->
                            @include('inc.modal.modalDelete')

                            <!-- Modal read barcode -->
                            @include('inc.modal.modalBarecodeReader')

                            {{-- pagination --}}
                        <nav aria-label="...">
                            <ul class="pagination pagination-lg">
                                {{ $stocks->links() }}
                            </ul>
                        </nav>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    <script src="{{asset('js/autoNumeric.min.js')}}"></script>
    <script src="{{asset('js/accounting.min.js')}}"></script>
    <script src="{{asset('js/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('js/quagga.min.js')}}"></script>
    {{-- <script src="{{asset('js/zxing.min.js')}}"></script> --}}
    <script src="{{asset('js/addNewStock.js')}}"></script>
    <script src="{{asset('js/viewStockInfo.js')}}"></script>
    <script src="{{asset('js/deleteStock.js')}}"></script>
    <script src="{{asset('js/updateStock.js')}}"></script>
    <script src="{{asset('js/lockStock.js')}}"></script>
    {{-- barcode scanner with QuaggaJS --}}
    <script src="{{asset('js/barcodeReader.js')}}"></script>
    {{-- barcode scanner with ZxingJS --}}
    {{-- <script src="{{asset('js/barcodeReaderZxing.js')}}"></script> --}}
@endsection
