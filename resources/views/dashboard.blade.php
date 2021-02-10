@extends('layouts.app1')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><i class="fas fa-book-medical fa-lg fa-fw"></i><a href="#" class="p-2 badge badge-light">{{__('Dashboard')}}</a></div>
                <div class="card-body">
                    <div class="d-md-flex flex-wrap justify-content-between">

                        <a href="{{route('product.category.list')}}" class="dashboard-item">
                            <div class="card">
                                <div class="card-body">
                                    <i class="fas fa-capsules fa-10x" aria-hidden="true"></i>
                                    <div class="card-title p-2 text-center bg-primary text-white mt-1">{{__('PRODUCTS')}}</div>
                                </div>
                            </div>
                        </a>

                        <a href="{{route('product.provider.list')}}" class="dashboard-item">
                            <div class="card">
                                <div class="card-body">
                                    <i class="fas fa-truck-moving fa-10x"></i>
                                    <div class="card-title p-2 text-center bg-primary text-white mt-1">{{__('PROVIDERS')}}</div>
                                </div>
                            </div>
                        </a>

                        <a href="{{route('user.create')}}" class="dashboard-item">
                            <div class="card">
                                <div class="card-body">
                                    <i class="fas fa-user-md fa-10x" aria-hidden="true"></i>
                                    <div class="card-title p-2 text-center bg-primary text-white mt-1">{{__('NEW ACCOUNT')}}</div>
                                </div>
                            </div>
                        </a>

                        <a href="{{route('user.SuperAdmin.users')}}" class="dashboard-item">
                            <div class="card">
                                <div class="card-body">
                                    <i class="fas fa-user-cog fa-10x" aria-hidden="true"></i>
                                    <div class="card-title p-2 text-center bg-primary text-white mt-1">{{__('USERS')}}</div>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 row justify-content-center">
        <div class="col-6">
            <div class="card">
                <div class="card-header">{{__('Hot sell')}}</div>
                <div class="card-body">
                    {{__('products')}}
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">{{__('Notification')}}</div>
                <div class="card-body">
                    {{__('products')}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

