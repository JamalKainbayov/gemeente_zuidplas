<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <!-- sitewide quick styles -->
    <style>
        :root{
            --gemeente-blue: #0b5ed7;
            --gemeente-dark: #0b4db0;
        }
        body {
            background: linear-gradient(180deg, #f6f9ff 0%, #ffffff 40%);
            min-height: 100vh;
            color: #2b2b2b;
            font-family: Nunito, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }
        .site-container {
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.2px;
            color: #fff;
        }
        .gov-ribbon {
            background: linear-gradient(90deg, var(--gemeente-blue), var(--gemeente-dark));
            color: #fff;
            padding: .325rem 0;
            font-size: .9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
        }
        .coa {
            width: 36px;
            height: 36px;
            display:inline-block;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        .footer {
            background: var(--gemeente-dark);
            color: #fff;
            padding: 1.25rem 0;
            margin-top: 3rem;
        }
        .skip-link {
            position: absolute;
            left: -999px;
            top: auto;
            width: 1px;
            height: 1px;
            overflow: hidden;
        }
        .skip-link:focus {
            left: 1rem;
            top: 1rem;
            width: auto;
            height: auto;
            padding: .5rem .75rem;
            background: #000;
            color: #fff;
            z-index: 9999;
            border-radius: .25rem;
        }
        .metric-card {
            min-height: 88px;
        }
        /* NAV improvements: clearer links, active state, responsive spacing */
        .navbar .nav-link {
            color: rgba(255,255,255,0.95);
            padding: .45rem .65rem;
            border-radius: .325rem;
            transition: background-color .15s ease, transform .12s ease;
        }
        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            background: rgba(255,255,255,0.06);
            text-decoration: none;
        }
        .navbar .nav-link.active {
            background: rgba(255,255,255,0.12);
            font-weight: 600;
            box-shadow: inset 0 -2px 0 rgba(255,255,255,0.08);
        }
        .nav-search {
            min-width: 220px;
            max-width: 360px;
        }
        .nav-badge {
            font-size: .68rem;
            padding: .25rem .5rem;
            margin-left: .35rem;
            vertical-align: text-bottom;
        }

        @media (max-width: 576px) {
            .site-container { padding-left: 0.5rem; padding-right: 0.5rem; }
        }
    </style>
</head>
<body>
<div id="app">
    <a class="skip-link" href="#maincontent">Skip to main content</a>

    <!-- small municipality ribbon -->
    <div class="gov-ribbon" role="banner" aria-hidden="false">
        <span class="coa" aria-hidden="true" title="Wapen van Gemeente Zuidplas"></span>
        <strong>Gemeente Zuidplas</strong> — Burgerzaken en meldingen
    </div>

    <!-- navbar: improved layout, search and admin badge -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm" role="navigation" aria-label="Hoofd navigatie">
        <div class="container site-container">
            <a class="navbar-brand d-flex align-items-center me-3" href="{{ url('/') }}">
                <span class="coa me-2" aria-hidden="true"></span>
                <span>Gemeente Zuidplas</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigatie">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left: primary links -->
                <ul class="navbar-nav me-auto mb-2 mb-md-0 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        {{-- safe complaints index link --}}
                        <a class="nav-link {{ request()->routeIs('complaints.*') ? 'active' : '' }}"
                           href="{{ Route::has('complaints.index') ? route('complaints.index') : url('/complaints') }}">
                            Meldingen
                        </a>
                    </li>
                    <li class="nav-item">
                        {{-- safe complaint create link --}}
                        <a class="nav-link {{ request()->routeIs('complaint.create') ? 'active' : '' }}"
                           href="{{ Route::has('complaint.create') ? route('complaint.create') : url('/complaints/create') }}">
                           Dien melding in
                        </a>
                    </li>
                    <li class="nav-item">
                        {{-- safe contact link --}}
                        <a class="nav-link"
                           href="{{ Route::has('contact') ? route('contact') : url('/contact') }}">
                           Contact
                        </a>
                    </li>
                </ul>

                <!-- Right: optional search + auth actions -->
                <div class="d-flex align-items-center gap-2">
                    <form class="d-none d-md-flex me-2"
                          action="{{ Route::has('complaints.index') ? route('complaints.index') : url('/complaints') }}"
                          method="GET" role="search" aria-label="Zoeken meldingen">
                        <div class="input-group nav-search">
                            <input name="q" value="{{ request('q') }}" class="form-control form-control-sm" type="search" placeholder="Zoeken meldingen..." aria-label="Zoeken meldingen">
                            <button class="btn btn-sm btn-light" type="submit" aria-label="Zoek"><i class="bi bi-search"></i></button>
                        </div>
                    </form>

                    <ul class="navbar-nav align-items-center">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ Route::has('login') ? route('login') : url('/login') }}">Login</a>
                            </li>
                            <li class="nav-item d-none d-md-block">
                                <a class="nav-link" href="{{ Route::has('register') ? route('register') : url('/register') }}">Registreren</a>
                            </li>
                        @else
                            @if(auth()->user()->is_admin)
                                <li class="nav-item d-flex align-items-center me-2">
                                    <a class="nav-link px-2"
                                       href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : url('/admin') }}">
                                        <i class="bi bi-gear-fill me-1" aria-hidden="true"></i>Admin
                                    </a>
                                    <span class="badge bg-warning text-dark nav-badge" title="Medewerker">Medewerker</span>
                                </li>
                            @endif

                            <li class="nav-item dropdown">
                                <a id="navbarUser" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-2" aria-hidden="true"></i>
                                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUser">
                                    <li class="dropdown-item-text small text-muted">
                                        {{ Auth::user()->email }}
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ Route::has('profile') ? route('profile') : url('/profile') }}">Profiel</a>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ Route::has('logout') ? route('logout') : url('/logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Uitloggen</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- main container -->
    <main id="maincontent" class="py-4" role="main" tabindex="-1">
        <div class="site-container">
            @yield('content')
        </div>
    </main>
</div>

<!-- footer -->
<footer class="footer" role="contentinfo">
    <div class="site-container d-flex flex-column flex-md-row justify-content-between align-items-start">
        <div>
            <strong>Gemeente Zuidplas</strong>
            <div class="small opacity-85">Postadres: Postbus 123, 2750 AA Zuidplas</div>
            <div class="small opacity-85">Bezoekadres: Raadhuisplein 1, 1234 AB</div>
            <div class="small opacity-85">Telefoon: 14 0182 | Email: gemeente@zuidplas.nl</div>
        </div>
        <div class="text-end small opacity-85 mt-3 mt-md-0">
            <div>&copy; {{ date('Y') }} Gemeente Zuidplas</div>
            <div><a href="#" class="text-white text-decoration-underline">Privacy &amp; cookieverklaring</a></div>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
