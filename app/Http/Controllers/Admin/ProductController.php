<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->input('q');
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('brand', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%")
                        ->orWhere('product_code', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'filters' => [
                'q' => $request->input('q'),
            ],
        ]);
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'product_code' => ['nullable', 'string', 'max:255', 'unique:products,product_code'],
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

        $product = Product::create([
            'category_id' => $data['category_id'],
            'product_code' => ($data['product_code'] ?? null) ?: Product::generateCode(),
            'brand' => $data['brand'],
            'model' => $data['model'],
            'cpu' => $data['cpu'] ?? null,
            'ram' => $data['ram'] ?? null,
            'storage' => $data['storage'] ?? null,
            'gpu' => $data['gpu'] ?? null,
            'display' => $data['display'] ?? null,
            'color' => $data['color'] ?? null,
            'condition' => $data['condition'] ?? 'New',
            'warranty' => $data['warranty'] ?? null,
            'country' => $data['country'] ?? null,
            'price' => $data['price'],
            'stock' => $data['stock'],
            'description' => $data['description'] ?? null,
            'status' => $request->boolean('status'),
        ]);

        $this->storeImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'product_code' => ['required', 'string', 'max:255', 'unique:products,product_code,'.$product->id],
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

        $product->update([
            'category_id' => $data['category_id'],
            'product_code' => $data['product_code'],
            'brand' => $data['brand'],
            'model' => $data['model'],
            'cpu' => $data['cpu'] ?? null,
            'ram' => $data['ram'] ?? null,
            'storage' => $data['storage'] ?? null,
            'gpu' => $data['gpu'] ?? null,
            'display' => $data['display'] ?? null,
            'color' => $data['color'] ?? null,
            'condition' => $data['condition'] ?? 'New',
            'warranty' => $data['warranty'] ?? null,
            'country' => $data['country'] ?? null,
            'price' => $data['price'],
            'stock' => $data['stock'],
            'description' => $data['description'] ?? null,
            'status' => $request->boolean('status'),
        ]);

        $this->storeImages($request, $product);

        return redirect()->route('admin.products.edit', $product)->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    public function destroyImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            abort(404);
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image removed.');
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
