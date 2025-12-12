<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Request Lab/Teaching Materials') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                
                <form action="{{ route('resources.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-bold text-black">Item Needed</label>
                        <input type="text" name="item_needed" class="w-full border rounded px-3 py-2" placeholder="e.g. HDMI Cable" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-black">Quantity</label>
                        <input type="number" name="quantity" class="w-full border rounded px-3 py-2" value="1" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-black">Date Needed</label>
                        <input type="date" name="needed_date" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <button type="submit" class="bg-blue-600 text-black font-bold px-6 py-2 rounded hover:text-white transition">
                        Submit Request
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>