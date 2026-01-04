<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Create Event</h1>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('events.store') }}" class="bg-white p-6 rounded shadow space-y-4">
            @csrf

            <div>
                <label class="block font-semibold mb-1">Title</label>
                <input name="title" class="w-full border rounded p-2" required />
            </div>

            <div>
                <label class="block font-semibold mb-1">Type</label>
                <select name="type" class="w-full border rounded p-2" required>
                    <option value="seminar">Seminar</option>
                    <option value="workshop">Workshop</option>
                    <option value="cultural">Cultural</option>
                    <option value="guest_lecture">Guest Lecture</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Description</label>
                <textarea name="description" class="w-full border rounded p-2" rows="4"></textarea>
            </div>

            <div>
                <label class="block font-semibold mb-1">Location</label>
                <input name="location" class="w-full border rounded p-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-1">
                    <label class="block font-semibold mb-1">Date</label>
                    <input type="date" name="event_date" class="w-full border rounded p-2" required />
                </div>
                <div class="md:col-span-1">
                    <label class="block font-semibold mb-1">Time</label>
                    <input name="event_time" placeholder="e.g. 10:00 AM" class="w-full border rounded p-2" />
                </div>
                <div class="md:col-span-1">
                    <label class="block font-semibold mb-1">Capacity</label>
                    <input type="number" name="capacity" min="1" class="w-full border rounded p-2" />
                </div>
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded">Create</button>
                <a href="{{ route('events.index') }}" class="px-4 py-2 bg-gray-300 rounded">Back</a>
            </div>
        </form>
    </div>
</x-app-layout>
