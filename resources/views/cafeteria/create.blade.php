<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Menu Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                
                <form action="{{ route('cafeteria.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-bold">Item Name</label>
                        <input type="text" name="name" class="w-full border rounded px-3 py-2" placeholder="e.g. Cheese Burger" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold">Category</label>
                        <select name="category" class="w-full border rounded px-3 py-2">
                            <option>Fast Food</option>
                            <option>Drinks</option>
                            <option>Snacks</option>
                            <option>Healthy</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold">Price ($)</label>
                        <input type="number" step="0.01" name="price" class="w-full border rounded px-3 py-2" placeholder="5.99" required>
                    </div>

                    <button type="submit" class="bg-green-500 text-black font-bold px-6 py-2 rounded hover:bg-green-600">
                        Save Item
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>