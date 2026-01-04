<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::orderBy('name')->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
        ]);

        $category = Category::create([
            'name' => $data['name'],
            'status' => $request->boolean('status'),
        ]);

        return response()->json($category, 201);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
        ]);

        $category->update([
            'name' => $data['name'],
            'status' => $request->boolean('status'),
        ]);

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Deleted.']);
    }
}
