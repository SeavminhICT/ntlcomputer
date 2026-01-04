<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'images'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->input('q');
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('brand', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%")
                        ->orWhere('product_code', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);

        $product = Product::create([
            ...$data,
            'product_code' => ($data['product_code'] ?? null) ?: Product::generateCode(),
            'status' => $request->boolean('status'),
        ]);

        $this->storeImages($request, $product);

        return response()->json($product->load('images'), 201);
    }

    public function show(Product $product)
    {
        return response()->json($product->load(['category', 'images']));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request, $product->id);

        $product->update([
            ...$data,
            'status' => $request->boolean('status'),
        ]);

        $this->storeImages($request, $product);

        return response()->json($product->load('images'));
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return response()->json(['message' => 'Deleted.']);
    }

    public function destroyImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['message' => 'Image deleted.']);
    }

    private function validateProduct(Request $request, ?int $productId = null): array
    {
        $productCodeRule = $productId
            ? ['required', 'string', 'max:255', 'unique:products,product_code,'.$productId]
            : ['nullable', 'string', 'max:255', 'unique:products,product_code'];

        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'product_code' => $productCodeRule,
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'cpu' => ['nullable', 'string', 'max:255'],
            'ram' => ['nullable', 'string', 'max:255'],
            'storage' => ['nullable', 'string', 'max:255'],
            'gpu' => ['nullable', 'string', 'max:255'],
            'display' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:255'],
            'condition' => ['nullable', 'string', 'max:255'],
            'warranty' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
            'images.*' => ['nullable', 'image', 'max:2048'],
        ], $this->uploadMessages());
    }

    private function storeImages(Request $request, Product $product): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        foreach ($request->file('images') as $file) {
            $path = $file->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
            ]);
        }
    }

    private function uploadMessages(): array
    {
        $limit = ini_get('upload_max_filesize') ?: '2M';

        return [
            'images.*.uploaded' => "Image upload failed. Check PHP upload limits (upload_max_filesize: {$limit}).",
        ];
    }
}
