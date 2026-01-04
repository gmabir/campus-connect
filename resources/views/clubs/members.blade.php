<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">
            Members – {{ $club->name }}
        </h1>

        <a href="{{ route('clubs.index') }}"
           class="inline-block mb-4 px-4 py-2 bg-gray-300 rounded">Back</a>

        <div class="bg-white rounded shadow">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="p-3 text-left">User ID</th>
                        <th class="p-3 text-left">Joined At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $m)
                        <tr class="border-b">
                            <td class="p-3">User #{{ $m->user_id }}</td>
                            <td class="p-3">{{ $m->joined_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
