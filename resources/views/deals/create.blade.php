<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post a New Deal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('deals.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-black font-bold mb-2">Deal Title</label>
                        <input type="text" name="title" class="w-full border rounded px-3 py-2" placeholder="e.g. 50% Off Coffee" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-black font-bold mb-2">Description</label>
                        <textarea name="description" class="w-full border rounded px-3 py-2" rows="3" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-black font-bold mb-2">Promo Code (Optional)</label>
                        <input type="text" name="promo_code" class="w-full border rounded px-3 py-2" placeholder="e.g. STUDENT50">
                    </div>

                    <button type="submit" class="bg-green-500 text-black font-bold px-4 py-2 rounded hover:bg-green-400 border border-green-600">
                        Post Deal
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>