@extends('layouts.catalog')

@section('content')
    <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary mb-3">&larr; Back to catalog</a>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if ($product->images->count())
                        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($product->images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/'.$image->image_path) }}" class="d-block w-100" alt="{{ $product->brand }} {{ $product->model }}">
                                    </div>
                                @endforeach
                            </div>
                            @if ($product->images->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="text-center text-muted py-5">No images available</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <h1 class="h4">{{ $product->brand }} {{ $product->model }}</h1>
            <p class="text-muted">Product Code: {{ $product->product_code }}</p>
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="price-tag h4 mb-0">${{ number_format($product->price, 2) }}</div>
                <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                </span>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h2 class="h6 mb-3">Specifications</h2>
                    <div class="row g-2 small">
                        <div class="col-6"><strong>Category:</strong> {{ $product->category?->name }}</div>
                        <div class="col-6"><strong>CPU:</strong> {{ $product->cpu ?? '—' }}</div>
                        <div class="col-6"><strong>RAM:</strong> {{ $product->ram ?? '—' }}</div>
                        <div class="col-6"><strong>Storage:</strong> {{ $product->storage ?? '—' }}</div>
                        <div class="col-6"><strong>GPU:</strong> {{ $product->gpu ?? '—' }}</div>
                        <div class="col-6"><strong>Display:</strong> {{ $product->display ?? '—' }}</div>
                        <div class="col-6"><strong>Color:</strong> {{ $product->color ?? '—' }}</div>
                        <div class="col-6"><strong>Condition:</strong> {{ $product->condition ?? '—' }}</div>
                        <div class="col-6"><strong>Warranty:</strong> {{ $product->warranty ?? '—' }}</div>
                        <div class="col-6"><strong>Country:</strong> {{ $product->country ?? '—' }}</div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h6">Description</h2>
                    <p class="text-muted mb-0">{{ $product->description ?? 'No description provided.' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
