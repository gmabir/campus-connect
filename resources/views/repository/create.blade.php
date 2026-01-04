<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Upload Submission</h1>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('repository.store') }}" enctype="multipart/form-data"
              class="bg-white p-6 rounded shadow space-y-4">
            @csrf

            <div>
                <label class="block font-semibold mb-1">Type</label>
                <select name="type" class="w-full border rounded p-2" required>
                    <option value="thesis">Thesis</option>
                    <option value="internship">Internship</option>
                    <option value="project">Project</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Title</label>
                <input name="title" class="w-full border rounded p-2" required />
            </div>

            <div>
                <label class="block font-semibold mb-1">Description (optional)</label>
                <textarea name="description" class="w-full border rounded p-2" rows="4"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Department (optional)</label>
                    <input name="department" class="w-full border rounded p-2" />
                </div>
                <div>
                    <label class="block font-semibold mb-1">Batch (optional)</label>
                    <input name="batch" class="w-full border rounded p-2" />
                </div>
            </div>

            <div>
                <label class="block font-semibold mb-1">Supervisor Name (optional)</label>
                <input name="supervisor_name" class="w-full border rounded p-2" />
            </div>

            <div>
                <label class="block font-semibold mb-1">Upload File (PDF/DOC/DOCX/ZIP)</label>
                <input type="file" name="file" class="w-full border rounded p-2" required />
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded">Upload</button>
                <a href="{{ route('repository.index') }}" class="px-4 py-2 bg-gray-300 rounded">Back</a>
            </div>
        </form>
    </div>
</x-app-layout>
