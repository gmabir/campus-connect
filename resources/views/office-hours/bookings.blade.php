<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-2">Slot Bookings</h1>

        <div class="mb-4 text-gray-700">
            <div><b>Date:</b> {{ $slot->slot_date }}</div>
            <div><b>Time:</b> {{ $slot->slot_time }}</div>
            <div><b>Location:</b> {{ $slot->location ?? '-' }}</div>
        </div>

        <a href="{{ route('office-hours.index') }}" class="inline-block mb-4 px-4 py-2 bg-gray-300 rounded">Back</a>

        <div class="bg-white rounded shadow">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left p-3">Student ID</th>
                        <th class="text-left p-3">Note</th>
                        <th class="text-left p-3">Booked At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $b)
                        <tr class="border-b">
                            <td class="p-3">User #{{ $b->student_id }}</td>
                            <td class="p-3">{{ $b->note ?? '-' }}</td>
                            <td class="p-3">{{ $b->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-6 text-center text-gray-600">No bookings yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
