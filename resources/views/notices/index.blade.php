<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Campus Notices</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('notices.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
                Publish Notice
            </a>
        @endif

        <div class="space-y-4">
            @forelse($notices as $n)
                @php
                    $box = 'bg-white';
                    if ($n->priority === 'important') $box = 'bg-yellow-50';
                    if ($n->priority === 'emergency') $box = 'bg-red-50';
                @endphp

                <div class="p-5 rounded shadow {{ $box }}">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="text-lg font-bold">{{ $n->title }}</div>
                            <div class="text-sm text-gray-600">
                                Priority: <b>{{ ucfirst($n->priority) }}</b>
                                @if($n->expires_on)
                                    | Expires: {{ $n->expires_on }}
                                @endif
                                | Posted: {{ $n->created_at->format('Y-m-d') }}
                            </div>
                        </div>

                        @if(auth()->user()->role === 'admin')
                            <form method="POST" action="{{ route('notices.destroy', $n->id) }}"
                                  onsubmit="return confirm('Delete this notice?');">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                            </form>
                        @endif
                    </div>

                    <div class="mt-3 text-gray-800 whitespace-pre-line">
                        {{ $n->message }}
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-600 bg-white rounded shadow">
                    No notices posted yet.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
