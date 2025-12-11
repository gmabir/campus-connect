<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report Maintenance Issue') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('maintenance.store') }}" method="POST">
                    @csrf <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Area / Location:</label>
                        <input type="text" name="area" class="border rounded w-full py-2 px-3 text-gray-700" placeholder="e.g. Library 2nd Floor" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Issue Description:</label>
                        <textarea name="description" rows="4" class="border rounded w-full py-2 px-3 text-gray-700" placeholder="Describe what is broken..." required></textarea>
                    </div>

                    <button type="submit" class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-600 font-bold">
                        Submit Report
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>