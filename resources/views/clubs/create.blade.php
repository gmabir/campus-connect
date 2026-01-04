<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Create Club</h1>

        <form method="POST" action="{{ route('clubs.store') }}"
              class="bg-white p-6 rounded shadow space-y-4">
            @csrf

            <div>
                <label class="block font-semibold">Club Name</label>
                <input name="name" class="w-full border rounded p-2" required />
            </div>

            <div>
                <label class="block font-semibold">Description</label>
                <textarea name="description" class="w-full border rounded p-2"></textarea>
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded">
                    Create
                </button>
                <a href="{{ route('clubs.index') }}"
                   class="px-4 py-2 bg-gray-300 rounded">Back</a>
            </div>
        </form>
    </div>
</x-app-layout>
