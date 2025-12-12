<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post Housing Advertisement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                
                <form action="{{ route('housing.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-bold text-black">Title (e.g. Roommate Needed)</label>
                        <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-bold text-black">Rent Amount ($)</label>
                            <input type="number" name="rent_amount" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block font-bold text-black">Contact Phone</label>
                            <input type="text" name="contact_phone" class="w-full border rounded px-3 py-2" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-black">Location / Address</label>
                        <input type="text" name="location" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-black">Description</label>
                        <textarea name="description" rows="3" class="w-full border rounded px-3 py-2" required></textarea>
                    </div>

                    <button type="submit" class="bg-blue-600 text-black font-bold px-6 py-2 rounded hover:bg-blue-500 hover:text-white transition">
                        Post Ad
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>