<div class="row g-3">
    <div class="col-12 col-md-4">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select" required>
            <option value="">Select</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ (int) old('category_id', $product?->category_id ?? '') === $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">Product Code</label>
        <input type="text" name="product_code" class="form-control"
            value="{{ old('product_code', $product?->product_code ?? '') }}">
        <div class="form-text">Leave blank to auto-generate.</div>
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">Brand</label>
        <input type="text" name="brand" class="form-control" value="{{ old('brand', $product?->brand ?? '') }}" required>
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">Model</label>
        <input type="text" name="model" class="form-control" value="{{ old('model', $product?->model ?? '') }}" required>
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">CPU</label>
        <input type="text" name="cpu" class="form-control" value="{{ old('cpu', $product?->cpu ?? '') }}">
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">RAM</label>
        <input type="text" name="ram" class="form-control" value="{{ old('ram', $product?->ram ?? '') }}">
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">Storage</label>
        <input type="text" name="storage" class="form-control" value="{{ old('storage', $product?->storage ?? '') }}">
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">GPU</label>
        <input type="text" name="gpu" class="form-control" value="{{ old('gpu', $product?->gpu ?? '') }}">
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">Display</label>
        <input type="text" name="display" class="form-control" value="{{ old('display', $product?->display ?? '') }}">
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">Color</label>
        <input type="text" name="color" class="form-control" value="{{ old('color', $product?->color ?? '') }}">
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">Condition</label>
        <input type="text" name="condition" class="form-control" value="{{ old('condition', $product?->condition ?? 'New') }}">
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">Warranty</label>
        <input type="text" name="warranty" class="form-control" value="{{ old('warranty', $product?->warranty ?? '') }}">
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">Country</label>
        <input type="text" name="country" class="form-control" value="{{ old('country', $product?->country ?? '') }}">
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">Price (USD)</label>
        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product?->price ?? '') }}" required>
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label">Stock Quantity</label>
        <input type="number" name="stock" class="form-control" value="{{ old('stock', $product?->stock ?? 0) }}" required>
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="4" class="form-control">{{ old('description', $product?->description ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Upload Images</label>
        <input type="file" name="images[]" class="form-control" multiple>
        <div class="form-text">
            PNG/JPG up to 2MB each. Server upload_max_filesize: {{ ini_get('upload_max_filesize') }}.
        </div>
    </div>
    <div class="col-12">
        <div class="form-check">
            <input type="hidden" name="status" value="0">
            <input class="form-check-input" type="checkbox" name="status" id="status" value="1"
                {{ old('status', $product?->status ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="status">Active</label>
        </div>
    </div>
</div>
