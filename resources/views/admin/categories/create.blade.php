@extends('layouts.admin')

@section('content')
    <h1 class="h4 mb-3">Add Category</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="{{ route('admin.categories.store') }}">
                @csrf
                @include('admin.categories.form', ['category' => null])
                <button class="btn btn-primary">Save</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
