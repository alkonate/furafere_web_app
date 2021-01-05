@extends('layouts.app1')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><i class="fas fa-book-medical fa-lg fa-fw"></i>{{__('Products List')}}</div>
                    <div class="card-body">

                         {{-- delete mutiple item and item count --}}
                         <div class="row justify-content-between mb-4">
                            <div class="col-md-4">
                                <a href="{{route('product.category.multiple.delete')}}" id="deleteMultipleBtn" data-toggle="modal" data-target="#modalDelete" class="btn btn-light text-primary rounded"><i class="fas fa-trash fa-2x fa-fw text-danger"></i>{{__('Delete selected')}}</a>
                            </div>
                            <div class="col-md-2">
                                <span class="font-weight-bold item-count">{{trans_choice('item.category.count',$count,['count'=>$count])}}</span>
                            </div>
                        </div>

                        <div class="row justify-content-center">

                            <button id="newCategoryFormBtn" type="button" class="btn btn-light btn-new-item" data-toggle="modal" data-target="#modalAddCategory">
                                <div class="card shadow rounded">
                                    <div class="card-body overflow-hidden">
                                    <i class="fas fa-folder-plus fa-10x" aria-hidden="true"></i>
                                    </div>
                                    <div class="card-footer bg-success text-white">{{__('New Category')}}</div>
                                </div>
                            </button>

                            @foreach ($categories as $category)

                            <div class="card m-4 p-0 shadow rounded" style="min-width: 250px">
                                <div class="card-body overflow-hidden">
                                            <div class=" btn mr-1 p-0 dashboard-item shadow rounded">
                                                <input type="checkbox" class="btn btn-light option-input cursor checkbox checkbox-2x" id="{{$category->id}}">
                                            </div>
                                            <a href="{{route('product.category.delete',$category->id)}}" onclick="grabItem(event);" data-toggle="modal" data-target="#modalDelete" class="dashboard-item btn btn-light p-1 shadow rounded">
                                                <i class="fas fa-window-close fa-2x fa-fw text-danger"></i>
                                            </a>
                                            <a href="{{route('product.category.update',$category->id)}}" onclick="getCategory(event);" data-toggle="modal" data-target="#modalUpdateCategory" class="dashboard-item btn btn-light p-1 shadow rounded">
                                                <i class="fas fa-edit fa-2x"></i>
                                            </a>
                                            <div class="row overflow-hidden justify-content-center">
                                                <a href="{{route('product.list',$category->id)}}">
                                                    <img class="product-placeholder-anim" src="{{$category->getMosaic()}}" width="200" height="200" alt="{{$category->type}}">
                                                </a>
                                            </div>
                                        </div>
                                        <a href="{{route('product.category.view',$category->id)}}" onclick="viewCategoryInfo(event);" type="button" data-toggle="modal" data-target="#categoryView" class="dashboard-item btn btn-light">
                                            <div class="card-footer bg-primary text-white">

                                                <div class="row justify-content-center-between flex-nowrap card-footer-max-height shadow rounded">
                                                    <div class="col-11 flex-grow-0 bg-success ">
                                                        {{$category->type}}
                                                    </div>
                                                    <div class="col-1 bg-secondary">{{$category->count}}</div>

                                                </div>
                                            </div>
                                        </a>
                                    </div>

                            @endforeach

                            {{-- category info  modal --}}
                    @include('inc.modal.product.category.modalCategoryInfo')
                    {{-- add new category modal --}}
                    @include('inc.modal.product.category.modalAddCategory')
                    {{-- delete category modal --}}
                    @include('inc.modal.modalDelete')
                    {{-- update category modal --}}
                    @include('inc.modal.product.category.modalUpdateCategory')

                        </div>

                        {{-- pagination --}}
                        <nav aria-label="...">
                            <ul class="pagination pagination-lg">
                                {{ $categories->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('js/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('js/viewCategoryInfo.js')}}"></script>
    <script src="{{asset('js/addNewCategory.js')}}"></script>
    <script src="{{asset('js/deleteCategory.js')}}"></script>
    <script src="{{asset('js/updateCategory.js')}}"></script>
@endsection
