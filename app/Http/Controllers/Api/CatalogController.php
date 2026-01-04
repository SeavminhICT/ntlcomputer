<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogController extends Controller
{
    public function categories()
    {
        $categories = Category::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return response()->json($categories);
    }

    public function products(Request $request)
    {
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

        $products = $productsQuery->paginate(12)->through(function (Product $product) {
            return $this->mapProduct($product);
        });

        return response()->json($products);
    }

    public function show(Product $product)
    {
        if (! $product->status) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        $product->load(['images', 'category']);

        return response()->json($this->mapProduct($product, true));
    }

    private function mapProduct(Product $product, bool $includeCategory = false): array
    {
        $data = [
            'id' => $product->id,
            'category_id' => $product->category_id,
            'product_code' => $product->product_code,
            'brand' => $product->brand,
            'model' => $product->model,
            'cpu' => $product->cpu,
            'ram' => $product->ram,
            'storage' => $product->storage,
            'gpu' => $product->gpu,
            'display' => $product->display,
            'color' => $product->color,
            'condition' => $product->condition,
            'warranty' => $product->warranty,
            'country' => $product->country,
            'price' => $product->price,
            'stock' => $product->stock,
            'description' => $product->description,
            'status' => $product->status,
            'images' => $product->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => Storage::url($image->image_path),
                ];
            })->values(),
        ];

        if ($includeCategory) {
            $data['category'] = $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
            ] : null;
        }

        return $data;
    }
}
