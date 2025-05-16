<x-layouts.app :title="__('Add New Product')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Add New Product</flux:heading>
        <flux:subheading size="lg" class="mb-6">Create a new product</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Input for product name -->
        <flux:input label="Name" name="name" value="{{ old('name') }}" required class="mb-3" />

        <!-- Category Dropdown -->
        <div class="mb-3">
            <label for="product_category_id" class="block text-white font-semibold mb-2">
                Category
            </label>
            <select name="product_category_id" id="product_category_id" required class="w-full p-2 rounded-md bg-zinc-700 text-white appearance-none">
                <option value="" disabled {{ old('product_category_id') ? '' : 'selected' }}>Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Textarea for product description -->
        <flux:textarea label="Description" name="description" required class="mb-3">
            {{ old('description') }}
        </flux:textarea>

        <!-- Input for product price -->
        <flux:input label="Price" name="price" type="number" value="{{ old('price') }}" required class="mb-3" />

        <!-- Product Stock -->
        <flux:input label="Stock" name="stock" type="number" value="{{ old('stock') }}" class="mb-3" />

        <!-- Toggle Input Type: File or URL -->
        <div class="mb-3">
            <label class="block font-semibold mb-2 text-white">Image Source</label>
            <div class="flex items-center space-x-4">
                <label class="text-white">
                    <input type="radio" name="image_source" value="file" {{ old('image_source', 'file') == 'file' ? 'checked' : '' }} onchange="toggleImageInput()"> Upload File
                </label>
                <label class="text-white">
                    <input type="radio" name="image_source" value="url" {{ old('image_source') == 'url' ? 'checked' : '' }} onchange="toggleImageInput()"> Use URL
                </label>
            </div>
        </div>

        <!-- File input for image upload -->
        <div id="image-file-input" class="mb-3">
            <flux:input label="Image (Upload)" name="image_file" type="file" />
        </div>

        <!-- URL input for image -->
        <div id="image-url-input" class="mb-3 hidden">
            <flux:input label="Image (URL)" name="image_url" type="text" value="{{ old('image_url') }}" />
        </div>

        <div class="mt-4">
            <flux:button type="submit" variant="primary">Save</flux:button>
            <flux:link href="{{ route('products.index') }}" variant="ghost" class="ml-3">Cancel</flux:link>
        </div>
    </form>

    <script>
        function toggleImageInput() {
            const selected = document.querySelector('input[name="image_source"]:checked').value;
            document.getElementById('image-file-input').classList.toggle('hidden', selected !== 'file');
            document.getElementById('image-url-input').classList.toggle('hidden', selected !== 'url');
        }

        // Ensure toggle is applied on page load if validation fails
        document.addEventListener('DOMContentLoaded', toggleImageInput);
    </script>
</x-layouts.app>
