<nav class="navbar navbar-expand-lg navbar-light border-bottom">
    <div class="container">
        <a class="navbar-brand" href="#">
            @if (\App\Models\Setting::find(1)->logo)
                <img src="{{ asset('storage/'. \App\Models\Setting::find(1)->logo) }}" alt="">
            @else 
                Qurann
            @endif
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ Request::routeIs('index-page') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('index-page') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('index-page') }}#pricing">Prices</a>
                </li>
                <li class="nav-item {{ Request::routeIs('login') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <div class="nav-buttons d-sm-none d-block">
                        <a href="{{ route('register') }}" class="main-btn">Join now!</a>
                    </div>
                </li>
                
            </ul>
        
        </div>
        <div class="float-right nav-buttons d-sm-block d-none">
            <a href="{{ route('register') }}" class="main-btn">Join now!</a>
        </div>
        <div class="clearfix d-sm-block d-none"></div>
    </div>
</nav>
