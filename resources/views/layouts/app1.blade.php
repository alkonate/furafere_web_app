<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FERE') }}</title>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/jquery.typeahead.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" >

    <script>
        window.laravel = {!!
            json_encode(array(
                'user_id' => (Auth()->check()) ? auth()->user()->id : null,
            ))
        !!}
    </script>

    @yield('header')


  </head>
  <body>
         @include('inc.nav')

         <main class="container-fluid">
                @include('inc.warning')
                @yield('content')
                </main>

              @include('inc.footer')
              <div>{{config('app.locale')}}</div>
        </div>

          <!-- Scripts -->
          {{-- all front-end language --}}
        @if (config('app.locale') == 'fr')
            <script src="{{asset('js/lang/fr.js')}}"></script>
        @else
            <script src="{{asset('js/lang/en.js')}}"></script>
        @endif
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{asset('js/jquery.typeahead.min.js')}}"></script>
        {{-- all of my helper functions reusable --}}
        <script src="{{asset('js/helpers.js')}}"></script>
        {{-- notification bell --}}
        <script src="{{asset('js/notification.js')}}"></script>
        {{-- realtime search search --}}
        <script src="{{asset('js/realTimeSearch.js')}}"></script>

        {{-- some others scripts --}}
             @yield('script')
  </body>
</html>
