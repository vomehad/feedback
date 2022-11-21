<header class="header-content">
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">

        <nav class="my-2 my-md-0 mr-md-3 nav-content">
            @auth
            <a class="btn btn-danger text-decoration-none"
               href="{{ route('logout') }}"
            >{{ __('message.auth.logout') }}</a>
            @endauth
        </nav>
    </div>

    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
            <h1 class="display-4 fw-normal">{{ $title }}</h1>
    </div>
</header>
