<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Create Poll</h1>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('polls.store') }}" class="bg-white p-6 rounded shadow space-y-4">
            @csrf

            <div>
                <label class="block font-semibold mb-1">Question</label>
                <input name="question" class="w-full border rounded p-2" required />
            </div>

            <div>
                <label class="block font-semibold mb-1">Expires On (optional)</label>
                <input type="date" name="expires_on" class="w-full border rounded p-2" />
            </div>

            <div>
                <label class="block font-semibold mb-2">Options (minimum 2)</label>
                <input name="options[]" class="w-full border rounded p-2 mb-2" placeholder="Option 1" required />
                <input name="options[]" class="w-full border rounded p-2 mb-2" placeholder="Option 2" required />
                <input name="options[]" class="w-full border rounded p-2 mb-2" placeholder="Option 3 (optional)" />
                <input name="options[]" class="w-full border rounded p-2" placeholder="Option 4 (optional)" />
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded">Create</button>
                <a href="{{ route('polls.index') }}" class="px-4 py-2 bg-gray-300 rounded">Back</a>
            </div>
        </form>
    </div>
</x-app-layout>
