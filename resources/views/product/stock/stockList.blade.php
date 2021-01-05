@extends('layouts.app1')

@section('header')
    {{-- pass the stock type across pages --}}
    <meta name="type_id" content="{{ $type }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fas fa-book-medical fa-lg fa-fw"></i>{{__('Stock List')}}</div>
                <div class="card-body">
                    {{-- delete mutiple item and item count --}}
                    <div class="row justify-content-between mb-4">
                        <div class="col-md-4">
                            <a href="{{route('product.multiple.delete')}}" id="deleteMultipleBtn" data-toggle="modal" data-target="#modalDelete" class="btn btn-light text-primary rounded"><i class="fas fa-trash fa-2x fa-fw text-danger"></i>{{__('Delete selected')}}</a>
                        </div>
                        <div class="col-md-2">
                            <span class="font-weight-bold item-count">{{trans_choice('item.stock.count',$count,['count'=>$count])}}</span>
                        </div>
                    </div>

                    <div class="row justify-content-center">

                        <button id="newStockFormBtn" type="button" class="btn btn-light btn-new-item" data-toggle="modal" data-target="#modalAddStock">
                            <div class="card shadow rounded">
                                <div class="card-body overflow-hidden">
                                <i class="fas fa-folder-plus fa-10x" aria-hidden="true"></i>
                                </div>
                                <div class="card-footer bg-success text-white">{{__('New Stock')}}</div>
                            </div>
                        </button>

                        @foreach ($stocks as $stock)

                            <div class="card m-4 p-0 shadow rounded">
                                <div class="card-body overflow-hidden">
                                    <a href="{{route('product.stock.add.item',$stock->id)}}" type="button" data-toggle="modal" data-target="#modelItem" class="dashboard-item  btn btn-light p-1 shadow rounded">
                                        <i class="fas fa-plus fa-2x text-primary" aria-hidden="true"></i>
                                    </a>

                                    <a href="{{route('product.stock.barcode',$stock->id)}}" data-toggle="modal" data-target="#modalbarcode" class="dashboard-item  btn btn-light p-1 shadow rounded">
                                       <i class="fas fa-barcode fa-2x fa-fw"></i>
                                    </a>

                                    <a href="{{route('product.stock.delete',$stock->id)}}" onclick="grabStockToDelete(event);" data-toggle="modal" data-target="#modelDelete" class="dashboard-item btn btn-light p-1 shadow rounded">
                                        <i class="fas fa-window-close fa-2x fa-fw text-danger"></i>
                                    </a>

                                    <a href="{{route('product.stock.lock',$stock->id)}}" onclick="toggleStockVault(event);" data-toggle="modal" data-target="#modelLock" class="dashboard-item btn btn-light p-1 shadow rounded">
                                        @if ($stock->locked)
                                            <i class="fas fa-lock fa-2x fa-fw text-danger"></i>
                                        @else
                                            <i class="fas fa-unlock fa-2x fa-fw text-secondary"></i>
                                        @endif
                                    </a>
                                </div>

                                <a href="{{route('product.stock.view',$stock->id)}}" onclick="viewStockInfo(event);" type="button" data-toggle="modal" data-target="#stockView" class="dashboard-item btn btn-light">

                                    <div class="card-footer bg-primary text-left">

                                        <div class="row justify-content-center-between flex-nowrap  card-footer-max-height shadow rounded">
                                            <div class="col-11 flex-grow-0 bg-light text-light" style="font-size: 18px;">
                                                <div class="row bg-light text-secondary justify-content-center">
                                                    <span>{{$stock->created_at}}</span>
                                                </div>
                                                <div class="row bg-secondary justify-content-center">
                                                    <i class="fas fa-shopping-cart fa-sm fa-fw"></i>
                                                    <span>{{$stock->buyingPriceUnit()}}</span>
                                                </div>
                                                <div class="row bg-danger justify-content-center">
                                                    <i class="fas fa-shopping-cart fa-sm fa-fw "></i>
                                                    <span>{{$stock->sellingPriceUnit()}}</span>
                                                </div>
                                                <div class="row bg-success justify-content-center">
                                                    <i class="fas fa-shopping-cart fa-sm fa-fw"></i>
                                                    {{$stock->sellingPriceCont()}}
                                                </div>
                                            </div>
                                            <div class="col-1 bg-secondary text-white">{{$stock->count}}</div>
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

                            <!-- Modal generate stock barcode -->
                            @include('inc.modal.product.stock.modalStockBarcode')

                            <!-- Modal read barcode -->
                            @include('inc.modal.modalBarecodeReader')



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
    {{-- <script src="{{asset('js/quagga.min.js')}}"></script> --}}
    <script src="{{asset('js/zxing.min.js')}}"></script>
    <script src="{{asset('js/addNewStock.js')}}"></script>
    <script src="{{asset('js/viewStockInfo.js')}}"></script>
    <script src="{{asset('js/deleteStock.js')}}"></script>
    <script src="{{asset('js/lockStock.js')}}"></script>
    {{-- barcode scanner with QuaggaJS --}}
    {{-- <script src="{{asset('js/barcodeReader.js')}}"></script> --}}
    {{-- barcode scanner with ZxingJS --}}
    <script src="{{asset('js/barcodeReaderZxing.js')}}"></script>
@endsection
