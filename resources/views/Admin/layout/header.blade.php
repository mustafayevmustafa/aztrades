<header id="page-topbar">
    <div class="navbar-header">
        <div class="container-fluid">
            <div class="float-right d-flex align-items-center" id="lang-flags">
                <div class="dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="flag-icon flag-icon-{{(session()->get('locale') ?? 'ge') == 'ge' ? 'ge' : session()->get('locale')}}"></span> {{ucfirst(session()->get('locale') ?? 'ge')}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @foreach(config('app.locales') as $lang => $language)
                            <a class="dropdown-item" href="{{route('locale', $lang)}}"><span class="flag-icon flag-icon-{{$lang}}"></span> {{$language}}</a>
                        @endforeach
                    </div>
                </div>
                <div class="dropdown d-none d-lg-inline-block ml-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="mdi mdi-fullscreen"></i>
                    </button>
                </div>
            </div>
            <div>
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="/Admin" class="logo logo-dark">
                        <span class="logo-sm">
{{--                            <img class="d-inline" style="filter: brightness(0) invert(1);" src="{{ asset('') }}" alt="" height="40">--}}
                        </span>
                        <span class="logo-lg">
{{--                            <img class="d-inline" style="filter: brightness(0) invert(1);" src="{{ asset('') }}" alt="" height="40">--}}
                        </span>
                    </a>

                    <a href="/Admin" class="logo logo-light">
                        <span class="logo-sm">
{{--                            <img class="d-inline" style="filter: brightness(0) invert(1);" src="{{ asset('') }}" alt="" height="40">--}}
                        </span>
                        <span class="logo-lg">
{{--                            <img class="d-inline" style="filter: brightness(0) invert(1);" src="{{ asset('') }}" alt="" height="40">--}}
                        </span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect" id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

            </div>
        </div>
    </div>
</header>
