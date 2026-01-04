<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Health & Wellness Appointments</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        <a href="{{ route('health.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
            Request Appointment
        </a>

        <div class="bg-white rounded shadow">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left p-3">Date</th>
                        <th class="text-left p-3">Time</th>
                        <th class="text-left p-3">Reason</th>
                        <th class="text-left p-3">Status</th>
                        <th class="text-left p-3">Medical Note</th>
                        <th class="text-left p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $a)
                        <tr class="border-b">
                            <td class="p-3">{{ $a->appointment_date }}</td>
                            <td class="p-3">{{ $a->appointment_time }}</td>
                            <td class="p-3">{{ $a->reason ?? '-' }}</td>
                            <td class="p-3 font-semibold">{{ ucfirst($a->status) }}</td>
                            <td class="p-3">{{ $a->doctor_note ?? '-' }}</td>

                            <td class="p-3">
                                {{-- Medical/Admin update --}}
                                @if(auth()->user()->role === 'medical' || auth()->user()->role === 'admin')
                                    <form method="POST" action="{{ route('health.updateStatus', $a->id) }}" class="flex gap-2 items-center">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="border rounded p-1">
                                            <option value="pending" @selected($a->status==='pending')>Pending</option>
                                            <option value="approved" @selected($a->status==='approved')>Approved</option>
                                            <option value="rejected" @selected($a->status==='rejected')>Rejected</option>
                                            <option value="completed" @selected($a->status==='completed')>Completed</option>
                                        </select>
                                        <input name="doctor_note" value="{{ $a->doctor_note }}" class="border rounded p-1" placeholder="Note (optional)" />
                                        <button class="px-3 py-1 bg-green-600 text-white rounded">Save</button>
                                    </form>
                                @endif

                                {{-- Student cancel pending --}}
                                @if(auth()->id() === $a->user_id && $a->status === 'pending')
                                    <form method="POST" action="{{ route('health.destroy', $a->id) }}" class="mt-2"
                                          onsubmit="return confirm('Cancel this appointment request?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 text-white rounded">Cancel</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-600">No appointments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
