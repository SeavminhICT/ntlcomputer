@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add Category</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                <span class="badge {{ $category->status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $category->status ? 'Enabled' : 'Disabled' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form class="d-inline" method="post" action="{{ route('admin.categories.destroy', $category) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this category?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $categories->links() }}
    </div>
@endsection
