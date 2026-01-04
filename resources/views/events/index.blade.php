<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Campus Events</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
            <a href="{{ route('events.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
                Create Event
            </a>
        @endif

        <div class="bg-white rounded shadow">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left p-3">Title</th>
                        <th class="text-left p-3">Type</th>
                        <th class="text-left p-3">Date/Time</th>
                        <th class="text-left p-3">Location</th>
                        <th class="text-left p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $e)
                        <tr class="border-b">
                            <td class="p-3 font-semibold">{{ $e->title }}</td>
                            <td class="p-3">{{ ucfirst(str_replace('_',' ', $e->type)) }}</td>
                            <td class="p-3">
                                {{ $e->event_date }}
                                @if($e->event_time) - {{ $e->event_time }} @endif
                            </td>
                            <td class="p-3">{{ $e->location ?? '-' }}</td>
                            <td class="p-3 flex gap-2">
                                @php $isRegistered = in_array($e->id, $myRegistrations); @endphp

                                @if(!$isRegistered)
                                    <form method="POST" action="{{ route('events.register', $e->id) }}">
                                        @csrf
                                        <button class="px-3 py-1 bg-green-600 text-white rounded">
                                            Register
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('events.unregister', $e->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-gray-700 text-white rounded">
                                            Unregister
                                        </button>
                                    </form>
                                @endif

                                @if(auth()->user()->role === 'admin' || auth()->id() === $e->user_id)
                                    <form method="POST" action="{{ route('events.destroy', $e->id) }}"
                                          onsubmit="return confirm('Delete this event?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 text-white rounded">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-600">
                                No events available right now.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
