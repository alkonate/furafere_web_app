@extends('layouts.app1')
@section('header')
    <meta name="csfr-token" content="{{csrf_token()}}">
@endsection
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><i class="fa fa-table" aria-hidden="true"></i>{{__('User')}}</div>
                    <div class="card-body">

                        <div class="form-group row justify-content-center">
                            <div class="card  shadow">
                                <div class="card-body shadow">
                                    <img class="profilImage  form-control" id="imagePreview" src="{{asset($userImage)}}" alt="">
                                </div>

                            </div>


                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-right">{{ __('Firstname') }}</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control"  value="{{ $userInfo->firstname }}" disabled autocomplete="off" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Lastname') }}</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control"  value="{{ $userInfo->lastname }}" disabled autocomplete="off" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control"  value="{{ $user->username }}" disabled autocomplete="off" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Privilege') }}</label>

                            <div class="col-md-6">
                                <input id="role" type="text" class="form-control"  value="{{ $userRole }}" disabled autocomplete="off" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control"  value="{{ $userInfo->email }}" disabled autocomplete="off" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telephone" class="col-md-4 col-form-label text-md-right">{{ __('Telephone') }}</label>

                            <div class="col-md-6">
                                <input id="telephone" type="text" class="form-control"  value="{{ $userInfo->telephone }}" disabled autocomplete="off" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control"  value="{{ $userInfo->address }}" disabled autocomplete="off" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">

                                <button form="formUpdate" type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                                <button type="button" id="reset" onclick="resetPassword({{$user->id}});" class="btn btn-success">
                                    {{ __('Reset Password') }}
                                </button>

                            </div>
                        </div>

                        <form action="{{route('user.SuperAdmin.updateForm',['user'=>$user->id])}}" id="formUpdate" method="GET"></form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>

        function resetPassword(user){

            let resetBtn = $('#reset');

                resetBtn.toggle();

                resetBtn.after("<i class=\"fas fa-spinner fa-lg fa-fw\"></i>");

            $.ajax({
                headers:{
                    "X-CSRF-TOKEN": $('meta[name="csfr-token"]').attr('content'),
                },
                url:"{{route('user.SuperAdmin.reset')}}",
                method:"POST",
                contentType:"application/json",
                data:JSON.stringify({id:user}),

            }).done(function(result){
                result = JSON.parse(result);
                isReset = result ['isReset'];
                if(isReset){
                    alert("{{__('The user password has been reset. The default password is ')}}" + result['newPassword']);
                    resetBtn.next().remove();
                    resetBtn.toggle();
                }else{
                    alert("{{__('Enable to reset the user password, please try again.')}}");
                }
            }).fail(function(xhr,status,error){
                let errorMessage = "{{__('Error : Enable to reset user password, ')}}" ;
                alert(errorMessage + xhr.statusText);
            });
        }

    </script>
@endsection
