@extends('layouts.admin')

@section('content')
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Total Products</div>
                    <div class="display-6">{{ $totalProducts }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">In Stock</div>
                    <div class="display-6 text-success">{{ $inStock }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Out of Stock</div>
                    <div class="display-6 text-danger">{{ $outOfStock }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
