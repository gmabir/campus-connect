<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Create Office Hour Slot</h1>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('office-hours.store') }}" class="bg-white p-6 rounded shadow space-y-4">
            @csrf

            <div>
                <label class="block font-semibold mb-1">Date</label>
                <input type="date" name="slot_date" class="w-full border rounded p-2" required />
            </div>

            <div>
                <label class="block font-semibold mb-1">Time</label>
                <input name="slot_time" placeholder="e.g. 2:00 PM - 3:00 PM" class="w-full border rounded p-2" required />
            </div>

            <div>
                <label class="block font-semibold mb-1">Location (optional)</label>
                <input name="location" class="w-full border rounded p-2" />
            </div>

            <div>
                <label class="block font-semibold mb-1">Capacity</label>
                <input type="number" name="capacity" min="1" max="20" value="1" class="w-full border rounded p-2" required />
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded">Create</button>
                <a href="{{ route('office-hours.index') }}" class="px-4 py-2 bg-gray-300 rounded">Back</a>
            </div>
        </form>
    </div>
</x-app-layout>
