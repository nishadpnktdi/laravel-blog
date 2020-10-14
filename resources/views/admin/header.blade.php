<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="">
            <img src="{{ asset('admin/images/logo.svg') }}" alt="logo" /> </a>
        <a class="navbar-brand brand-logo-mini" href="">
            <img src="{{ asset('admin/images/logo-mini.svg') }}" alt="logo" /> </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav">
            <li class="nav-item dropdown language-dropdown">
                <a class="nav-link dropdown-toggle px-2 d-flex align-items-center" id="LanguageDropdown" href="#"
                    data-toggle="dropdown" aria-expanded="false">
                    <div class="d-inline-flex mr-0 mr-md-3">
                        <div class="flag-icon-holder">
                            <i class="flag-icon flag-icon-us"></i>
                        </div>
                    </div>
                    <span class="profile-text font-weight-medium d-none d-md-block">English</span>
                </a>
                <div class="dropdown-menu dropdown-menu-left navbar-dropdown py-2" aria-labelledby="LanguageDropdown">
                    <a class="dropdown-item">
                        <div class="flag-icon-holder">
                            <i class="flag-icon flag-icon-us"></i>
                        </div>English
                    </a>
                    <a class="dropdown-item">
                        <div class="flag-icon-holder">
                            <i class="flag-icon flag-icon-fr"></i>
                        </div>French
                    </a>
                    <a class="dropdown-item">
                        <div class="flag-icon-holder">
                            <i class="flag-icon flag-icon-ae"></i>
                        </div>Arabic
                    </a>
                    <a class="dropdown-item">
                        <div class="flag-icon-holder">
                            <i class="flag-icon flag-icon-ru"></i>
                        </div>Russian
                    </a>
                </div>
            </li>
        </ul>
        <form class="ml-auto search-form d-none d-md-block" action="#">
            <div class="form-group">
                <input type="search" class="form-control" placeholder="Search Here">
            </div>
        </form>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                @if(auth()->user()->role == 'admin')
                    <a class="nav-link count-indicator" id="messageDropdown" href="#" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="mdi mdi-bell-outline"></i>
                        @if($notifications->count() > 0)
                        <span class="count">{{$notifications->count()}}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0"
                        aria-labelledby="messageDropdown">
                        <a href="#" class="dropdown-item py-3">
                            @if(isset($notifications))
                            @forelse($notifications as $notification)
                            <p class="mb-0 font-weight-medium float-left">You have {{$notifications->count()}} notifications </p>
                                    @if($loop->last)
                                        <span class="badge badge-pill badge-primary float-right" id="mark-all">Mark all as read</span>
                                    @endif
                        </a>

                        <div class="dropdown-divider"></div>
                        <div class="dropdown-item preview-item">

                            <div class="preview-thumbnail">
                                <img src="{{ asset('admin/images/faces/face10.jpg') }}"
                                    alt="image" class="img-sm profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow py-2">
                                <p class="preview-subject ellipsis font-weight-medium text-dark">New user created</p>
                                <p class="font-weight-light small-text">
                                    {{ $notification->data['name'] }} </p>
                                <p class="font-weight-light small-text">
                                    {{ $notification->data['email'] }}</p>
                            </div>
                            <span>
                                <a href="#" class="mark-as-read" data-id={{ $notification->id }}><i class="mdi mdi-check text-success"></i></a>
                            </span>
                        </div>

                    @empty
                        <p class="mb-0 font-weight-medium float-left">No new notifications</p>
                        <p class="mb-0 font-weight-medium float-left"></p>
                        <a class="dropdown-item preview-item"></a>
                @endforelse
                @endif

    </div>
    </li>
    @endif

    <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
        <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
            <img class="img-xs rounded-circle" src="{{ Auth::user()->profile_photo_url }}" alt="Profile image"> </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
            <div class="dropdown-header text-center">
                <img class="img-md rounded-circle" src="{{ Auth::user()->profile_photo_url }}" alt="Profile image">
                <p class="mb-1 mt-3 font-weight-semibold">{{ Auth::user()->name }}</p>
                <p class="font-weight-light text-muted mb-0">{{ Auth::user()->email }}</p>
            </div>
            <a href="/user/profile" class="dropdown-item">My Profile<i class="dropdown-item-icon ti-dashboard"></i></a>
            <a class="dropdown-item">Messages<i class="dropdown-item-icon ti-comment-alt"></i></a>
            <a class="dropdown-item">Activity<i class="dropdown-item-icon ti-location-arrow"></i></a>
            <a class="dropdown-item">FAQ<i class="dropdown-item-icon ti-help-alt"></i></a>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                {{ __('Sign Out') }}
                <i class="dropdown-item-icon ti-power-off"></i>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                style="display: none;">
                @csrf
            </form>
        </div>
    </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
        data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
    </button>
    </div>
</nav>
