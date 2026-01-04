<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - {{ config('store.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --admin-accent: #0ea5e9;
            --admin-bg: #f3f4f6;
        }
        body {
            background: var(--admin-bg);
        }
        .admin-header {
            background: #111827;
            color: #fff;
        }
        .nav-link.active {
            font-weight: 600;
            color: var(--admin-accent);
        }
    </style>
</head>
<body>
    <header class="admin-header py-3">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="fw-bold">Admin Panel · {{ config('store.name') }}</div>
            <form method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn btn-sm btn-outline-light">Logout</button>
            </form>
        </div>
    </header>
    <nav class="bg-white border-bottom">
        <div class="container d-flex gap-3 py-2">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Categories</a>
            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">Products</a>
            <a class="nav-link {{ request()->routeIs('admin.qr.*') ? 'active' : '' }}" href="{{ route('admin.qr.show') }}">QR Code</a>
        </div>
    </nav>

    <main class="container my-4">
        @include('partials.flash')
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
