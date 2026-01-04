<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('store.name') }} - Catalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-primary: #0b1f3a;
            --brand-accent: #f59e0b;
            --brand-bg: #f8f9fb;
        }
        body {
            background: var(--brand-bg);
        }
        .store-hero {
            background: linear-gradient(135deg, #0b1f3a 0%, #0f2f57 55%, #143d73 100%);
            color: #fff;
        }
        .store-logo {
            max-height: 56px;
        }
        .spec-chip {
            background: #eef2f7;
            border-radius: 999px;
            padding: 0.2rem 0.75rem;
            font-size: 0.75rem;
            color: #1f2937;
        }
        .price-tag {
            color: var(--brand-primary);
            font-weight: 700;
        }
        .card-img-top {
            object-fit: cover;
            height: 180px;
        }
    </style>
</head>
<body>
    <header class="store-hero py-4">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ config('store.logo') }}" alt="Store logo" class="store-logo" onerror="this.style.display='none'">
                <div>
                    <h1 class="h4 mb-1">{{ config('store.name') }}</h1>
                    <p class="mb-0 text-white-50">Computer catalog - scan & browse</p>
                </div>
            </div>
            <div class="text-white-50 small">
                No login required · Updated live by staff
            </div>
        </div>
    </header>

    <main class="container my-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
