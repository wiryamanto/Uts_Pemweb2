<x-layouts.app :title="__('Categories')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Product Categories</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage your product categories</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if(session()->has('success'))
        <flux:badge color="lime" class="mb-3 w-full">{{ session('success') }}</flux:badge>
    @endif
    @if($errors->any())
        <flux:badge color="red" class="mb-3 w-full">{{ $errors->first() }}</flux:badge>
    @endif

    <div class="flex justify-between items-center mb-4">
        <div>
            <form action="{{ route('categories.index') }}" method="get">
                @csrf
                <flux:input icon="magnifying-glass" name="q" value="{{ $q }}" placeholder="Search Product Categories" />
            </form>
        </div>
        <div>
            <flux:link href="{{ route('categories.create') }}"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Add New Category
            </flux:link>
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg shadow bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Created At</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($categories as $key => $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $key + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $isUrl = filter_var($category->image, FILTER_VALIDATE_URL);
                            @endphp

                            @if($category->image && ($isUrl || Storage::exists($category->image)))
                                <img 
                                    src="{{ $isUrl ? $category->image : Storage::url($category->image) }}" 
                                    alt="{{ $category->name }}" 
                                    class="h-10 w-10 object-cover rounded"
                                >
                            @else
                                <div class="h-10 w-10 bg-gray-200 flex items-center justify-center rounded">
                                    <span class="text-gray-500 text-sm">N/A</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->slug }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $category->created_at }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down">Actions</flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="pencil" href="{{ route('categories.edit', $category->id) }}">Edit</flux:menu.item>
                                    <flux:menu.item icon="trash" variant="danger"
                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this category?')) document.getElementById('delete-form-{{ $category->id }}').submit();">
                                        Delete
                                    </flux:menu.item>
                                    <form id="delete-form-{{ $category->id }}"
                                        action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.app>
