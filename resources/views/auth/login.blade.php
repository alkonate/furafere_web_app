<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" >
  </head>
  <body>
    <div class="container-fluid bg">
        <div class="row justify-content-between bg-dark">
            <div class="col-6 text-white">
                FURAféré
            </div>
            <div class="col-6 text-white align-items-center">
                @Copyright App version 1.0.0
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-8 col-sm-8 col-md-6 col-lg-4">
                <form class="form-container shadow bg-dark" action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="form-group">
                        <label for="exampleInputusername1" class="text-success">{{__('Username')}}</label>
                        <input type="username" name="username" class="form-control @error('username') is-invalid @enderror" id="exampleInputusername1" aria-describedby="usernameHelp" placeholder="Enter username">
                        <small id="usernameHelp" class="form-text text-muted">{{__('Insert your username')}}</small>
                        </div>
                        @error('username')
                           <div class="alert alert-warning alert-dismissible fade show" role="alert">
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                             </button>
                             <strong>{{$message}}</strong>
                           </div>

                           <script>
                             window.onload = function(){
                                 $(".alert").alert();
                             };
                           </script>
                        @enderror


                        <div class="form-group">
                        <label for="exampleInputPassword1" class="text-success">{{__('Password')}}</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" placeholder="Password">
                        <small id="usernameHelp" class="form-text text-muted">{{__('Insert your password')}}</small>
                        </div>
                        @error('password')
                           <div class="alert alert-warning alert-dismissible fade show" role="alert">
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                             </button>
                             <strong>{{$message}}</strong>
                           </div>

                           <script>
                             window.onload = function(){
                                 $(".alert").alert();
                             };
                           </script>
                        @enderror
                        <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label text-light" for="exampleCheck1">{{__('Remember me')}}</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">{{__('Login')}}</button>
                </form>
            </div>
          </div>
    </div>


    <footer>

    </footer>

</body>
</html>

