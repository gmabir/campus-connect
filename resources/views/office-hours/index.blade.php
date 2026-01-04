<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Office Hours</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        @if(auth()->user()->role === 'teacher')
            <a href="{{ route('office-hours.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
                Create Slot
            </a>
        @endif

        <div class="bg-white rounded shadow">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left p-3">Date</th>
                        <th class="text-left p-3">Time</th>
                        <th class="text-left p-3">Location</th>
                        <th class="text-left p-3">Capacity</th>
                        <th class="text-left p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($slots as $s)
                        @php
                            $booked = $bookingCounts[$s->id] ?? 0;
                            $isMine = auth()->id() === $s->teacher_id;
                            $isBookedByMe = in_array($s->id, $myBookings);
                            $isFull = $booked >= $s->capacity;
                        @endphp

                        <tr class="border-b">
                            <td class="p-3">{{ $s->slot_date }}</td>
                            <td class="p-3">{{ $s->slot_time }}</td>
                            <td class="p-3">{{ $s->location ?? '-' }}</td>
                            <td class="p-3">{{ $booked }} / {{ $s->capacity }}</td>

                            <td class="p-3 flex gap-2">
                                {{-- Student booking --}}
                                @if(auth()->user()->role === 'student')
                                    @if(!$isBookedByMe)
                                        <form method="POST" action="{{ route('office-hours.book', $s->id) }}">
                                            @csrf
                                            <input name="note" placeholder="Optional note" class="border rounded px-2 py-1 mr-2" />
                                            <button class="px-3 py-1 bg-green-600 text-white rounded" {{ $isFull ? 'disabled' : '' }}>
                                                Book
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('office-hours.cancel', $s->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1 bg-gray-700 text-white rounded">Cancel</button>
                                        </form>
                                    @endif
                                @endif

                                {{-- Teacher actions --}}
                                @if(auth()->user()->role === 'teacher' && $isMine)
                                    <a class="px-3 py-1 bg-indigo-600 text-white rounded"
                                       href="{{ route('office-hours.bookings', $s->id) }}">
                                        View Bookings
                                    </a>

                                    <form method="POST" action="{{ route('office-hours.destroy', $s->id) }}"
                                          onsubmit="return confirm('Delete this slot?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                                    </form>
                                @endif

                                {{-- Admin actions (optional) --}}
                                @if(auth()->user()->role === 'admin')
                                    <a class="px-3 py-1 bg-indigo-600 text-white rounded"
                                       href="{{ route('office-hours.bookings', $s->id) }}">
                                        View Bookings
                                    </a>
                                    <form method="POST" action="{{ route('office-hours.destroy', $s->id) }}"
                                          onsubmit="return confirm('Delete this slot?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-600">No slots available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
