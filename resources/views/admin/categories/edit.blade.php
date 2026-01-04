@extends('layouts.admin')

@section('content')
    <h1 class="h4 mb-3">Edit Category</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="{{ route('admin.categories.update', $category) }}">
                @csrf
                @method('put')
                @include('admin.categories.form', ['category' => $category])
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
