@extends('layouts.admin')

@section('content')
    <h1 class="h4 mb-3">Edit Product</h1>
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="post" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                @include('admin.products.form', ['product' => $product])
                <div class="mt-3">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    @if ($product->images->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h6">Product Images</h2>
                <div class="row g-3">
                    @foreach ($product->images as $image)
                        <div class="col-6 col-md-3 text-center">
                            <img src="{{ asset('storage/'.$image->image_path) }}" alt="Product image" class="img-fluid rounded">
                            <form method="post" action="{{ route('admin.products.images.destroy', [$product, $image]) }}" class="mt-2">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this image?')">Remove</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
