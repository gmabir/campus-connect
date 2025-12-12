<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Bus Route') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                
                <form action="{{ route('transport.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-bold text-black">Route Name</label>
                        <input type="text" name="route_name" class="w-full border rounded px-3 py-2" placeholder="e.g. Route A - Campus to Downtown" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-black">Timings (Comma separated)</label>
                        <input type="text" name="schedule_time" class="w-full border rounded px-3 py-2" placeholder="e.g. 8:00 AM, 10:30 AM, 2:00 PM" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-black">Stops List</label>
                        <textarea name="stops_list" rows="3" class="w-full border rounded px-3 py-2" placeholder="e.g. Main Gate -> Library -> Hostel -> City Center" required></textarea>
                    </div>

                    <button type="submit" class="bg-green-600 text-black font-bold px-6 py-2 rounded hover:text-white transition">
                        Save Route
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>