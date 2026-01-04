<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();

        $productsQuery = Product::query()
            ->with('images')
            ->where('status', true)
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category_id', $request->input('category'));
            })
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->input('q');
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('brand', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%")
                        ->orWhere('product_code', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc');

        $products = $productsQuery->paginate(12)->withQueryString();

        return view('catalog.index', [
            'categories' => $categories,
            'products' => $products,
            'filters' => [
                'category' => $request->input('category'),
                'q' => $request->input('q'),
            ],
        ]);
    }

    public function show(Product $product)
    {
        $product->load(['images', 'category']);

        abort_unless($product->status, 404);

        return view('catalog.show', [
            'product' => $product,
        ]);
    }
}
