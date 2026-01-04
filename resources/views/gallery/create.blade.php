<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Upload Photo</h1>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('gallery.store') }}" enctype="multipart/form-data"
              class="bg-white p-6 rounded shadow space-y-4">
            @csrf

            <div>
                <label class="block font-semibold mb-1">Select Event (optional)</label>
                <select name="event_id" class="w-full border rounded p-2">
                    <option value="">No Event</option>
                    @foreach($events as $e)
                        <option value="{{ $e->id }}">{{ $e->title }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Caption (optional)</label>
                <input name="caption" class="w-full border rounded p-2" placeholder="e.g. Workshop moments" />
            </div>

            <div>
                <label class="block font-semibold mb-1">Upload Image</label>
                <input type="file" name="image" class="w-full border rounded p-2" required />
                <div class="text-sm text-gray-600 mt-1">Max 5MB. JPG/PNG/WebP allowed.</div>
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded">Upload</button>
                <a href="{{ route('gallery.index') }}" class="px-4 py-2 bg-gray-300 rounded">Back</a>
            </div>
        </form>
    </div>
</x-app-layout>
