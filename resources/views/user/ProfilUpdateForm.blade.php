@extends('layouts.app1')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Update') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.profil.update') }}" enctype="multipart/form-data">
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
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}<span class="required-field">*</span></label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{old('username') ?? $user->username }}" required autocomplete="off">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}<span class="required-field">*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm cassword') }}<span class="required-field">*</span></label>

                            <div class="col-md-6">
                                <input id="password_confirm" type="password" class="form-control @error('password_confirm') is-invalid @enderror" name="password_confirm" required  autocomplete="off">

                                @error('password_confirm')
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
