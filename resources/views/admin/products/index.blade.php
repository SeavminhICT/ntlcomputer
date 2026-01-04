@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Products</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
    </div>

    <form class="mb-3" method="get" action="{{ route('admin.products.index') }}">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search by brand, model, code" value="{{ $filters['q'] ?? '' }}">
            <button class="btn btn-outline-secondary">Search</button>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->product_code }}</td>
                            <td>
                                <div class="fw-semibold">{{ $product->brand }} {{ $product->model }}</div>
                                <div class="text-muted small">{{ $product->cpu }} · {{ $product->ram }} · {{ $product->storage }}</div>
                            </td>
                            <td>{{ $product->category?->name }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <span class="badge {{ $product->status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $product->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form class="d-inline" method="post" action="{{ route('admin.products.destroy', $product) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>
@endsection
