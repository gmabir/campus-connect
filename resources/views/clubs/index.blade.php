<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Student Clubs</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('clubs.create') }}"
               class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
                Create Club
            </a>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($clubs as $club)
                <div class="bg-white p-5 rounded shadow">
                    <h2 class="text-lg font-bold">{{ $club->name }}</h2>
                    <p class="text-gray-600 mb-3">{{ $club->description }}</p>

                    <div class="flex gap-2">
                        @if(auth()->user()->role === 'student')
                            @if(in_array($club->id, $joinedClubIds))
                                <form method="POST" action="{{ route('clubs.leave', $club->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-gray-600 text-white rounded">
                                        Leave
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('clubs.join', $club->id) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-green-600 text-white rounded">
                                        Join
                                    </button>
                                </form>
                            @endif
                        @endif

                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('clubs.members', $club->id) }}"
                               class="px-3 py-1 bg-indigo-600 text-white rounded">
                                View Members
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
