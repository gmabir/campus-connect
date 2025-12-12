<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report a Lost Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                
                <form action="{{ route('lost-found.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-bold text-black">Item Name</label>
                        <input type="text" name="item_name" class="w-full border rounded px-3 py-2" placeholder="e.g. Blue Wallet" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-black">Description (Location, color, etc.)</label>
                        <textarea name="description" rows="3" class="w-full border rounded px-3 py-2" placeholder="Left in Room 302..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-black">Contact Phone</label>
                        <input type="text" name="contact_phone" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <button type="submit" class="bg-red-600 text-black font-bold px-6 py-2 rounded hover:text-white transition">
                        Submit Report
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
