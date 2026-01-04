@extends('layouts.admin')

@section('content')
    <div class="row g-4 align-items-center">
        <div class="col-12 col-md-6">
            <h1 class="h4 mb-2">QR Code</h1>
            <p class="text-muted">Scan to open the public catalog. Use this QR on menus, counters, or posters.</p>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.qr.download') }}" class="btn btn-primary">Download PNG</a>
                <a href="{{ $catalogUrl }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">Open Catalog</a>
            </div>
        </div>
        <div class="col-12 col-md-6 text-center">
            <div class="bg-white p-3 d-inline-block rounded shadow-sm">
                <img src="{{ $qrPath }}" alt="Catalog QR Code" class="img-fluid" style="max-width: 240px;">
            </div>
        </div>
    </div>
@endsection
