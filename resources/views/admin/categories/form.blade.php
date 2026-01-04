<div class="mb-3">
    <label class="form-label">Category Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $category?->name ?? '') }}" required>
</div>
<div class="form-check mb-3">
    <input type="hidden" name="status" value="0">
    <input class="form-check-input" type="checkbox" name="status" id="status" value="1"
        {{ old('status', $category?->status ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="status">Enabled</label>
</div>
