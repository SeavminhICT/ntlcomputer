@extends('layouts.catalog')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-8">
            <form method="get" action="{{ route('catalog.index') }}" class="d-flex gap-2">
                <input type="text" name="q" class="form-control" placeholder="Search by brand, model, or code" value="{{ $filters['q'] ?? '' }}">
                <button class="btn btn-dark">Search</button>
            </form>
        </div>
        <div class="col-12 col-md-4">
            <form method="get" action="{{ route('catalog.index') }}">
                <input type="hidden" name="q" value="{{ $filters['q'] ?? '' }}">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ (string) $category->id === (string) ($filters['category'] ?? '') ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    @if ($product->images->first())
                        <img src="{{ asset('storage/'.$product->images->first()->image_path) }}" class="card-img-top" alt="{{ $product->brand }} {{ $product->model }}">
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light text-muted">
                            No Image
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h2 class="h6 mb-1">{{ $product->brand }} {{ $product->model }}</h2>
                                <div class="text-muted small">{{ $product->product_code }}</div>
                            </div>
                            <div class="price-tag">${{ number_format($product->price, 2) }}</div>
                        </div>
                        <div class="d-flex flex-wrap gap-2 my-3">
                            @if ($product->cpu)<span class="spec-chip">{{ $product->cpu }}</span>@endif
                            @if ($product->ram)<span class="spec-chip">{{ $product->ram }}</span>@endif
                            @if ($product->storage)<span class="spec-chip">{{ $product->storage }}</span>@endif
                        </div>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                            </span>
                            <a href="{{ route('catalog.show', $product) }}" class="btn btn-outline-dark btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">No products found.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endsection
