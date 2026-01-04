<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Event Photo Gallery</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="flex flex-wrap items-center gap-3 mb-4">
            <a href="{{ route('gallery.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                Upload Photo
            </a>

            <form method="GET" action="{{ route('gallery.index') }}" class="flex items-center gap-2">
                <select name="event_id" class="border rounded p-2">
                    <option value="">All Events</option>
                    @foreach($events as $e)
                        <option value="{{ $e->id }}" @selected(request('event_id')==$e->id)>
                            {{ $e->title }}
                        </option>
                    @endforeach
                </select>
                <button class="px-3 py-2 bg-gray-800 text-white rounded">Filter</button>
            </form>
        </div>

        @if($photos->count() === 0)
            <div class="bg-white p-6 rounded shadow text-center text-gray-600">
                No photos uploaded yet.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($photos as $p)
                    <div class="bg-white rounded shadow overflow-hidden">
                        <img src="{{ asset('storage/'.$p->image_path) }}" class="w-full h-56 object-cover" />

                        <div class="p-4">
                            @if($p->caption)
                                <div class="font-semibold">{{ $p->caption }}</div>
                            @endif

                            <div class="text-sm text-gray-600">
                                Uploaded: {{ $p->created_at->format('Y-m-d') }}
                                @if($p->event_id)
                                    | Event ID: {{ $p->event_id }}
                                @endif
                            </div>

                            @if(auth()->user()->role === 'admin' || auth()->id() === $p->user_id)
                                <form method="POST" action="{{ route('gallery.destroy', $p->id) }}"
                                      class="mt-3" onsubmit="return confirm('Delete this photo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-600 text-white rounded">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
s