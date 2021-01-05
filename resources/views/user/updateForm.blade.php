@extends('layouts.app1')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Update') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.SuperAdmin.update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="id" value="{{$user->id}}" hidden>
                        <div class="form-group row justify-content-center image-container">
                            <div class="card  shadow">
                                <div class="card-body shadow">
                                    <img class="profilImage  form-control @error('image') is-invalid @enderror" id="imagePreview" src="{{asset($userImage)}}" alt="">
                                    <input type="file" name="image" id="imgInp" class="file" accept="image/*">

                                </div>
                                <div class="card-header text-center">
                                    <button class="btn btn-primary" id="upload" type="button">{{__('UPLOAD')}}</button>
                                </div>
                            </div>
                        </div>
                        @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror



                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-right">{{ __('Firstname') }}<span class="required-field">*</span></label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') ?? $userInfo->firstname }}" required autocomplete="off" autofocus>

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Lastname') }} <span class="required-field">*</span> </label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') ?? $userInfo->lastname }}" required autocomplete="off" autofocus>

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }} <span class="required-field">*</span>  </label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{old('username') ?? $user->username }}" required autocomplete="off" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Privilege*') }} <span class="required-field">*</span> </label>

                            <div class="col-md-6">
                                <select name="role" class="form-control @error('role') is-invalid @enderror" required id="role">
                                    @if (old('role'))
                                        @foreach ($rolesTrans as $roleTrans)
                                        @if (old('role')==$roleTrans->name)
                                            <option value="{{$roleTrans->name}}" selected>{{$roleTrans->name}}</option>
                                        @else
                                            <option value="{{$roleTrans->name}}">{{$roleTrans->name}}</option>
                                        @endif

                                        @endforeach
                                    @else
                                        @foreach ($rolesTrans as $roleTrans)
                                        @if ($userRole==$roleTrans->name)
                                            <option value="{{$roleTrans->name}}" selected>{{$roleTrans->name}}</option>
                                        @else
                                            <option value="{{$roleTrans->name}}">{{$roleTrans->name}}</option>
                                        @endif

                                        @endforeach
                                    @endif
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $userInfo->email }}"  autocomplete="off">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telephone" class="col-md-4 col-form-label text-md-right">{{ __('Telephone') }}</label>

                            <div class="col-md-6">
                                <input id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{old('telephone') ??  $userInfo->telephone }}"  autocomplete="off" autofocus>

                                @error('telephone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') ?? $userInfo->address }}"  autocomplete="off" autofocus>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>




                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Validate') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    <script src="{{asset('js/previewImage.js')}}"></script>

@endsection
