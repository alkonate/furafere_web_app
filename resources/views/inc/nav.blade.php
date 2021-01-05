@auth
<nav class="navbar navbar-expand-md navbar-light bg-dark shadow fixed-top">
    <a class="navbar-brand text-white font-weight-bold" href="{{ route('home') }}">
        <span class="h4">{{ config('app.name', 'FURAféré') }}</span>
    </a>
    <div class="container">

        <div class="dropdown notificationContainer">
            <a id="dlabel" class="center notification icon btn btn-default" onclick="deleteAllNotificationsOfUser();" role="button" data-toggle="dropdown" data-target="#" href="#">
                <i class="fas fa-bell fa-lg bell" aria-hidden="true"></i>
                <span class="notification-number">{{auth()->user()->unreadNotifications->count()}}</span>
            </a>
            <ul class="dropdown-menu notifications" role="menu" aria-labelledby="dlabel">
                <div class="notification-heading"><h4 class="menu-title ml-2">Notifications</h4></div>
                <li class="divider"></li>
                <div class="notifications-wrapper overflow-auto">

                    @forelse (auth()->user()->unreadNotifications as $notification)

                        {{-- notif almost out of stock!!! --}}

                        {{-- notif new user account --}}

                        {{-- notif new product added --}}
                        <a href="#" class="content">
                            <div class="notification-item row">
                                <img src="{{url($notification->data['product_thumbnail'])}}" alt="" class="mr-2">
                                <h4 class="item-title">{{$notification->data['product_name']}}</h4>
                                <p class="item-info">{{__('New product created')}}</p>
                            </div>
                        </a>
                    @empty
                    <a href="#" class="content no-notification">
                        <div class="notification-item">
                            <h4 class="item-title">{{__('Zero')}}</h4>
                            <p class="item-info">{{__('There is no notification')}}</p>
                        </div>
                    </a>
                    @endforelse
                </div>

            </ul>
        </div>

        {{-- search realtime --}}
        <form method="GET" action="" class="search" autocomplete="off">
          <div class="typeahead__container">
              <div class="typeahead__field">
                  <div class="typeahead__query">
                      <input type="text" name="search" class="js-typeahead" placeholder="{{__('Eg : Product')}}">
                  </div>
                  <div class="typeahead__button">
                      <button type="submit"><span class="typeahead__search-icon"></span></button>
                  </div>
              </div>
          </div>
        </form>

        <button class="toggler navbar-toggler d-lg-none border" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="collapsibleNavId">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
              <a class="nav-link text-white" href="@if(Auth::user()->hasRoles(['superAdmin','admin'])) {{route('dashboard')}} @else {{route('home')}} @endif"><i class="fas fa-clinic-medical fa-sm fa-fw"></i>{{__('Home')}}<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Products</a>
              <div class="dropdown-menu" aria-labelledby="dropdownId">
                <a class="dropdown-item" href="#">Stock</a>
                <a class="dropdown-item" href="#">New product</a>
              </div>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sells</a>
              <div class="dropdown-menu" aria-labelledby="dropdownId">
                <a class="dropdown-item d-5" href="#">Sell</a>
                <a class="dropdown-item" href="#">Order</a>
              </div>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset(Auth::user()->getImage())}}" class="profil-image" alt="">{{Auth::user()->username}}</a>
              <div class="dropdown-menu" aria-labelledby="dropdownId">
                <a class="dropdown-item" href="{{route('user.profil',['user'=>Auth::user()->id])}}">{{ __('Account') }}</a>
                @if(Auth::user()->hasRoles(['admin']))
                     <a class="dropdown-item" href="#">{{ __('Account managing') }}</a>
                @endif
                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </div>
            </li>
          </ul>
        </div>
    </div>

  </nav>
@endauth
