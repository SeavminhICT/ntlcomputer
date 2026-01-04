@extends('layouts.admin')

@section('content')
    <h1 class="h4 mb-3">Add Product</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                @include('admin.products.form', ['product' => null])
                <div class="mt-3">
                    <button class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
