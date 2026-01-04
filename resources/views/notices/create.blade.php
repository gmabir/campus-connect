<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Publish Notice</h1>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('notices.store') }}" class="bg-white p-6 rounded shadow space-y-4">
            @csrf

            <div>
                <label class="block font-semibold mb-1">Title</label>
                <input name="title" class="w-full border rounded p-2" required />
            </div>

            <div>
                <label class="block font-semibold mb-1">Priority</label>
                <select name="priority" class="w-full border rounded p-2" required>
                    <option value="normal">Normal</option>
                    <option value="important">Important</option>
                    <option value="emergency">Emergency</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Expires On (optional)</label>
                <input type="date" name="expires_on" class="w-full border rounded p-2" />
            </div>

            <div>
                <label class="block font-semibold mb-1">Message</label>
                <textarea name="message" rows="6" class="w-full border rounded p-2" required></textarea>
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded">Publish</button>
                <a href="{{ route('notices.index') }}" class="px-4 py-2 bg-gray-300 rounded">Back</a>
            </div>
        </form>
    </div>
</x-app-layout>
