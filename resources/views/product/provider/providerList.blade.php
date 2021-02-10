@extends('layouts.app1')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> <i class="fas fa-truck-moving fa-xs fa-fw"></i> {{__('Providers List')}}</div>
                    <div class="card-body">
                        {{-- delete mutiple item and item count --}}
                        <div class="row justify-content-between mb-4">
                            <div class="col-md-4">
                                <a href="{{route('product.provider.multiple.delete')}}" id="deleteMultipleBtn" data-toggle="modal" data-target="#modalDelete" class="btn btn-light text-primary rounded"><i class="fas fa-trash fa-2x fa-fw text-danger"></i>{{__('Delete selected')}}</a>
                            </div>
                            <div class="col-md-2">
                                <span class="font-weight-bold item-count">{{trans_choice('item.provider.count',$count,['count'=>$count])}}</span>
                            </div>
                        </div>

                       <div class="row justify-content-center">

                        @if (!request()->has('search'))
                            <button id="newProviderFormBtn" type="button" class="btn btn-light btn-new-item" data-toggle="modal" data-target="#modalAddProvider">
                                <div class="card shadow rounded">
                                    <div class="card-body overflow-hidden">
                                    <i class="fas fa-folder-plus fa-10x" aria-hidden="true"></i>
                                    </div>
                                    <div class="card-footer bg-success text-white">{{__('NEW PROVIDER')}}</div>
                                </div>
                            </button>
                        @endif


                    @foreach ($providers as $provider)

                        <div class="card m-4 p-0 shadow rounded" style="min-width: 250px">
                            <div class="card-body overflow-hidden">
                                <div class=" btn mr-1 p-0 dashboard-item shadow rounded">
                                    <input type="checkbox" class="btn btn-light option-input cursor checkbox checkbox-2x" id="{{$provider->id}}">
                                </div>
                                <a href="{{route('product.provider.delete',$provider->id)}}" onclick="grabItem(event);" data-toggle="modal" data-target="#modalDelete" class="dashboard-item btn btn-light p-1 shadow rounded">
                                    <i class="fas fa-window-close fa-2x fa-fw text-danger"></i>
                                </a>
                                <a href="{{route('product.provider.update',$provider->id)}}" onclick="getProvider(event);" data-toggle="modal" data-target="#modalUpdateProvider" class="dashboard-item btn btn-light p-1 shadow rounded">
                                    <i class="fas fa-edit fa-2x"></i>
                                </a>

                            </div>

                            <a href="{{route('product.provider.view',$provider->id)}}" onclick="viewProviderInfo(event);" type="button" data-toggle="modal" data-target="#providerView" class="dashboard-item btn btn-light">

                                <div class="card-footer bg-primary text-left">

                                    <div class="row justify-content-center-between flex-nowrap  card-footer-max-height shadow rounded">
                                        <div class="col-11 flex-grow-0 bg-light text-light" style="font-size: 18px;">
                                            <div class="row bg-light text-secondary justify-content-center">
                                                <span>{{$provider->name}}</span>
                                            </div>
                                            <div class="row bg-light text-secondary justify-content-center">
                                                <span>{{$provider->telephone1}}</span>
                                            </div>
                                            <div class="row bg-light text-secondary justify-content-center">
                                                <span>{{$provider->telephone2}}</span>
                                            </div>
                                        </div>
                                        {{-- <div class="col-1 bg-secondary text-white">100</div> --}}
                                        <div class="col-1 bg-secondary text-white">{{$provider->item_left}}</div>
                                    </div>

                                </div>
                            </a>

                        </div>

                    @endforeach


                    {{-- provider info  modal --}}
                    @include('inc.modal.product.provider.modalProviderInfo')
                    {{-- add new provider modal --}}
                    @include('inc.modal.product.provider.modalAddProvider')
                    {{-- delete provider modal --}}
                    @include('inc.modal.modalDelete')
                    {{-- update provider modal --}}
                    @include('inc.modal.product.provider.modalUpdateProvider')
                       </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('js/viewProviderInfo.js')}}"></script>
    <script src="{{asset('js/addNewProvider.js')}}"></script>
    <script src="{{asset('js/deleteProvider.js')}}"></script>
    <script src="{{asset('js/updateProvider.js')}}"></script>
@endsection
