<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Repository</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('repository.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                Upload New
            </a>

            <form method="GET" action="{{ route('repository.index') }}" class="flex items-center gap-2">
                <select name="type" class="border rounded p-2">
                    <option value="">All Types</option>
                    <option value="thesis" @selected(request('type')==='thesis')>Thesis</option>
                    <option value="internship" @selected(request('type')==='internship')>Internship</option>
                    <option value="project" @selected(request('type')==='project')>Project</option>
                </select>
                <button class="px-3 py-2 bg-gray-800 text-white rounded">Filter</button>
            </form>
        </div>

        <div class="bg-white rounded shadow">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left p-3">Type</th>
                        <th class="text-left p-3">Title</th>
                        <th class="text-left p-3">Uploaded By</th>
                        <th class="text-left p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $s)
                        <tr class="border-b">
                            <td class="p-3">{{ ucfirst($s->type) }}</td>
                            <td class="p-3">
                                <div class="font-semibold">{{ $s->title }}</div>
                                <div class="text-sm text-gray-600">{{ $s->original_name }}</div>
                            </td>
                            <td class="p-3">User #{{ $s->user_id }}</td>
                            <td class="p-3 flex gap-2">
                                <a class="px-3 py-1 bg-green-600 text-white rounded"
                                   href="{{ route('repository.download', $s->id) }}">
                                    Download
                                </a>

                                @if(auth()->user()->role === 'admin' || auth()->id() === $s->user_id)
                                    <form method="POST" action="{{ route('repository.destroy', $s->id) }}"
                                          onsubmit="return confirm('Delete this submission?');">
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
                            <td colspan="4" class="p-6 text-center text-gray-600">
                                No submissions yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
